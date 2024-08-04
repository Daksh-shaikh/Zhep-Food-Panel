<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\City;
use App\Models\Coupon;
use Illuminate\Support\Carbon;


// use App\Models\AdminDashboard;

class AdminDashboardController extends Controller
{

    public function index(){

        $user = User::where('role', 'user')->get();
        $city = City::all();
        $orders = Order::all();
        $carts = Cart::all();
        $carts = Coupon::all();
        return view('admin.dashboard', compact('user', 'city', 'orders', 'carts'));
    }

//     public function index_waiter(){

//         $user = User::where('role', 'waiter')->get();
//         return view('admin.dashboard-waiter', compact('user'));
//     }

//     public function index_food(){
//         $recipes = Recipe::all();
//         $category = Category::all();
//         $cart = Cart::all();
// return view('admin.dashboard-food', ['recipes'=>$recipes, 'category'=>$category, 'cart'=>$cart]);
//  }


// for Pie chart Dine In or Delivery
 public function getOrdersByTypeAdmin(Request $request)
 {
     $cityId = $request->input('city_id');
     $fromDate = $request->input('from_date');
     $toDate = $request->input('to_date');
     $restroId = auth()->user()->restro_id;
     $query = Order::where('restro_id', ($restroId))
     ->selectRaw('COUNT(*) as count, type')
                     ->when($cityId, function($query) use ($cityId) {
                         return $query->where('city_id', $cityId);
                     })
                     ->when($fromDate && $toDate, function($query) use ($fromDate, $toDate) {
                         return $query->whereBetween('created_at', [Carbon::parse($fromDate)->startOfDay(), Carbon::parse($toDate)->endOfDay()]);
                     });

     $orders = $query->groupBy('type')->get();

     $data = [
         'dineInCount' => 0,
         'deliveryCount' => 0,
         'takeAways' => 0,

         'totalCount' => 0,
     ];

     foreach ($orders as $order) {
         if ($order->type === 'Dine In') {
             $data['dineInCount'] += $order->count;
         } elseif ($order->type === 'Delivery') {
             $data['deliveryCount'] += $order->count;
         }elseif ($order->type === 'Takeaways') {
            $data['takeAways'] += $order->count;
        }
         $data['totalCount'] += $order->count;
     }

     return response()->json($data);
 }


// for Pie chart Order Completed or Cancelled
public function getOrdersByStatus(Request $request)
{
    $cityId = $request->input('city_id2');
    $fromDate = $request->input('from_date2');
    $toDate = $request->input('to_date2');
    $restroId = auth()->user()->restro_id;
    $query = Order::where('restro_id', ($restroId))
    ->selectRaw('COUNT(*) as count, status')
                    ->when($cityId, function($query) use ($cityId) {
                        return $query->where('city_id', $cityId);
                    })
                    ->when($fromDate && $toDate, function($query) use ($fromDate, $toDate) {
                        return $query->whereBetween('created_at', [Carbon::parse($fromDate)->startOfDay(), Carbon::parse($toDate)->endOfDay()]);
                    });

    $orders = $query->groupBy('status')->get();

    $data = [
        'CompletedCount' => 0,
        'CancelledCount' => 0,
        'InprogressCount' => 0,
        'totalCount' => 0,
    ];

    foreach ($orders as $order) {
        if ($order->status === 'Order Completed') {
            $data['CompletedCount'] += $order->count;
        } elseif ($order->status === 'Order Cancelled') {
            $data['CancelledCount'] += $order->count;
        }else{
            $data['InprogressCount'] += $order->count;
        }
        $data['totalCount'] += $order->count;
    }

    return response()->json($data);
}
}
