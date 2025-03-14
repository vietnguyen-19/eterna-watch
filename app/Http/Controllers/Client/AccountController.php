<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function dashboard()
    {
        return view('client.account.dashboard');
    }
    public function detail()
    {
        return view('client.account.detail');
    }
    public function wishlist()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->with('product.variants', 'product.category', 'product.brand')->get();

        return view('client.account.wishlist', compact('wishlist'));
    }
    public function address()
    {
        return view('client.account.address');
    }
    public function order()
    {
        $orders = Order::where('user_id', Auth::id())->with(['orderItems.productVariant.product', 'orderItems.productVariant.attributeValues.nameValue', 'entity', 'payment', 'voucher'])->latest()->get();
        return view('client.account.order', compact('orders'));
    }
    public function orderDetail($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'orderItems.productVariant.attributeValues.nameValue', 'entity', 'payment', 'voucher'])->findOrFail($id);
        return view('client.account.order-detail', compact('order'));
    }
    public function cancelOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(["success" => false, "message" => "Đơn hàng không tồn tại!"], 404);
        }

        // Chỉ chặn hủy nếu đơn hàng đã được vận chuyển hoặc hoàn tất
        if (!in_array($order->status, ["pending", "confirmed"])) {
            return response()->json(["success" => false, "message" => "Không thể hủy đơn hàng khi vì đã giao cho bên vận chuyển"], 400);
        }

        $order->status = "Cancelled";
        $order->save();

        return response()->json(["success" => true, "message" => "Đơn hàng đã được hủy thành công!"]);
    }
    public function removeFromWishlist($id)
    {
        $wishlist = Wishlist::where('product_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$wishlist) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong danh sách yêu thích!'], 404);
        }

        $wishlist->delete();
        return response()->json(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi danh sách yêu thích!']);
    }
}
