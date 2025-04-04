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
        $search = $request->input('search');

        $products = Product::where('name', 'like', "%$search%")
            
            ->get();

        $results = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'text' => $product->name,
                'price' => $product->price_default,
                'image' => $product->image_url,
            ];
        });

        return response()->json(['results' => $results]);
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
        $code = $request->input('code');
        $total = $request->input('total');

        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher || !$voucher->is_valid) {
            return response()->json([
                'valid' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.',
            ]);
        }

        $discount = $voucher->calculateDiscount($total);
        $newTotal = $total - $discount;

        return response()->json([
            'valid' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount' => $discount,
            'newTotal' => $newTotal,
            'voucher_id' => $voucher->id
        ]);
    }
}
