<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Logo;

class AllOrdersController extends Controller
{
    public function index(){

        // $orders = Order::whereNot('type', 'Takea');

        return view('admin.all-orders');
    }

    public function generateBill($id){
        $order = Order::findOrFail($id);
        $cart = Cart::where('order_id', $id);
        $restro_id = auth()->user()->restro_id; // Assuming this retrieves the restaurant ID of the authenticated user
        $logo = Logo::where('restro_id', $restro_id)->first(); // Retrieve the logo for the restaurant
// dd($cart->recipe_name)
        // ->where('recipe_status', 'Order Completed')
        // ->get();

        return view('admin.bill', ['order'=>$order, 'cart'=>$cart, 'logo'=>$logo]);
    }
}
