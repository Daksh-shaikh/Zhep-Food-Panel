<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Logo;

class BillForAppController extends Controller
{
    public function billForApp(Request $request){
        $orderId = $request->id;
        $order = Order::with('restro')->findOrFail($orderId);

        $cart = Cart::where('order_id', $orderId)->get();
        $logo = Logo::where('restro_id', $order->restro_id)->first(); // Retrieve the logo for the restaurant


        return view('admin.bill-for-app', ['order'=>$order, 'cart'=>$cart, 'logo'=>$logo]);
    }
}


