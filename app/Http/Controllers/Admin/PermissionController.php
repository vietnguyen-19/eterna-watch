<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStogeRequest;
use App\Http\Requests\StoreRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class PermissionController extends Controller
{
    
    public function index()
    {
        $permissions = DB::table('permissions')
            ->latest('id')
            ->limit(10)
            ->paginate(8);
            
        return view('admin.permission.index', compact('permissions'));
    }

    public function show($id)
    {
        //Lấy show  theo id 
        $permission = DB::table('permissions')->find($id);
        if ($permission == null) {
            return redirect(404);
        }
        return view('admin.permission.show', compact('permission'));
    }

    public function create(){
        $permission = Permission::all();
        return view('admin.permission.create', compact('permission'));
    }

    public function store(PermissionStogeRequest $request){
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->save();
        return redirect()
            ->route('admin.permissions.index')
            ->with('message', 'Thêm dữ liệu thành công');
    }

    
    public function edit($id)
    {
         //Lấy show  theo id 
         $permission = DB::table('permissions')
            ->where('id', $id)
            ->first(); 
         return view('admin.permission.edit', compact('permission'));
    }

    public function update(PermissionStogeRequest $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();
        return redirect()->route('admin.permissions.index');
    }

    public function destroy($id)
    {
        DB::table('permissions')->delete($id);
        return redirect()->route('admin.permissions.index');
    }



}
