<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherStoreRequest;
use App\Http\Requests\VoucherUpdateRequest;
use App\Models\Voucher;

class VoucherController extends Controller
{
    //index
    public function index()
    {
        $vouchers = Voucher::all();
        return view('admin.vouchers.index', compact('vouchers'));
    }

   //create
    public function create()
    {
        return view('admin.vouchers.create');
    }

   //store
    public function store(VoucherStoreRequest $request)
    {
        Voucher::create($request->validated());

        return redirect()->route('admin.vouchers.index')
        ->with('thongbao', [
            'type' => 'success',
            'message' => 'Voucher đã được tạo thành công!'
        ]);
    }

  //edit
    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

   //update
    public function update(VoucherUpdateRequest $request, Voucher $voucher)
    {
        $voucher->update($request->validated());


        return redirect()->route('admin.vouchers.index')
        ->with('thongbao', [
            'type' => 'success',
            'message' => 'Voucher đã được cập nhật thành công!'
        ]);
    }
//destroy
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete(); // Xóa mềm

        return redirect()
            ->route('admin.vouchers.index')
            ->with('thongbao', [
                'type' => 'success',
                'message' => 'Voucher đã được đưa vào thùng rác!'
            ]);
    }

    // Thêm phương thức khôi phục
    public function restore($id)
    {
        $voucher = Voucher::onlyTrashed()->findOrFail($id);
        $voucher->restore();

        return redirect()
            ->route('admin.vouchers.index')
            ->with('thongbao', [
                'type' => 'success',
                'message' => 'Voucher đã được khôi phục!'
            ]);
    }

    // Thêm phương thức xóa vĩnh viễn
    public function forceDelete($id)
    {
        $voucher = Voucher::onlyTrashed()->findOrFail($id);
        $voucher->forceDelete();

        return redirect()
            ->route('admin.vouchers.trash')
            ->with('thongbao', [
                'type' => 'success',
                'message' => 'Voucher đã bị xóa vĩnh viễn!'
            ]);
    }

    // Danh sách voucher đã xóa
    public function trash()
    {
        $vouchers = Voucher::onlyTrashed()->get();
        return view('admin.vouchers.trash', compact('vouchers'));
    }
}
