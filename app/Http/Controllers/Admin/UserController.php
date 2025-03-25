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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng theo vai trò.
     */
    public function index(Request $request)
    {
        $roleId = $request->input('role_id');
        
        $query = User::with('role');
        
        if ($roleId) {
            $query->where('role_id', $roleId);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        $roles = Role::all();
        
        return view('admin.users.index', compact('data', 'roles'));
    }

    /**
     * Hiển thị form tạo mới người dùng.
     */
    public function create()
    {
        $roles = Role::all(); // Lấy tất cả vai trò
        return view('admin.users.create', [
            'roles' => $roles,
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
        $roles = Role::all(); // Lấy tất cả vai trò
        $user = User::with('role')->findOrFail($id);
        $address = UserAddress::where('user_id', $id)->where('is_default', true)->first();

        return view('admin.users.edit', compact('user', 'roles', 'address'));
    }

    /**
     * Lưu thông tin người dùng mới.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            // Xử lý avatar
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $fileName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = $avatar->storeAs('avatar', $fileName, 'public');
            }

            // Tạo người dùng mới
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('password')),
                'gender' => $request->input('gender'),
                'role_id' => $request->input('role_id'),
                'status' => $request->input('status'),
                'note' => $request->input('note'),
                'avatar' => $avatarPath,
            ]);
        
            // Tạo địa chỉ mặc định cho người dùng
            UserAddress::create([
                'user_id' => $user->id,
                'full_name' => $request->input('full_name'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'street_address' => $request->input('street_address'),
                'ward' => $request->input('ward'),
                'district' => $request->input('district'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
                'is_default' => true,
            ]);

            DB::commit();
        
            return redirect()->route('admin.users.index')->with('success', 'Tài khoản đã được tạo thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }
    


    /**
     * Cập nhật thông tin người dùng.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            Log::info('Found User:', $user->toArray());
            
            // Cập nhật thông tin cơ bản
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->gender = $request->input('gender');
            $user->role_id = $request->input('role_id');
            $user->status = $request->input('status');
            $user->note = $request->input('note');

            // Cập nhật mật khẩu nếu có
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
                Log::info('Password updated');
            }

            // Xử lý avatar
            if ($request->hasFile('avatar')) {
                Log::info('Processing avatar:', [
                    'original_name' => $request->file('avatar')->getClientOriginalName(),
                    'mime_type' => $request->file('avatar')->getMimeType(),
                    'size' => $request->file('avatar')->getSize()
                ]);

                // Xóa avatar cũ nếu có
                if ($user->avatar) {
                    Storage::delete('public/' . $user->avatar);
                    Log::info('Old avatar deleted');
                }

                // Lưu avatar mới
                $avatar = $request->file('avatar');
                $fileName = time() . '.' . $avatar->getClientOriginalExtension();
                $path = $avatar->storeAs('avatar', $fileName, 'public');
                $user->avatar = 'avatar/' . $fileName;
                Log::info('New avatar saved:', ['path' => $user->avatar]);
            }

            // Log user data before save
            Log::info('User data before save:', $user->toArray());
            
            $user->save();
            Log::info('User saved successfully');

            // Cập nhật hoặc tạo mới địa chỉ
            $addressData = [
                'full_name' => $request->input('full_name'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'street_address' => $request->input('street_address'),
                'ward' => $request->input('ward'),
                'district' => $request->input('district'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
                'is_default' => true
            ];

            Log::info('Address data to update:', $addressData);

            $address = UserAddress::updateOrCreate(
                ['user_id' => $id, 'is_default' => true],
                $addressData
            );

            Log::info('Address updated:', $address->toArray());

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->route('admin.users.index')->with('success', 'Tài khoản đã được cập nhật thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating user:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
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
