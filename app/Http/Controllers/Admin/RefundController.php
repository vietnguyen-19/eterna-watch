<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\StatusHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tham số status từ request, mặc định là 'all'
        $status = $request->input('status', 'all');

        // Khởi tạo query với eager loading để tối ưu
        $query = Refund::with('order.user');

        // Lọc theo trạng thái nếu không phải "all"
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Lấy danh sách refunds, sắp xếp mới nhất trước (dựa trên created_at)
        $refunds = $query->latest('created_at')->get();

        // Đếm số lượng refunds theo trạng thái
        $statusCounts = [
            'all' => Refund::count(),
            'pending' => Refund::where('status', 'pending')->count(),
            'approved' => Refund::where('status', 'approved')->count(),
            'rejected' => Refund::where('status', 'rejected')->count(),
        ];

        // Trả về view với dữ liệu
        return view('admin.refunds.index', compact('refunds', 'status', 'statusCounts'));
    }

    public function show(Refund $refund)
    {

        // Nạp các quan hệ cần thiết để tránh truy vấn lặp
        $refund->load([
            'imageRefunds',
            'refundItems.orderItem.productVariant.product',
            'order.user',
            'order.address',
        ]);

        // Lấy danh sách lịch sử trạng thái của đơn hoàn hàng
        $statusHistories = StatusHistory::where('entity_id', $refund->id)
            ->where('entity_type', 'refund')
            ->orderByDesc('changed_at')
            ->get();

        // Trả về view hiển thị chi tiết đơn hoàn hàng
        return view('admin.refunds.show', compact('refund', 'statusHistories'));
    }

    public function approve(Refund $refund)
    {

        if ($refund->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý.');
        }

        // Cập nhật kho
        foreach ($refund->refundItems as $item) {
            $variant = $item->orderItem->productVariant;
            $variant->stock += $item->quantity;
            $variant->save();
        }

        // Ghi lại trạng thái cũ
        $oldStatus = $refund->status;

        // Cập nhật trạng thái mới
        $refund->status = 'approved';
        $refund->updated_at = now();
        $refund->save();

        // Ghi nhận lịch sử trạng thái
        StatusHistory::create([
            'entity_id'   => $refund->id,
            'entity_type' => 'refund',
            'old_status'  => $oldStatus,
            'new_status'  => 'approved',
            'changed_by'  => auth()->id(),
            'changed_at'  => Carbon::now(),
        ]);

        return redirect()->route('admin.refunds.show', $refund->id)
            ->with('success', 'Yêu cầu đã được chấp nhận và cập nhật kho.');
    }
    public function reject(Request $request, Refund $refund)
    {
        if ($refund->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý.');
        }

        // Ghi lại trạng thái cũ
        $oldStatus = $refund->status;

        $refund->status = 'rejected';
        $refund->rejected_reason = $request->input('rejected_reason');
        $refund->save();

        // Ghi nhận lịch sử trạng thái
        StatusHistory::create([
            'entity_id'   => $refund->id,
            'entity_type' => 'refund',
            'old_status'  => $oldStatus,
            'new_status'  => 'rejected',
            'changed_by'  => auth()->id(),
            'note'  => $request->input('reason'),
            'changed_at'  => Carbon::now(),
        ]);

        return redirect()->route('admin.refunds.show', $refund->id)
            ->with('warning', 'Yêu cầu đã bị từ chối.');
    }

    public function approveVNPayRefund(Request $request, $refundId)
    {
        $refund = Refund::with(['order.payment', 'refundItems.orderItem'])->findOrFail($refundId);

        if ($refund->status !== 'pending') {
            Log::warning('Yêu cầu hoàn tiền không ở trạng thái chờ', [
                'refund_id' => $refundId,
                'status' => $refund->status,
            ]);
            return back()->with('error', 'Yêu cầu hoàn tiền không hợp lệ.');
        }

        if ($refund->order->payment_method !== 'vnpay') {
            Log::warning('Đơn hàng không dùng VNPay', [
                'refund_id' => $refundId,
                'payment_method' => $refund->order->payment_method,
            ]);
            return back()->with('error', 'Phương thức thanh toán không hợp lệ.');
        }

        $payment = $refund->order->payment;

        if (empty($payment->txn_ref) || empty($payment->transaction_no)) {
            Log::error('Thiếu mã giao dịch VNPay', [
                'refund_id' => $refundId,
                'txn_ref' => $payment->txn_ref,
                'transaction_no' => $payment->transaction_no,
            ]);
            return back()->with('error', 'Không đủ thông tin giao dịch VNPay.');
        }

        $vnp_TmnCode = "V55UHDTK";
        $vnp_HashSecret = "BLQMOCDUF9OSQ9K9JWNYJTZE8DVYWH3H";
        $vnp_ApiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
        $totalAmount = (int)($refund->total_refund_amount * 100);

        if ($totalAmount > $payment->amount * 100) {
            Log::error('Số tiền hoàn vượt mức', [
                'refund_id' => $refundId,
                'refund' => $totalAmount,
                'original' => $payment->amount * 100,
            ]);
            return back()->with('error', 'Số tiền hoàn không hợp lệ.');
        }

        $inputData = [
            'vnp_RequestId'       => now()->format('YmdHis') . rand(1000, 9999),
            'vnp_Version'         => '2.1.0',
            'vnp_Command'         => 'refund',
            'vnp_TmnCode'         => $vnp_TmnCode,
            'vnp_TransactionType' => '03',
            'vnp_TxnRef'          => $payment->txn_ref,
            'vnp_Amount'          => $totalAmount,
            'vnp_OrderInfo'       => 'Hoàn tiền đơn #' . $refund->order->id,
            'vnp_TransactionNo'   => $payment->transaction_no,
            'vnp_TransactionDate' => $payment->transaction_date ?? now()->format('YmdHis'),
            'vnp_CreateBy'        => Auth::user()->name ?? 'system',
            'vnp_CreateDate'      => now()->format('YmdHis'),
            'vnp_IpAddr'          => $request->ip(),
        ];

        ksort($inputData);
        $hashData = urldecode(http_build_query($inputData));
        $inputData['vnp_SecureHash'] = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        Log::info('Gửi yêu cầu hoàn tiền VNPay', ['refund_id' => $refundId, 'data' => $inputData]);

        try {
            DB::beginTransaction();

            // Xử lý phản hồi VNPay
            if (app()->environment('local', 'testing')) {
                $isSuccess = true;
                $result = [
                    'vnp_ResponseCode'      => $isSuccess ? '00' : '91',
                    'vnp_Message'           => $isSuccess ? 'Thành công (giả lập)' : 'Thất bại',
                    'vnp_TransactionNo'     => (string)(random_int(14935123, 15935123)),
                    'vnp_TxnRef'            => $inputData['vnp_TxnRef'],
                    'vnp_Amount'            => $inputData['vnp_Amount'],
                    'vnp_TransactionDate'   => now()->format('YmdHis'),
                    'vnp_TransactionStatus' => $isSuccess ? '00' : '91',
                    'vnp_RequestId'         => $inputData['vnp_RequestId'],
                    'vnp_TmnCode'           => $vnp_TmnCode,
                    'vnp_BankCode'          => 'NCB',
                ];

                ksort($result);
                $hashData = urldecode(http_build_query($result));
                $result['vnp_SecureHash'] = hash_hmac('sha512', $hashData, $vnp_HashSecret);

                Log::info('Phản hồi giả lập VNPay', ['refund_id' => $refundId, 'response' => $result]);
            } else {
                $response = Http::timeout(30)->asForm()->post($vnp_ApiUrl, $inputData);
                $result = $response->json();
                Log::info('Phản hồi thực tế VNPay', ['refund_id' => $refundId, 'response' => $result]);
            }

            // Kiểm tra các trường cần thiết
            if (!isset($result['vnp_TransactionNo']) || !isset($result['vnp_ResponseCode'])) {
                Log::error('Phản hồi VNPay thiếu trường cần thiết', [
                    'refund_id' => $refundId,
                    'response' => $result,
                ]);
                throw new \Exception('Phản hồi từ VNPay không hợp lệ: Thiếu vnp_TransactionNo hoặc vnp_ResponseCode.');
            }

            $vnpTransactionNo = $result['vnp_TransactionNo'];
            $vnpResponseCode = $result['vnp_ResponseCode'];

            if ($vnpResponseCode === '00' && $vnpTransactionNo) {
                $refund->update([
                    'status'              => 'approved',
                    'vnp_transaction_no'  => $vnpTransactionNo,
                    'vnp_response_code'   => $vnpResponseCode,
                    'vnp_request_id'      => $result['vnp_RequestId'] ?? $inputData['vnp_RequestId'],
                    'vnp_amount'          => ($result['vnp_Amount'] ?? $totalAmount) / 100,
                    'vnp_bank_code'       => $result['vnp_BankCode'] ?? 'NCB',
                    'refunded_at'         => now(),
                ]);
                Mail::to($refund->order->user->email)->send(new \App\Mail\RefundApprovedMail($refund));

                Log::info('Refund sau khi cập nhật', ['refund' => $refund->fresh()->toArray()]);

                StatusHistory::create([
                    'entity_id'    => $refundId,
                    'entity_type'  => 'refund',
                    'old_status'   => 'pending',
                    'new_status'   => 'approved',
                    'changed_by'   => Auth::id() ?? 'system',
                    'changed_at'   => now(),
                ]);

                DB::commit();
                return back()->with('success', 'Hoàn tiền VNPay thành công.');
            }

            throw new \Exception($result['vnp_Message'] ?? 'Hoàn tiền thất bại.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi hoàn tiền VNPay', [
                'refund_id' => $refundId,
                'message' => $e->getMessage(),
            ]);
            return back()->with('error', 'Hoàn tiền thất bại: ' . $e->getMessage());
        }
    }
    public function approveCodRefund(Request $request, $refundId)
    {
        // Kiểm tra quyền admin (giả định đã có middleware)

        $refund = Refund::with(['order', 'refundItems.orderItem'])->findOrFail($refundId);

        // Kiểm tra trạng thái hoàn tiền
        if ($refund->status !== 'pending') {
            Log::warning('Yêu cầu hoàn tiền không ở trạng thái chờ xử lý', [
                'refund_id' => $refundId,
                'current_status' => $refund->status,
            ]);
            return back()->with('error', 'Yêu cầu hoàn tiền không ở trạng thái chờ xử lý.');
        }

        // Kiểm tra phương thức thanh toán
        if ($refund->order->payment_method !== 'cash') {
            Log::warning('Đơn hàng không sử dụng phương thức thanh toán COD', [
                'refund_id' => $refundId,
                'payment_method' => $refund->order->payment_method,
            ]);
            return back()->with('error', 'Đơn hàng không sử dụng phương thức thanh toán COD.');
        }

        DB::beginTransaction();
        try {
            // Cập nhật trạng thái hoàn tiền
            $refund->status = 'approved';
            $refund->updated_at = now();
            $refund->save();

            // Ghi lịch sử trạng thái
            StatusHistory::create([
                'entity_id' => $refundId,
                'entity_type' => 'refund',
                'old_status' => 'pending',
                'new_status' => 'approved',
                'changed_by' => Auth::id() ?? 'system',
                'changed_at' => now(),
            ]);

            Log::info('Hoàn tiền COD thành công (môi trường thử nghiệm)', [
                'refund_id' => $refundId,
                'order_id' => $refund->order->id,
                'amount' => $refund->total_refund_amount,
            ]);
            Mail::to($refund->order->user->email)->send(new \App\Mail\RefundApprovedMail($refund));

            DB::commit();
            return back()->with('success', 'Hoàn tiền COD thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi xử lý hoàn tiền COD', [
                'refund_id' => $refundId,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            DB::rollBack();
            return back()->with('error', 'Lỗi hệ thống khi xử lý hoàn tiền COD: ' . $e->getMessage());
        }
    }
}
