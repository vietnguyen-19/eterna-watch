<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherStoreRequest;
use App\Http\Requests\VoucherUpdateRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(VoucherStoreRequest $request)
    {
        try {
            Voucher::create($request->validated());

            return redirect()->route('admin.vouchers.index')
                   ->with('thongbao', [
                       'type' => 'success',
                       'message' => 'Thêm voucher thành công!'
                   ]);

        } catch (\Exception $e) {
            return back()->withInput()
                   ->with('thongbao', [
                       'type' => 'danger',
                       'message' => 'Lỗi: '.$e->getMessage()
                   ]);
        }
    }

    public function edit($id) // Thay đổi từ Route Model Binding sang $id
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(VoucherUpdateRequest $request, $id)
    {
        try {
            $voucher = Voucher::findOrFail($id);

            // Kiểm tra thủ công nếu cần
            if ($voucher->code !== $request->code &&
                Voucher::where('code', $request->code)->where('id', '!=', $id)->exists()) {
                throw new \Exception('Mã voucher đã tồn tại');
            }

            $voucher->update($request->validated());

            return redirect()->route('admin.vouchers.index')
                   ->with('thongbao', [
                       'type' => 'success',
                       'message' => 'Cập nhật voucher thành công!'
                   ]);

        } catch (\Exception $e) {
            return back()->withInput()
                   ->with('thongbao', [
                       'type' => 'danger',
                       'message' => 'Lỗi: '.$e->getMessage()
                   ]);
        }
    }
    public function destroy($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();

            return redirect()->route('admin.vouchers.index')
                   ->with('thongbao', [
                       'type' => 'success',
                       'message' => 'Đã chuyển vào thùng rác!'
                   ]);

        } catch (\Exception $e) {
            return back()->with('thongbao', [
                'type' => 'danger',
                'message' => 'Lỗi: '.$e->getMessage()
            ]);
        }
    }

    public function trash()
    {
        $vouchers = Voucher::onlyTrashed()->latest()->get();
        return view('admin.vouchers.trash', compact('vouchers'));
    }

    public function restore($id)
    {
        try {
            $voucher = Voucher::onlyTrashed()->findOrFail($id);
            $voucher->restore();

            return redirect()->route('admin.vouchers.trash')
                   ->with('thongbao', [
                       'type' => 'success',
                       'message' => 'Khôi phục thành công!'
                   ]);

        } catch (\Exception $e) {
            return back()->with('thongbao', [
                'type' => 'danger',
                'message' => 'Lỗi: '.$e->getMessage()
            ]);
        }
    }

    public function forceDelete($id)
    {
        try {
            $voucher = Voucher::onlyTrashed()->findOrFail($id);
            $voucher->forceDelete();

            return redirect()->route('admin.vouchers.trash')
                   ->with('thongbao', [
                       'type' => 'success',
                       'message' => 'Xóa vĩnh viễn thành công!'
                   ]);

        } catch (\Exception $e) {
            return back()->with('thongbao', [
                'type' => 'danger',
                'message' => 'Lỗi: '.$e->getMessage()
            ]);
        }
    }
}
