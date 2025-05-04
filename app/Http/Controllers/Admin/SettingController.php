<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingUpdateRequest;
use App\Http\Requests\SettingStoreRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class SettingController extends Controller
{
    public function index()
    {

        $setting = DB::table('settings')->get();

        return view('admin.settings.index')->with(['setting' => $setting]);

    }

    public function create()
    {
        return view('admin.settings.create');

    }

    public function store(SettingStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::check() ? Auth::id() : null; // Nếu không đăng nhập, user_id là NULL
        $setting = Setting::create($data);
        return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
    }
    // public function store(SettingStoreRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $data['user_id'] = Auth::id();
    //         Setting::create($data);
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
    //     }
    // }

    // public function __construct()
    // {
    //     $this->middleware('auth'); // Hoặc middleware cụ thể cho admin, ví dụ: 'admin'
    // }
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(SettingUpdateRequest $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $data = $request->validated();
        $data['user_id'] = Auth::check() ? Auth::id() : null; // Nếu không đăng nhập, user_id là NULL
        $setting->update($data);
        return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();
        return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
    }



    // public function __construct()
    // {
    //     $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
    // }

    // public function index()
    // {
    //     $settings = Setting::paginate(10); // Phân trang
    //     return view('admin.settings.index', compact('settings'));
    // }

    // public function create()
    // {
    //     return view('admin.settings.create');
    // }

    // public function store(SettingStoreRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $data['user_id'] = Auth::id();
    //         Setting::create($data);
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
    //     }
    // }

    // public function edit($id)
    // {
    //     $setting = Setting::findOrFail($id);
    //     return view('admin.settings.edit', compact('setting'));
    // }

    // public function update(SettingUpdateRequest $request, $id)
    // {
    //     try {
    //         $setting = Setting::findOrFail($id);
    //         $this->authorize('update', $setting); // Kiểm tra quyền
    //         $data = $request->validated();
    //         $data['user_id'] = Auth::id();
    //         $setting->update($data);
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.edit', $id)->with('error', 'Có lỗi xảy ra khi cập nhật cài đặt!');
    //     }
    // }

    // public function destroy($id)
    // {
    //     try {
    //         $setting = Setting::findOrFail($id);
    //         $this->authorize('delete', $setting); // Kiểm tra quyền
    //         $setting->delete();
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.index')->with('error', 'Có lỗi xảy ra khi xóa cài đặt!');
    //     }
    // }
//     public function __construct()
//     {
//         $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
//     }

//     public function index()
//     {
//         $settings = Setting::paginate(10); // Phân trang
//         return view('admin.settings.index', compact('settings'));
//     }

//     public function create()
//     {
//         return view('admin.settings.create');
//     }

//     public function store(SettingStoreRequest $request)
//     {
//         try {
//             $data = $request->validated();
//             $data['user_id'] = Auth::id();
//             Setting::create($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
//         }
//     }

//     public function edit($id)
//     {
//         $setting = Setting::findOrFail($id);
//         return view('admin.settings.edit', compact('setting'));
//     }

//     public function update(SettingUpdateRequest $request, $id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('update', $setting); // Kiểm tra quyền
//             $data = $request->validated();
//             $data['user_id'] = Aut
// h::id();
//             $setting->update($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.edit', $id)->with('error', 'Có lỗi xảy ra khi cập nhật cài đặt!');
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('delete', $setting); // Kiểm tra quyền
//             $setting->delete();
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.index')->with('error', 'Có lỗi xảy ra khi xóa cài đặt!');
//         }
//     }
//     public function __construct()
//     {
//         $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
//     }

//     public function index()
//     {
//         $settings = Setting::paginate(10); // Phân trang
//         return view('admin.settings.index', compact('settings'));
//     }

//     public function create()
//     {
//         return view('admin.settings.create');
//     }

//     public function store(SettingStoreRequest $request)
//     {
//         try {
//             $data = $request->validated();
//             $data['user_id'] = Auth::id();
//             Setting::create($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
//         }
//     }

//     public function edit($id)
//     {
//         $setting = Setting::findOrFail($id);
//         return view('admin.settings.edit', compact('setting'));
//     }

//     public function update(SettingUpdateRequest $request, $id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('update', $setting); // Kiểm tra quyền
//             $data = $request->validated();
//             $data['user_id'] = Aut
// h::id();
//             $setting->update($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.edit', $id)->with('error', 'Có lỗi xảy ra khi cập nhật cài đặt!');
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('delete', $setting); // Kiểm tra quyền
//             $setting->delete();
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.index')->with('error', 'Có lỗi xảy ra khi xóa cài đặt!');
//         }
//     }
// public function __construct()
    // {
    //     $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
    // }

    // public function index()
    // {
    //     $settings = Setting::paginate(10); // Phân trang
    //     return view('admin.settings.index', compact('settings'));
    // }

    // public function create()
    // {
    //     return view('admin.settings.create');
    // }

    // public function store(SettingStoreRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $data['user_id'] = Auth::id();
    //         Setting::create($data);
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
    //     }
    // }

    // public function edit($id)
    // {
    //     $setting = Setting::findOrFail($id);
    //     return view('admin.settings.edit', compact('setting'));
    // }

    // public function update(SettingUpdateRequest $request, $id)
    // {
    //     try {
    //         $setting = Setting::findOrFail($id);
    //         $this->authorize('update', $setting); // Kiểm tra quyền
    //         $data = $request->validated();
    //         $data['user_id'] = Auth::id();
    //         $setting->update($data);
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.edit', $id)->with('error', 'Có lỗi xảy ra khi cập nhật cài đặt!');
    //     }
    // }

    // public function destroy($id)
    // {
    //     try {
    //         $setting = Setting::findOrFail($id);
    //         $this->authorize('delete', $setting); // Kiểm tra quyền
    //         $setting->delete();
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.index')->with('error', 'Có lỗi xảy ra khi xóa cài đặt!');
    //     }
    // }
//     public function __construct()
//     {
//         $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
//     }

//     public function index()
//     {
//         $settings = Setting::paginate(10); // Phân trang
//         return view('admin.settings.index', compact('settings'));
//     }

//     public function create()
//     {
//         return view('admin.settings.create');
//     }

//     public function store(SettingStoreRequest $request)
//     {
//         try {
//             $data = $request->validated();
//             $data['user_id'] = Auth::id();
//             Setting::create($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
//         }
//     }

//     public function edit($id)
//     {
//         $setting = Setting::findOrFail($id);
//         return view('admin.settings.edit', compact('setting'));
//     }

//     public function update(SettingUpdateRequest $request, $id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('update', $setting); // Kiểm tra quyền
//             $data = $request->validated();
//             $data['user_id'] = Aut
// h::id();
//             $setting->update($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.edit', $id)->with('error', 'Có lỗi xảy ra khi cập nhật cài đặt!');
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('delete', $setting); // Kiểm tra quyền
//             $setting->delete();
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.index')->with('error', 'Có lỗi xảy ra khi xóa cài đặt!');
//         }
//     }
//     public function __construct()
//     {
//         $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
//     }

//     public function index()
//     {
//         $settings = Setting::paginate(10); // Phân trang
//         return view('admin.settings.index', compact('settings'));
//     }

//     public function create()
//     {
//         return view('admin.settings.create');
//     }

//     public function store(SettingStoreRequest $request)
//     {
//         try {
//             $data = $request->validated();
//             $data['user_id'] = Auth::id();
//             Setting::create($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
//         }
//     }

//     public function edit($id)
//     {
//         $setting = Setting::findOrFail($id);
//         return view('admin.settings.edit', compact('setting'));
//     }

//     public function update(SettingUpdateRequest $request, $id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('update', $setting); // Kiểm tra quyền
//             $data = $request->validated();
//             $data['user_id'] = Aut
// h::id();
//             $setting->update($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.edit', $id)->with('error', 'Có lỗi xảy ra khi cập nhật cài đặt!');
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('delete', $setting); // Kiểm tra quyền
//             $setting->delete();
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.index')->with('error', 'Có lỗi xảy ra khi xóa cài đặt!');
//         }
//     }
// public function __construct()
    // {
    //     $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
    // }

    // public function index()
    // {
    //     $settings = Setting::paginate(10); // Phân trang
    //     return view('admin.settings.index', compact('settings'));
    // }

    // public function create()
    // {
    //     return view('admin.settings.create');
    // }

    // public function store(SettingStoreRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $data['user_id'] = Auth::id();
    //         Setting::create($data);
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
    //     }
    // }

    // public function edit($id)
    // {
    //     $setting = Setting::findOrFail($id);
    //     return view('admin.settings.edit', compact('setting'));
    // }

    // public function update(SettingUpdateRequest $request, $id)
    // {
    //     try {
    //         $setting = Setting::findOrFail($id);
    //         $this->authorize('update', $setting); // Kiểm tra quyền
    //         $data = $request->validated();
    //         $data['user_id'] = Auth::id();
    //         $setting->update($data);
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.edit', $id)->with('error', 'Có lỗi xảy ra khi cập nhật cài đặt!');
    //     }
    // }

    // public function destroy($id)
    // {
    //     try {
    //         $setting = Setting::findOrFail($id);
    //         $this->authorize('delete', $setting); // Kiểm tra quyền
    //         $setting->delete();
    //         return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.settings.index')->with('error', 'Có lỗi xảy ra khi xóa cài đặt!');
    //     }
    // }
//     public function __construct()
//     {
//         $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
//     }

//     public function index()
//     {
//         $settings = Setting::paginate(10); // Phân trang
//         return view('admin.settings.index', compact('settings'));
//     }

//     public function create()
//     {
//         return view('admin.settings.create');
//     }

//     public function store(SettingStoreRequest $request)
//     {
//         try {
//             $data = $request->validated();
//             $data['user_id'] = Auth::id();
//             Setting::create($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
//         }
//     }

//     public function edit($id)
//     {
//         $setting = Setting::findOrFail($id);
//         return view('admin.settings.edit', compact('setting'));
//     }

//     public function update(SettingUpdateRequest $request, $id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('update', $setting); // Kiểm tra quyền
//             $data = $request->validated();
//             $data['user_id'] = Aut
// h::id();
//             $setting->update($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.edit', $id)->with('error', 'Có lỗi xảy ra khi cập nhật cài đặt!');
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('delete', $setting); // Kiểm tra quyền
//             $setting->delete();
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.index')->with('error', 'Có lỗi xảy ra khi xóa cài đặt!');
//         }
//     }
//     public function __construct()
//     {
//         $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
//     }

//     public function index()
//     {
//         $settings = Setting::paginate(10); // Phân trang
//         return view('admin.settings.index', compact('settings'));
//     }

//     public function create()
//     {
//         return view('admin.settings.create');
//     }

//     public function store(SettingStoreRequest $request)
//     {
//         try {
//             $data = $request->validated();
//             $data['user_id'] = Auth::id();
//             Setting::create($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.create')->with('error', 'Có lỗi xảy ra khi lưu cài đặt!');
//         }
//     }

//     public function edit($id)
//     {
//         $setting = Setting::findOrFail($id);
//         return view('admin.settings.edit', compact('setting'));
//     }

//     public function update(SettingUpdateRequest $request, $id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('update', $setting); // Kiểm tra quyền
//             $data = $request->validated();
//             $data['user_id'] = Aut
// h::id();
//             $setting->update($data);
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.edit', $id)->with('error', 'Có lỗi xảy ra khi cập nhật cài đặt!');
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             $setting = Setting::findOrFail($id);
//             $this->authorize('delete', $setting); // Kiểm tra quyền
//             $setting->delete();
//             return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được xóa thành công!');
//         } catch (\Exception $e) {
//             return redirect()->route('admin.settings.index')->with('error', 'Có lỗi xảy ra khi xóa cài đặt!');
//         }
//     }
}
