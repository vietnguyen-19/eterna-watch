<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Hiển thị danh sách người dùng đã xóa.
     */

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
        $user = User::with('role')->findOrFail($id);
        $address = UserAddress::where('user_id', $id)->where('is_default', true)->first();

        return view('admin.users.show', compact('user', 'address'));
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


            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '_' . $avatar->getClientOriginalName();
                $avatar->move(public_path('storage/avatar'), $avatarName);
                $avatarPath = 'avatar/' . $avatarName;
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
                'email_verified_at' => now(),
                'note' => $request->input('note'),
                'avatar' => $avatarPath,
            ]);

            // Tạo địa chỉ mặc định cho người dùng

            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'Thêm tài khoản thành công!');
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
            }

            // Xử lý avatar
            if ($request->hasFile('avatar')) {
                // Xóa avatar cũ nếu có
                if ($user->avatar) {
                    // Đường dẫn tuyệt đối của avatar cũ
                    $oldAvatarPath = public_path('storage/' . $user->avatar);

                    // Kiểm tra nếu ảnh cũ tồn tại trên hệ thống
                    if (file_exists($oldAvatarPath)) {
                        // Xóa ảnh cũ
                        unlink($oldAvatarPath);
                    }
                }

                // Lưu avatar mới
                $avatar = $request->file('avatar');
                $fileName = time() . '.' . $avatar->getClientOriginalExtension();
                $path = 'avatar/' . $fileName;

                // Di chuyển file đến thư mục lưu trữ
                $avatar->move(public_path('storage/avatar'), $fileName);

                // Cập nhật đường dẫn ảnh mới vào database
                $user->avatar = $path;
            }

            $user->save();

            // Cập nhật hoặc tạo mới địa chỉ
            $street = $request->input('street_address');
            $ward = $request->input('ward');
            $district = $request->input('district');
            $city = $request->input('city');

            // Chỉ khi tất cả các trường đều có giá trị thì mới lưu
            if ($street && $ward && $district && $city) {
                $addressData = [
                    'full_name' => Auth::user()->name,
                    'phone_number' => Auth::user()->phone,
                    'email' => Auth::user()->email,
                    'street_address' => $street,
                    'ward' => $ward,
                    'district' => $district,
                    'city' => $city,
                    'country' => 'Việt Nam',
                    'is_default' => true
                ];

                UserAddress::updateOrCreate(
                    ['user_id' => $id, 'is_default' => true],
                    $addressData
                );
            }


            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Xóa mềm người dùng.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            UserAddress::where('user_id', $id)->delete();

            // Xóa mềm user
            $user->delete();

            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'Tài khoản đã được xóa mềm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi xóa mềm user: ' . $e->getMessage());
            return redirect()->route('admin.users.index')->with('error', 'Đã xảy ra lỗi khi xóa tài khoản: ' . $e->getMessage());
        }
    }
    public function restore($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();

            return redirect()->route('admin.users.index')->with('success', 'Khôi phục tài khoản thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi khôi phục user: ' . $e->getMessage());
            return redirect()->route('admin.users.index')->with('error', 'Không thể khôi phục tài khoản!');
        }
    }
    public function forceDelete($id)
    {
        try {
            DB::beginTransaction();

            $user = User::withTrashed()->findOrFail($id);

            // XÓA ẢNH vật lý
            if ($user->avatar) {
                $avatarPath = public_path('storage/' . $user->avatar);
                if (file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
            }

            // XÓA ĐỊA CHỈ liên quan
            UserAddress::where('user_id', $id)->forceDelete();

            // XÓA VĨNH VIỄN
            $user->forceDelete();

            DB::commit();

            return redirect()->route('admin.users.trash')->with('success', 'Đã xóa vĩnh viễn tài khoản!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi xóa vĩnh viễn user: ' . $e->getMessage());
            return redirect()->route('admin.users.trash')->with('error', 'Không thể xóa vĩnh viễn tài khoản!');
        }
    }
    public function trash()
    {
        $users = User::with('role')->onlyTrashed()->get(); // Phân trang nếu muốn
        return view('admin.users.trash', compact('users'));
    }
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Đảo trạng thái: nếu đang là 'active' thì chuyển thành 'inactive' và ngược lại
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return redirect()->back()->with('success', 'Trạng thái người dùng đã được cập nhật.');
    }
}
