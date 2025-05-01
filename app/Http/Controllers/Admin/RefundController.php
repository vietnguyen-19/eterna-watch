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

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        $query = Refund::with('order.user');

        // Lọc theo trạng thái nếu không phải "all"
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Lấy danh sách refund theo điều kiện
        $refunds = $query->latest()->get();

        // Đếm số lượng từng loại trạng thái
        $statusCounts = [
            'all' => Refund::count(),
            'pending' => Refund::where('status', 'pending')->count(),
            'approved' => Refund::where('status', 'approved')->count(),
            'rejected' => Refund::where('status', 'rejected')->count(),
        ];

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
        // Kiểm tra quyền admin (giả định đã có middleware)

        $refund = Refund::with(['order.payment', 'refundItems.orderItem'])->findOrFail($refundId);

        // Kiểm tra trạng thái hoàn tiền
        if ($refund->status !== 'pending') {
            Log::warning('Yêu cầu hoàn tiền không ở trạng thái chờ xử lý', [
                'refund_id' => $refundId,
                'current_status' => $refund->status,
            ]);
            return back()->with('error', 'Yêu cầu hoàn tiền không ở trạng thái chờ xử lý.');
        }

        // Kiểm tra phương thức thanh toán
        if ($refund->order->payment_method !== 'vnpay') {
            Log::warning('Đơn hàng không sử dụng phương thức thanh toán VNPay', [
                'refund_id' => $refundId,
                'payment_method' => $refund->order->payment_method,
            ]);
            return back()->with('error', 'Đơn hàng không sử dụng phương thức thanh toán VNPay.');
        }

        DB::beginTransaction();
        try {
            $payment = $refund->order->payment;
            $totalRefundAmount = $refund->total_refund_amount * 100; // Chuyển sang đơn vị của VNPay

            // Kiểm tra số tiền hoàn
            if ($totalRefundAmount > $payment->amount * 100) {
                Log::error('Số tiền hoàn vượt quá số tiền giao dịch gốc', [
                    'refund_id' => $refundId,
                    'total_refund_amount' => $totalRefundAmount,
                    'original_amount' => $payment->amount * 100,
                ]);
                DB::rollBack();
                return back()->with('error', 'Số tiền hoàn vượt quá số tiền giao dịch gốc.');
            }

            // Kiểm tra vnp_TxnRef và vnp_TransactionNo
            if (empty($payment->txn_ref) || empty($payment->transaction_no)) {
                Log::error('Thiếu thông tin giao dịch VNPay', [
                    'refund_id' => $refundId,
                    'txn_ref' => $payment->txn_ref,
                    'transaction_no' => $payment->transaction_no,
                ]);
                DB::rollBack();
                return back()->with('error', 'Thiếu mã giao dịch VNPay (txn_ref hoặc transaction_no).');
            }

            // Ghi log thông tin payment để debug
            Log::info('Thông tin giao dịch từ bảng payments', [
                'refund_id' => $refundId,
                'transaction_id' => $payment->transaction_id,
                'txn_ref' => $payment->txn_ref,
                'transaction_no' => $payment->transaction_no,
                'transaction_date' => $payment->transaction_date,
                'amount' => $payment->amount,
            ]);

            // Thông tin VNPay Sandbox
            $vnp_TmnCode = "V55UHDTK";
            $vnp_HashSecret = "BLQMOCDUF9OSQ9K9JWNYJTZE8DVYWH3H";
            $vnp_ApiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";

            // Dữ liệu yêu cầu refund
            $inputData = [
                'vnp_RequestId'       => now()->format('YmdHis') . rand(1000, 9999),
                'vnp_Version'         => '2.1.0',
                'vnp_Command'         => 'refund',
                'vnp_TmnCode'         => $vnp_TmnCode,
                'vnp_TransactionType' => '03', // Hoàn một phần
                'vnp_TxnRef'          => $payment->txn_ref,
                'vnp_Amount'          => (int)$totalRefundAmount,
                'vnp_OrderInfo'       => 'Hoàn tiền một phần đơn #' . $refund->order->id,
                'vnp_TransactionNo'   => $payment->transaction_no,
                'vnp_TransactionDate' => $payment->transaction_date ?? now()->format('YmdHis'),
                'vnp_CreateBy'        => Auth::user()->name ?? 'system',
                'vnp_CreateDate'      => now()->format('YmdHis'),
                'vnp_IpAddr'          => $request->ip(),
            ];

            // Ghi log thông tin yêu cầu
            Log::info('Thông tin yêu cầu refund VNPay (môi trường thử nghiệm)', [
                'refund_id' => $refundId,
                'txn_ref' => $inputData['vnp_TxnRef'],
                'transaction_no' => $inputData['vnp_TransactionNo'],
                'amount' => $inputData['vnp_Amount'],
                'transaction_date' => $inputData['vnp_TransactionDate'],
            ]);

            // Tạo secure hash
            ksort($inputData);
            $hashData = urldecode(http_build_query($inputData));
            $inputData['vnp_SecureHash'] = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            // Giả lập phản hồi trong môi trường thử nghiệm
            if (app()->environment('local', 'testing')) {
                Log::warning('Giả lập phản hồi VNPay trong môi trường thử nghiệm', [
                    'refund_id' => $refundId,
                    'input_data' => $inputData,
                ]);
                $result = [
                    'vnp_ResponseCode' => '00',
                    'vnp_Message' => 'Refund successful (mocked response)',
                    'vnp_TransactionNo' => $inputData['vnp_TransactionNo'],
                    'vnp_TxnRef' => $inputData['vnp_TxnRef'],
                ];
            } else {
                // Gửi yêu cầu đến VNPay với timeout dài hơn
                $maxRetries = 3;
                $retryCount = 0;
                $response = null;

                while ($retryCount < $maxRetries) {
                    try {
                        $response = Http::timeout(30)->asForm()->post($vnp_ApiUrl, $inputData);
                        break;
                    } catch (\Exception $e) {
                        $retryCount++;
                        Log::warning('Lỗi kết nối VNPay, thử lại lần ' . $retryCount, [
                            'refund_id' => $refundId,
                            'error' => $e->getMessage(),
                        ]);
                        if ($retryCount === $maxRetries) {
                            Log::error('Hoàn tiền VNPay thất bại sau khi thử lại', [
                                'refund_id' => $refundId,
                                'error' => $e->getMessage(),
                                'input_data' => $inputData,
                            ]);
                            DB::rollBack();
                            return back()->with('error', 'Lỗi kết nối VNPay: ' . $e->getMessage());
                        }
                        sleep(3);
                    }
                }

                $result = $response->json();

                // Ghi log phản hồi từ VNPay
                Log::info('Phản hồi từ VNPay (môi trường thử nghiệm)', [
                    'refund_id' => $refundId,
                    'response' => $result,
                    'input_data' => $inputData,
                ]);
            }

            // Kiểm tra phản hồi không hợp lệ
            if (!$result || !is_array($result)) {
                Log::error('Phản hồi VNPay không hợp lệ (null hoặc không phải mảng)', [
                    'refund_id' => $refundId,
                    'response' => $result,
                    'input_data' => $inputData,
                ]);
                DB::rollBack();
                return back()->with('error', 'Lỗi VNPay: Phản hồi không hợp lệ.');
            }

            if (!isset($result['vnp_ResponseCode'])) {
                Log::error('Phản hồi VNPay thiếu ResponseCode', [
                    'refund_id' => $refundId,
                    'response' => $result,
                    'input_data' => $inputData,
                ]);
                DB::rollBack();
                return back()->with('error', 'Lỗi VNPay: Phản hồi thiếu mã phản hồi.');
            }

            if ($result['vnp_ResponseCode'] === '00') {
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

                Log::info('Hoàn tiền VNPay thành công (môi trường thử nghiệm)', [
                    'refund_id' => $refundId,
                    'order_id' => $refund->order->id,
                    'amount' => $totalRefundAmount,
                    'mocked' => app()->environment('local', 'testing') ? true : false,
                ]);

                DB::commit();
                return back()->with('success', 'Hoàn tiền VNPay thành công.');
            } else {
                Log::error('Hoàn tiền VNPay thất bại', [
                    'refund_id' => $refundId,
                    'response_code' => $result['vnp_ResponseCode'],
                    'message' => $result['vnp_Message'] ?? 'Không có thông báo',
                    'response' => $result,
                ]);
                DB::rollBack();
                return back()->with('error', 'Hoàn tiền thất bại: ' . ($result['vnp_Message'] ?? 'Lỗi không xác định.'));
            }
        } catch (\Exception $e) {
            Log::error('Lỗi hệ thống khi xử lý hoàn tiền VNPay', [
                'refund_id' => $refundId,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            DB::rollBack();
            return back()->with('error', 'Lỗi hệ thống khi xử lý hoàn tiền: ' . $e->getMessage());
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
