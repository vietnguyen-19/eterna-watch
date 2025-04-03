<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function search(Request $request)
    {
        // Logic để tìm kiếm người dùng
        $query = $request->input('query');
        $users = User::where('name', 'like', '%' . $query . '%')->get();
        return response()->json($users);
    }

    public function searchPro(Request $request)
    {
        // Logic để tìm kiếm sản phẩm
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')->get();
        return response()->json($products);
    }

    public function addOrderItem(Request $request)
    {
        // Logic để thêm một mục vào đơn hàng
        $orderItem = new OrderItem();
        $orderItem->order_id = $request->input('order_id');
        $orderItem->product_id = $request->input('product_id');
        $orderItem->quantity = $request->input('quantity');
        $orderItem->save();
        return response()->json(['message' => 'Mục đã được thêm vào đơn hàng']);
    }

    public function removeOrderItem(Request $request)
    {
        // Logic để xóa một mục khỏi đơn hàng
        $orderItem = OrderItem::find($request->input('id'));
        if ($orderItem) {
            $orderItem->delete();
            return response()->json(['message' => 'Mục đã được xóa khỏi đơn hàng']);
        } else {
            return response()->json(['message' => 'Mục không tồn tại'], 404);
        }
    }

    public function updateOrderItem(Request $request)
    {
        // Logic để cập nhật một mục trong đơn hàng
        $orderItem = OrderItem::find($request->input('id'));
        if ($orderItem) {
            $orderItem->quantity = $request->input('quantity');
            $orderItem->save();
            return response()->json(['message' => 'Mục đã được cập nhật']);
        } else {
            return response()->json(['message' => 'Mục không tồn tại'], 404);
        }
    }

    public function checkVoucher(Request $request)
    {
        // Logic để kiểm tra voucher
        $voucherCode = $request->input('voucher_code');
        $voucher = Voucher::where('code', $voucherCode)->first();
        if ($voucher) {
            return response()->json(['message' => 'Voucher hợp lệ']);
        } else {
            return response()->json(['message' => 'Voucher không hợp lệ'], 404);
        }
    }
}
