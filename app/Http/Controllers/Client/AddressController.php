<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // Trang tạo địa chỉ mới
    public function create()
    {
        return view('client.account.partials.add_address');
    }

    // Lưu địa chỉ mới
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'street_address' => 'required',
            'ward' => 'required',
            'district' => 'required',
            'city' => 'required',
            'is_default' => 'boolean',
            'note' => 'nullable',
        ]);

        if ($request->is_default) {
            UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        UserAddress::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'street_address' => $request->street_address,
            'ward' => $request->ward,
            'district' => $request->district,
            'city' => $request->city,
            'country' => 'Việt Nam',
            'is_default' => $request->is_default ?? false,
            'note' => $request->note,
        ]);

        return redirect()->route('account.edit')->with('success', 'Thêm địa chỉ thành công.');
    }

    // Xoá địa chỉ (soft delete)
    public function destroy($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();
        return redirect()->route('account.edit')->with('success', 'Đã xoá địa chỉ.');
    }
    public function setDefault($id)
    {
        $userId = Auth::id();

        // Kiểm tra địa chỉ có tồn tại và thuộc về user hiện tại không
        $address = UserAddress::where('id', $id)
            ->where('user_id', $userId)
            ->whereNull('deleted_at')
            ->firstOrFail();

        // Cập nhật tất cả địa chỉ của user thành không mặc định
        UserAddress::where('user_id', $userId)->update(['is_default' => false]);

        // Cập nhật địa chỉ được chọn thành mặc định
        $address->update(['is_default' => true]);

        return redirect()->route('account.edit')->with('success', 'Đã đặt địa chỉ mặc định.');
    }
}
