<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:225|unique:roles',
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')->with('success','role đã được thêm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Role $role)
    {
        //$role = Role::findOrFail($id);
        return view('admin.roles.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)

    {
        
        $request->validate([
            'name' => 'required|string|max:225|unique:roles,name,' . $role->id,
        ]);

        try{
            $role -> name = $request->input('name');
            $role -> save();
            $roleId = $role->id;
            return redirect()->route('roles.index')->with('success','Role đã được cập nhật!');
        } catch (\Exception $e){
            //xử lis lỗi nếu có
            return redirect()->back()->with('error','đã có lỗi xảy ra');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success','Role đã được xóa thành công');
    }
}
