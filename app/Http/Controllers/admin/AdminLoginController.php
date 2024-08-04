<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminLogin;
use App\Models\User;
use App\Models\City;


// use Illuminate\Support\Facades\Auth;


class AdminLoginController extends Controller
{
    public function index(){
    return view('login');
}


public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    // dd($request->all());

    if (Auth::attempt($credentials)) {
        // Authentication passed...

        $user = Auth::user();
        $role = $user->role;

        $city = City::all();

        // dd($role);

        if ($role == 'admin') {
            // Admin user
            return view('admin.dashboard', compact('city', ));
        } elseif ($role == 'superadmin') {
            // Regular user
            return view('frontend.dashboard', compact('city'));
        }
    } else {
        // Incorrect username or password, show an error message.
        return view('login')->with(['error' => 'Incorrect username or password']);
    }
}



// public function getOrdersByType(Request $request)
// {
//     $cityId = $request->input('city_id');
//     $fromDate = $request->input('from_date');
//     $toDate = $request->input('to_date');

//     $query = Order::selectRaw('COUNT(*) as count, type')
//                     ->when($cityId, function($query) use ($cityId) {
//                         return $query->where('city_id', $cityId);
//                     })
//                     ->when($fromDate && $toDate, function($query) use ($fromDate, $toDate) {
//                         return $query->whereBetween('created_at', [Carbon::parse($fromDate)->startOfDay(), Carbon::parse($toDate)->endOfDay()]);
//                     });

//     $orders = $query->groupBy('type')->get();

//     $data = [
//         'dineInCount' => 0,
//         'deliveryCount' => 0,
//         'totalCount' => 0,

//     ];

//     foreach ($orders as $order) {
//         if ($order->type === 'Dine In') {
//             $data['dineInCount'] += $order->count;
//         } elseif ($order->type === 'Delivery') {
//             $data['deliveryCount'] += $order->count;
//         }

//         $data['totalCount'] += $order->count;

//     }

//     return response()->json($data);
// }


public function getOrdersByType()
{
    $orders = Order::selectRaw('COUNT(*) as count, type')
        ->groupBy('type')
        ->get();

    $data = [
        'dineInCount' => 0,
        'deliveryCount' => 0,
    ];

    foreach ($orders as $order) {
        if ($order->type === 'Dine In') {
            $data['dineInCount'] = $order->count;
        } elseif ($order->type === 'Delivery') {
            $data['deliveryCount'] = $order->count;
        }
    }

    return response()->json($data);
}


public function logout()
{
    Auth::logout();

    return redirect('/');
}
}
