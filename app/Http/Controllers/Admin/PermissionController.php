<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    
    public function index()
    {
        $permissions = DB::table('permissions')
            ->latest('id')
            ->limit(10)
            ->get();
        return view('admin.permission.index', compact('permissions'));
    }

    public function create(){
        return view('admin.permission.create');
    }

    public function store(Request $request){
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->save();
        return redirect()->route('admin.permission.index');
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();
        return redirect()->route('permissions.index');
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permissions.index');
    }



}
