<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    public function editAccount()
    {
        return view('client.account.edit_account');
    }


    public function rePassword()
    {
        return view('client.account.re_password');
    }

    public function updatePass(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'], // 'confirmed' kiểm tra với new_password_confirmation
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
        return view('client.account.order', compact('orders'));
    }
    public function orderDetail($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'orderItems.productVariant.attributeValues.nameValue', 'entity', 'payment', 'voucher'])->findOrFail($id);
        return view('client.account.order-detail', compact('order'));
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

        $order->status = "Cancelled";
        $order->save();

        return response()->json(["success" => true, "message" => "Đơn hàng đã được hủy thành công!"]);
    }

    public function uploadImage(Request $request)
    {


        if (!$request->hasFile('avatar')) {
            return response()->json(['success' => false, 'message' => 'No image uploaded'], 400);
        }

        $file = $request->file('avatar');

        if (!$file->isValid()) {
            return response()->json(['success' => false, 'message' => 'Invalid image'], 400);
        }

        // Tạo tên file mới để tránh trùng
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Đường dẫn lưu file vào thư mục public/storage/avatars
        $destinationPath = public_path('storage/avatars');

        // Kiểm tra nếu thư mục chưa tồn tại thì tạo mới
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Di chuyển file vào thư mục đích
        $file->move($destinationPath, $fileName);

        // Trả về đường dẫn public có thể truy cập ảnh
        $publicPath =  'avatars/' . $fileName;

        return response()->json([
            'success' => true,
            'message' => 'Upload thành công',
            'path' => $publicPath
        ]);
    }

    public function removeImage(Request $request)
    {
        // Lấy dữ liệu từ body của request
        $filePath = $request->getContent();

        // Kiểm tra xem dữ liệu có phải JSON không
        $decodedData = json_decode($filePath, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            // Nếu là JSON, lấy giá trị từ mảng (giả sử có key "path")
            $filePath = $decodedData['path'] ?? null;
        }

        if (empty($filePath)) {
            return response()->json(['success' => false, 'message' => 'File path is empty'], 400);
        }

        // Đường dẫn đầy đủ tới file trong thư mục storage
        $storagePath = public_path('storage/' . $filePath);

        if (file_exists($storagePath)) {
            unlink($storagePath);
            return response()->json(['success' => true, 'message' => 'File deleted']);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
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
            'avatar' => 'nullable|string', // Avatar là một URL hoặc đường dẫn chuỗi
            'street_address' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        // Cập nhật thông tin tài khoản
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'avatar' => $request->avatar_hidden, // Avatar là một chuỗi URL hoặc đường dẫn
        ]);

        // Cập nhật địa chỉ mặc định nếu tồn tại
        if ($user->defaultAddress) {
            $user->defaultAddress->update([
                'street_address' => $request->street_address,
                'district' => $request->district,
                'city' => $request->city,
                'country' => $request->country,
            ]);
        }

        return redirect()->route('account.edit')->with('success', 'Cập nhật thông tin thành công!');
    }
}
