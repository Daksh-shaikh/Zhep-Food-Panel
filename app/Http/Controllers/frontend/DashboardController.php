<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Models\Order;
use App\Models\City;
// use Illuminate\Support\Carbon;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $city = City::all();
        // $dineInCount = Order::where('type', 'Dine In')->count();
        // $deliveryCount = Order::where('type', 'Delivery')->count();
        // dd('dine in count ='.$dineInCount);
        // dd('delivery count ='.$deliveryCount);

    return view('frontend.dashboard', ['city'=>$city,]);
}

// public function getOrdersByType()
// {
//     $orders = Order::selectRaw('COUNT(*) as count, type')
//         ->groupBy('type')
//         ->get();

//     $data = [
//         'dineInCount' => 0,
//         'deliveryCount' => 0,
//     ];

//     foreach ($orders as $order) {
//         if ($order->type === 'Dine In') {
//             $data['dineInCount'] = $order->count;
//         } elseif ($order->type === 'Delivery') {
//             $data['deliveryCount'] = $order->count;
//         }
//     }

//     return response()->json($data);
// }


// public function getOrdersByType(Request $request)
// {
//     $cityId = $request->input('city_id');

//     $query = Order::selectRaw('COUNT(*) as count, type')->where('city_id', $cityId);

//     if ($cityId) {
//         $query->where('city_id', $cityId);
//     }

//     $orders = $query->groupBy('type')->get();

//     $data = [
//         'dineInCount' => 0,
//         'deliveryCount' => 0,
//     ];

//     foreach ($orders as $order) {
//         if ($order->type === 'Dine In') {
//             $data['dineInCount'] = $order->count;
//         } elseif ($order->type === 'Delivery') {
//             $data['deliveryCount'] = $order->count;
//         }
//     }

//     return response()->json($data);
// }

public function getOrdersByType2(Request $request)
{
    $cityId = $request->input('city_id');

    $query = Order::selectRaw('COUNT(*) as count, type');

    if ($cityId) {
        $query->where('city_id', $cityId);
    }

    $orders = $query->groupBy('type')->get();

    $data = [
        'dineInCount' => 0,
        'deliveryCount' => 0,
        'totalCount' => 0,
    ];

    foreach ($orders as $order) {
        if ($order->type === 'Dine In') {
            $data['dineInCount'] += $order->count;
        } elseif ($order->type === 'Delivery') {
            $data['deliveryCount'] += $order->count;
        }
        $data['totalCount'] += $order->count;

    }

    return response()->json($data);
}



public function getOrdersByType3(Request $request)
{
    $cityId = $request->input('city_id');
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');

    $query = Order::selectRaw('COUNT(*) as count, type')
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
        'totalCount' => 0,

    ];

    foreach ($orders as $order) {
        if ($order->type === 'Dine In') {
            $data['dineInCount'] += $order->count;
        } elseif ($order->type === 'Delivery') {
            $data['deliveryCount'] += $order->count;
        }

        $data['totalCount'] += $order->count;

    }

    return response()->json($data);
}

public function getOrdersByType22(Request $request)
{
    $cityId = $request->input('city_id');
    $query = Order::query();

    if ($cityId) {
        $query->where('city_id', $cityId);
    }

    $dineInCount = $query->where('type', 'Dine In')->count();
    $deliveryCount = $query->where('type', 'Delivery')->count();

    // dd($dineInCount);
    return response()->json([
        'dineInCount' => $dineInCount,
        'deliveryCount' => $deliveryCount
    ]);
}

public function getOrdersByType(Request $request)
{
    $cityId = $request->input('city_id');
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $totalCount = Order::all()->count();
    $query = Order::query();

    if ($cityId) {
        $query->where('city_id', $cityId);
    }

    if ($fromDate && $toDate) {
        $query->whereBetween('created_at', [Carbon::parse($fromDate)->startOfDay(), Carbon::parse($toDate)->endOfDay()]);
    }

    $dineInCount = $query->where('type', 'Dine In')->count();
//     $takeAways = $query->where('type', 'Takeaways')->count();
// dd($takeAways);
    $deliveryCount = Order::query() // Separate query for delivery count
                        ->when($cityId, function($query) use ($cityId) {
                            return $query->where('city_id', $cityId);
                        })
                        ->when($fromDate && $toDate, function($query) use ($fromDate, $toDate) {
                            return $query->whereBetween('created_at', [Carbon::parse($fromDate)->startOfDay(), Carbon::parse($toDate)->endOfDay()]);
                        })
                        ->where('type', 'Delivery')
                        ->count();

    $takeAways = Order::query() // Separate query for delivery count
                        ->when($cityId, function($query) use ($cityId) {
                            return $query->where('city_id', $cityId);
                        })
                        ->when($fromDate && $toDate, function($query) use ($fromDate, $toDate) {
                            return $query->whereBetween('created_at', [Carbon::parse($fromDate)->startOfDay(), Carbon::parse($toDate)->endOfDay()]);
                        })
                        ->where('type', 'Takeaways')
                        ->count();

    $data = [
        'dineInCount' => $dineInCount,
        'deliveryCount' => $deliveryCount,
        'takeAwaysCount' => $takeAways,
        'totalCount'=>$totalCount,
    ];

    // Log the data for debugging
    \Log::info('Dine-In Count: ' . $dineInCount);
    \Log::info('Delivery Count: ' . $deliveryCount);
    \Log::info('TakeAway Count: ' . $takeAways);


    return response()->json($data);
}

}
