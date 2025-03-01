<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($id)
    {
        $data = User::with('role')->where('role_id', $id)->latest('id')->get();
        $role = Role::findOrFail($id); // Lấy tên role

        return view('admin.users.index', [
            'data' => $data,
            'role' => $role,
        ]);
    }

    public function create()
    {
        $roles = Role::query()->get();
        return view('admin.users.create', [
            'roles' => $roles
        ]);
    }

    public function show($id)
    {
        $user = User::with('addresses')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $roles = Role::get();
        $user = User::with('role')->findOrFail($id);
        $address = UserAddress::where('user_id', $id)->where('is_default', true)->first();

        return view('admin.users.edit', compact('user', 'roles', 'address'));
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated(); // Lấy dữ liệu đã validate

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'] ?? null,
            'avatar' => 'avatar/default.jpeg',
            'note' => $data['note'] ?? null,
            'role_id' => $data['role_id'],
            'status' => 'active',
        ]);

        return redirect()->route('admin.users.index', $data['role_id'])->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Tài khoản đã được tạo thành công.',
            ]
        ]);
    }


    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->gender = $request->input('gender');
        $user->note = $request->input('note');
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = time() . '.' . $avatar->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/avatars');
            // Tạo thư mục nếu chưa có
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $avatar->move($destinationPath, $fileName);

            // Xóa avatar cũ nếu có
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }
            $user->avatar = 'avatars/' . $fileName;
        }


        $address = UserAddress::where('user_id', $id)->where('is_default', true)->first();

        // Nếu không tìm thấy địa chỉ, tạo mới
        if (!$address) {
            $address = new UserAddress();
            $address->user_id = $id;
            $address->is_default = true; // Đánh dấu là địa chỉ mặc định
        }

        // Cập nhật thông tin địa chỉ
        $address->country = $request->input('country');
        $address->city = $request->input('city');
        $address->district = $request->input('district');
        $address->ward = $request->input('ward');
        $address->specific_address = $request->input('specific_address');

        // Lưu thông tin user và address
        $user->save();
        $address->save();

        return redirect()->route('admin.users.index', $user->role_id)->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Tải khoản đã được cập nhật thành công.',
            ]
        ]);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);  
        $user->addresses()->delete();
        $user->delete();
        return redirect()->route('admin.users.index', $user->role_id)->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Người dùng đã được xóa thành công.',
            ]
        ]);
    }
}
