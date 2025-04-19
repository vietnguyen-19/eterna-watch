<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest('id')->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'           => 'required|string|unique:vouchers,code|max:50',
            'discount_type'  => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order'      => 'nullable|numeric|min:0',
            'max_uses'       => 'nullable|integer|min:1',
            'start_date'     => 'nullable|date',
            'expires_at'     => 'nullable|date|after_or_equal:start_date',
            'status'         => 'required|in:active,expired',
        ]);

        Voucher::create($request->all());

        return redirect()->route('admin.vouchers.index')->with('success', 'Mã ưu đãi đã được tạo thành công.');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'code'           => 'required|string|unique:vouchers,code,' . $id . '|max:50',
            'discount_type'  => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order'      => 'nullable|numeric|min:0',
            'max_uses'       => 'nullable|integer|min:1',
            'start_date'     => 'nullable|date',
            'expires_at'     => 'nullable|date|after_or_equal:start_date',
            'status'         => 'required|in:active,expired',
        ]);

        $voucher->update($request->all());

        return redirect()->route('admin.vouchers.index')->with('success', 'Mã ưu đãi đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Mã ưu đãi đã được chuyển vào thùng rác.');
    }

    // Hiển thị danh sách các mã đã bị xóa tạm thời
    public function trash()
    {
        $vouchers = Voucher::onlyTrashed()->latest('deleted_at')->get();
        return view('admin.vouchers.trash', compact('vouchers'));
    }

    // Khôi phục mã ưu đãi từ thùng rác
    public function restore($id)
    {
        $voucher = Voucher::onlyTrashed()->findOrFail($id);
        $voucher->restore();

        return redirect()->route('admin.vouchers.trash')->with('success', 'Mã ưu đãi đã được khôi phục.');
    }

    // Xóa vĩnh viễn mã ưu đãi
    public function forceDelete($id)
    {
        $voucher = Voucher::onlyTrashed()->findOrFail($id);
        $voucher->forceDelete();

        return redirect()->route('admin.vouchers.trash')->with('success', 'Mã ưu đãi đã bị xóa vĩnh viễn.');
    }
}
