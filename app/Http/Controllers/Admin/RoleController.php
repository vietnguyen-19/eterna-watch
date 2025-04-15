<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::latest('id')->get();
    
        return view('admin.roles.index', compact('roles', 'permissions'));
    }
    

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')->with('success', 'role đã được thêm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        // Lấy role theo ID và kèm theo các quyền đã gán
        $role = Role::with('permissions')->findOrFail($id);

        // Lấy tất cả permission và nhóm theo module (phần sau dấu gạch dưới đầu tiên)
        $permissions = \Spatie\Permission\Models\Permission::all()->groupBy(function ($permission) {
            $parts = explode('_', $permission->name);
            return $parts[1] ?? 'khac'; // ví dụ: view_users => 'users'
        });

        // Truyền role và permissions sang view
        return view('admin.roles.show', compact('role', 'permissions'));
    }

    // Controller
    public function updatePermissions(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions ?? []);
        return back()->with('thongbao', [
            'type' => 'success',
            'message' => 'Cập nhật quyền thành công!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)

    {

        $request->validate([
            'name' => 'required|string|max:225|unique:roles,name,' . $role->id,
        ]);

        try {
            $role->name = $request->input('name');
            $role->save();
            $roleId = $role->id;
            return redirect()->route('roles.index')->with('success', 'Role đã được cập nhật!');
        } catch (\Exception $e) {
            //xử lis lỗi nếu có
            return redirect()->back()->with('error', 'đã có lỗi xảy ra');
        }
    }
    // public function show($id)
    // {
    //     $role = Role::findOrFail($id);
    //     return view('admin.roles.show', compact('role'));
    // }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
    }
}
