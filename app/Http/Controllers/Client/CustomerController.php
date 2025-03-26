<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CustomerController extends Controller
{
    public function profile(){
        return view('customer.profile',compact('user'));
    }

    //quan ly dia chi giao hang
    public function manageAddresses(){
        $addresses = Addesss::where('user_id',Auth::id())->get(); //lay danh sach dia chi nguoi dung
    }
    //quan ly don hang
    public function orders(){
        $oders = IOrders::where('user_id',Auth::id())->get();//laay danh sach don hang
    }

    //quan ly gio hang
    public function cart(){
        $cartItems = Cart::where('user_id',Auth::id())->get(); //lay san pham trong gio hang
        return view('customer.cart.iondex',compact('cartItems'));
    }
    //5 quan li ma giam gia
    public function discounts(){
        $discounts = Disscount::all();
        return view('customer.discounts.index',compact('discounts'));
    }
    //quan li thong bao 
    public function notifications(){
        $notifications = Auth::user()->notifications;
        return view('customer.notifications.index',compact('notifications'));                                                                                               
    }
}
