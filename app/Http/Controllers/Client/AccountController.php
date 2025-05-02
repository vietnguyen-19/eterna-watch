<?php

namespace App\Http\Controllers\Client;

use App\Helpers\ImageHandler;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StatusHistory;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    public function editAccount()
    {
        return view('client.account.partials.edit_account');
    }


    public function rePassword()
    {
        return view('client.account.partials.re_password');
    }

    public function updatePass(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Mật khẩu mới xác nhận không khớp.',
        ]);


        // Lấy user hiện tại
        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Cập nhật mật khẩu mới
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Mật khẩu đã được cập nhật thành công.');
    }



    public function order()
    {
        $orders = Order::where('user_id', Auth::id())->with(['orderItems.productVariant.product', 'orderItems.productVariant.attributeValues.nameValue', 'entity', 'payment', 'voucher'])->latest()->get();
        return view('client.account.partials.order', compact('orders'));
    }
    public function orderDetail($id)
    {
        $order = Order::with(['refund.refundItems', 'orderItems.productVariant.product', 'orderItems.productVariant.attributeValues.nameValue', 'entity', 'payment', 'voucher', 'statusHistories'])->findOrFail($id);
        return view('client.account.partials.order-detail', compact('order'));
    }
    public function cancelOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(["success" => false, "message" => "Đơn hàng không tồn tại!"], 404);
        }

        // Chỉ chặn hủy nếu đơn hàng đã được vận chuyển hoặc hoàn tất
        if (!in_array($order->status, ["pending", "confirmed"])) {
            return response()->json(["success" => false, "message" => "Không thể hủy đơn hàng khi vì đã giao cho bên vận chuyển"], 400);
        }
        StatusHistory::create([
            'entity_id' => $order->id,
            'entity_type' => 'order',
            'old_status' => $order->status,
            'new_status' => 'cancelled',
            'changed_by' => $order->user->id,
            'changed_at' => now(),
        ]);
        $order->status = "cancelled";
        $order->save();


        return response()->json(["success" => true, "message" => "Đơn hàng đã được hủy thành công!"]);
    }


    public function update(Request $request)
    {
       
        $user = Auth::user();

        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string',
            'gender' => 'required|in:0,1',
            'avatar' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = ImageHandler::updateImage($request->file('avatar'), Auth::user()->avatar, 'avatars');
        } else {
            $avatarPath = $request->avatar_hidden ?? Auth::user()->avatar;
        }
        // Cập nhật thông tin tài khoản
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'avatar' => $avatarPath,
        ]);

        // Cập nhật địa chỉ mặc định nếu tồn tại

        return redirect()->route('account.edit')->with('success', 'Cập nhật thông tin người dùng thành công!');
    }
}
