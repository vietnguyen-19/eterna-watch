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
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng theo vai trò.
     */
    public function index(Request $request, $id = null)
    {
       if($id){
        $data = User::with('role')->where('role_id', $id)->latest('id')->get();
        $role = Role::findOrFail($id);
       } else {
        $data = User::with('role')->latest('id')->get();
        $role = null;
       }
       return view('admin.users.index',[
        'data' => $data,
        'role' => $role,
       ]);
    }

    /**
     * Hiển thị form tạo mới người dùng.
     */
    public function create()
    {
        $roles = Role::query()->get();
        return view('admin.users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Hiển thị thông tin người dùng.
     */
    public function show($id)
    {
        $user = User::with('addresses')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Hiển thị form chỉnh sửa người dùng.
     */
    public function edit($id)
    {
        $roles = Role::get();
        $user = User::with('role')->findOrFail($id);
        $address = UserAddress::where('user_id', $id)->where('is_default', true)->first();

        return view('admin.users.edit', compact('user', 'roles', 'address'));
    }

    /**
     * Lưu thông tin người dùng mới.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

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

    /**
     * Cập nhật thông tin người dùng.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->gender = $request->input('gender');
        $user->note = $request->input('note');

        // Kiểm tra và lưu avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = time() . '.' . $avatar->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/avatars');
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

        // Cập nhật hoặc tạo mới địa chỉ mặc định
        $address = UserAddress::firstOrCreate(
            ['user_id' => $id, 'is_default' => true],
            [
                'country' => $request->input('country'),
                'city' => $request->input('city'),
                'district' => $request->input('district'),
                'ward' => $request->input('ward'),
                'specific_address' => $request->input('specific_address')
            ]
        );

        // Lưu thông tin người dùng và địa chỉ
        $user->save();
        $address->save();

        return redirect()->route('admin.users.index', $user->role_id)->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Tải khoản đã được cập nhật thành công.',
            ]
        ]);
    }

    /**
     * Xóa người dùng.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);  
        $user->addresses()->delete();  // Xóa tất cả địa chỉ của người dùng
        $user->delete();  // Xóa người dùng

        return redirect()->route('admin.users.index', $user->role_id)->with([
            'thongbao' => [
                'type' => 'success',
                'message' => 'Người dùng đã được xóa thành công.',
            ]
        ]);
    }
}
