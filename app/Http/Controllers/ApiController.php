<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\City;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Restro;
use App\Models\Recipe;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CompanyCoupon;
use App\Models\Order;
use App\Models\Menu;
use App\Models\DeliveryAddress;
use App\Models\DeliveryBoy;
use App\Models\Table;
use App\Models\Gst;
use App\Models\Notification;
use Razorpay\Api\Api;


use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import the QrCode facade
use Carbon\Carbon;

class ApiController extends Controller
{
    public function user_registration_working(Request $request)
    {

        $user = User::where('contact', '=', $request->contact)
			->whereNotNull('password')
			->first(); //check already exist
        if (isset($user) && $user != null) {
            //   return $user;
            return response()->json(['status' => false, 'data' => $user, 'message'=>'User Already Exist']); //return already exist user
        } else {
            // dd(1);
            //create new user
            $insert = User::create([
				'name' => $request->name,
                'contact' => $request->contact,
                'role'=>'user',
            ]);
            return response()->json(['status' => true, 'data' => $insert, 'id'=>$insert->id]);
        }
	 }

	public function add_password(Request $request){

    $user = User::where('id', $request->user_id)->first(); // Execute the query and retrieve the user

    if ($user) {
        $hashedPassword = Hash::make($request->pin); // Hash the password
        $user->update([
            'password' => $hashedPassword,
        ]);
        return response()->json(['status' => true, 'message' => 'Password added successfully']);
    } else {

        return response()->json(['status' => false, 'message' => 'User not found']);
    }
}

    public function get_user(Request $request)
    {
        $get_user = User::find($request->id);
        if ($get_user) {
            return response()->json(['status' => true, 'data' => $get_user]);
        } else {
            return response()->json(['status' => false, 'message' => 'User not found']);
        }
    }


public function send_mobile_verify_otp2(Request $request)
{
    $otp = rand(1000, 9999);
    $name = 'Sir/Mam';
    $msg = 'Dear ' . $name . ', Your OTP is ' . $otp . '. Send by WEBMEDIA';
    $msg = urlencode($msg);
    $to = $request->contact;
    $data1 = "uname=habitm1&pwd=habitm1&senderid=WMEDIA&to=" .
        $to . "&msg=" . $msg .
        "&route=T&peid=1701159196421355379&tempid=1707161527969328476";
    $ch = curl_init('http://bulksms.webmediaindia.com/sendsms?');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
return response()->json($otp);
    //return response()->json(['otp' => $otp]);
}

public function send_mobile_verify_otp_previous(Request $request)
{
    // Validate the request data
    $request->validate([
        'contact' => 'required',
    ]);

    $contact = $request->contact;

    // Check if the contact already exists
    $contactExists = User::where('contact', $contact)->exists();

    if ($contactExists) {
        return response()->json(['data'=>['status'=>false, 'message' => 'Mobile Number already exists']], 400);
    }else{

    // Generate OTP
    $otp = rand(1000, 9999);
    $name = 'Sir/Mam';
    $msg = 'Dear ' . $name . ', Your OTP is ' . $otp . '. Sent by WEBMEDIA';
    $msg = urlencode($msg);

    // Prepare data for sending SMS
    $data1 = "uname=habitm1&pwd=habitm1&senderid=WMEDIA&to=" . $contact . "&msg=" . $msg .
        "&route=T&peid=1701159196421355379&tempid=1707161527969328476";

    // Send SMS using curl
    $ch = curl_init('http://bulksms.webmediaindia.com/sendsms?');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return response()->json(['data'=>['status'=>true, 'otp' => $otp]]);
}
}


public function send_mobile_verify_otp_working(Request $request)
{
    // Validate the request data
    $request->validate([
        'contact' => 'required',
    ]);

    $contact = $request->contact;

    // Check if the contact already exists
    $contactExists = User::where('contact', $contact)->exists();

    if ($contactExists) {
        return response()->json(['data'=>['status'=>false, 'message' => 'Mobile Number already exists']], 400);
    } else {
        // Generate OTP
        $otp = rand(1000, 9999);
        $name = 'Sir/Mam';
        $msg = 'Dear ' . $name . ', Your OTP is ' . $otp . '. Send by WEBMEDIA';
        $msg = urlencode($msg);

        // Prepare data for sending SMS
        $data1 = "uname=habitm1&pwd=habitm1&senderid=WMEDIA&to=" . $contact . "&msg=" . $msg .
            "&route=T&peid=1701159196421355379&tempid=1707161527969328476";

        // Send SMS using curl
        $ch = curl_init('http://bulksms.webmediaindia.com/sendsms?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        // Log the curl response and error (if any)
        \Log::info('SMS API Response: ' . $result);
        if ($curl_error) {
            \Log::error('SMS API Error: ' . $curl_error);
        }

        return response()->json(['data'=>['status'=>true, 'otp' => $otp]]);
    }
}


//updated api dont need to pass id
public function updateUser222(Request $request)
    {
        $updateUser = User::where('id', $request->id)->orderby('id', 'desc')->first();
        if ($updateUser) {
            $updateUser->update([
                'name' => $request->name,
				'password' => $request->password,
                'contact' => $request->contact,
                'email' => $request->email,
                'gender' => $request->gender,
                'address' => $request->address,
            ]);
        }
        if ($updateUser->id) {
            return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
        }
    }


public function updateUser_old(Request $request)
{
    // Find the user by ID
    $updateUser = User::find($request->id);

    if ($updateUser) {
        // Get only the fields that are present in the request
        $updateData = array_filter($request->only(['name', 'password', 'contact', 'email', 'gender', 'address']), function ($value) {
            return !is_null($value);
        });

        // If password is provided, hash it before updating
        if (isset($updateData['password'])) {
            $updateData['password'] = bcrypt($updateData['password']);
            unset($updateData['password']);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Validate the uploaded file
            $request->validate([
                'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
            ]);

            // Get the file from the request
            $file = $request->file('profile_picture');

            // Generate a unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Define the path where the file should be stored
            $path = public_path('profile_pictures');

            // Ensure the directory exists
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Move the file to the desired location
            $file->move($path, $filename);

            // Add the profile picture path to the update data
            $updateData['profile_picture'] = $filename;
        }

        // Update the user with the prepared data array
        $updateUser->update($updateData);

        // Return a success response
        return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
    } else {
        // Return an error response if the user was not found
        return response()->json(['status' => false, 'message' => 'User not found']);
    }
}


		public function updateUserWorks(Request $request)
	{
		// Find the user by ID
		$updateUser = User::find($request->id);

		if ($updateUser) {
			// Get only the fields that are present in the request
			$updateData = array_filter($request->only(['name', 'password', 'contact', 'email', 'gender', 'address']), function ($value) {
				return !is_null($value);
			});

			// If password is provided, hash it before updating
			if (isset($updateData['password'])) {
				$updateData['password'] = bcrypt($updateData['password']);
				unset($updateData['password']);
			}

			// Handle profile picture upload
			if ($request->hasFile('profile_picture')) {
				// Validate the uploaded file
				$request->validate([
					'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
				]);

				// Get the file from the request
				$file = $request->file('profile_picture');

				// Generate a unique filename
				$filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

				// Define the path where the file should be stored
				$path = public_path('profile_pictures');

				// Ensure the directory exists
				if (!file_exists($path)) {
					mkdir($path, 0777, true);
				}

				// Move the file to the desired location
				$file->move($path, $filename);

				// Add the profile picture path to the update data
				$updateData['profile_picture'] = $filename;
			}

			// Update the user with the prepared data array
			$updateUser->update($updateData);
	//dd($updateUser);
			// Return a success response
			return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
		} else {
			// Return an error response if the user was not found
			return response()->json(['status' => false, 'message' => 'User not found']);
		}
	}



	public function updateUser(Request $request)
{
    // Find the user by ID
    $updateUser = User::find($request->id);

    if ($updateUser) {
        // Get only the fields that are present in the request
        $updateData = array_filter($request->only(['name', 'password', 'contact', 'email', 'gender', 'address']), function ($value) {
            return !is_null($value);
        });

        // If password is provided, hash it before updating
        if (isset($updateData['password'])) {
            $updateData['password'] = bcrypt($updateData['password']);
            unset($updateData['password']);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Validate the uploaded file
            $request->validate([
                'profile_picture' => 'image|mimes:jpeg,png,jpg,gif', // Adjust validation rules as needed
            ]);

            // Get the file from the request
            $file = $request->file('profile_picture');

            // Generate a unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Define the path where the file should be stored
            $path = public_path('profile_pictures');

            // Ensure the directory exists
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Move the file to the desired location
            $file->move($path, $filename);

            // Add the profile picture path to the update data
            $updateData['profile_picture'] = $filename;
        }
//dd($updateData);
        // Assign a default profile picture based on gender if no profile picture is provided
        if (!isset($updateData['profile_picture']) && isset($updateData['gender'])) {
            $gender = strtolower($updateData['gender']);
            if ($gender == 'female') {
                $updateData['profile_picture'] = 'Female.png';
				//dd(2);
            } elseif ($gender == 'male') {
                $updateData['profile_picture'] = 'Male.png';
				//dd($updateData);
            }elseif ($gender == 'other') {
                $updateData['profile_picture'] = 'Other.png';
				//dd($updateData);
            }
        }

        // Update the user with the prepared data array
        $updateUser->update($updateData);

        // Return a success response
        return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
    } else {
        // Return an error response if the user was not found
        return response()->json(['status' => false, 'message' => 'User not found']);
    }
}


public function removeProfile(Request $request)
{
	$profile = User::where('id', $request->user_id)->first();

	if($profile){
	$profile->update(['profile_picture'=>null]);


		return response()->json(['status'=>true, 'message'=>'Profile Picture Removed Successfully']);
	}
	else{
	return response()->json(['status'=>false, 'message'=>'User Not Found']);
	}
}


public function getCity(Request $request)
{
    $city = new City();
    $data = $city->all();

    return response()->json(['status' => true, 'message' => 'All data retrieved successfully', 'data' => $data], 200);
}

	  public function update_city(Request $request)
    {
        $update_user = City::where('id', $request->id)->first();
        if ($update_user) {
            $update_user->update([
                'city_id' => $request->city_id,
            ]);
        }
        if ($update_user->id) {
            return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
        }
    }


public function getBanner(Request $request)
{
    $banner = Banner::where('city', $request->city_id)
   // $data = $banner->all();
->get();
    return response()->json(['status' => true, 'message' => 'All data retrieved successfully', 'data' => $banner], 200);
}

public function getCategory(Request $request)
{
    $category = new Category();
    $data = $category->all();

    return response()->json(['status' => true, 'message' => 'All data retrieved successfully', 'data' => $data], 200);
}



public function get_coupon(Request $request)
{
    $coupon = Coupon::
   // where('restaurant_id', $request->restro_id)

    // join is used to show category name without this it will only show category id.
    join('restro','restro.id','=','coupon.restaurant_id')
    ->select('coupon.*','restro.restaurant')
    ->get();
    if($coupon)
    {
        return response()->json(['status'=>true,'data'=>$coupon]);
    }else{
        return response()->json(['status'=>false,'message'=>'data not found']);
    }
}


public function get_company_coupon(Request $request)
{
    $coupon = CompanyCoupon::
   // where('restaurant_id', $request->restro_id)

    // join is used to show category name without this it will only show category id.
    join('restro','restro.id','=','company_coupon.restaurant_id')
    ->select('company_coupon.*','restro.restaurant')
    ->get();
    if($coupon)
    {
        return response()->json(['status'=>true,'data'=>$coupon]);
    }else{
        return response()->json(['status'=>false,'message'=>'data not found']);
    }
}



public function get_recipe(Request $request)
{
    $recipe = Recipe::
    where('category_id', $request->category_id)

    // join is used to show category name without this it will only show category id.
    ->join('category','category.id','=','recipe.category_id')
    ->select('recipe.*','category.category')
    ->get();
    if($recipe)
    {
        return response()->json(['status'=>true,'data'=>$recipe]);
    }else{
        return response()->json(['status'=>false,'message'=>'data not found']);
    }
}



public function getCart22(Request $request)
{
    $added_time_data = Cart::where('user_id', $request->user_id)
        ->where('order_id', null)
		->where('cart.type','Delivery') // Filter cart where type is null
        ->get();

    $added_time_ids = $added_time_data->pluck('recipe_id')->toArray();

    $items = Menu::whereIn('id', $added_time_ids)->get();

    foreach ($items as $item) {
        $cardData = $added_time_data->firstWhere('recipe_id', $item->id);

        if ($cardData) {
            $recipe_price = $cardData->quantity * $item->price;
            Cart::where('user_id', $request->user_id)
                ->where('recipe_id', $item->id)
                ->update([
                    'recipe_name' => $item->recipe,
                    'recipe_price' => $recipe_price,
                ]);
        }
    }

    $get_cart = Cart::where('cart.user_id', $request->user_id)
        ->where('order_id', null)
    	->where('cart.type','Delivery') // Filter cart where type is null
        ->select('cart.id','cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id','cart.coupon_code',  'cart.recipe_name','cart.varient', 'cart.recipe_price', 'cart.quantity',  'recipe.recipe', 'restro.restaurant')
        ->leftjoin('restro', 'restro.id', '=', 'cart.restro_id')
        ->leftjoin('recipe', 'recipe.id', '=', 'cart.recipe_id')
		->leftjoin('coupon', 'coupon.code', '=', 'cart.coupon_code')
       ->groupBy('cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.coupon_code', 'cart.recipe_name', 'cart.varient','cart.recipe_price', 'cart.quantity', 'recipe.recipe', 'restro.restaurant')

		// Include 'recipe_price' in the GROUP BY clause
        ->where('user_id', $request->user_id)
        ->get();

	  // Add index to each item
    $get_cart = $get_cart->map(function ($item, $index) {
        $item['index'] = $index + 1; // Index starts from 1
        return $item;
    });

  // Calculate grand total of recipe prices in the cart
    $grandTotal = $get_cart->sum('recipe_price');
    $totalBeforeDiscount = $grandTotal; // Store the total before applying any discount
//\Log::info("Grand Total: {$grandTotal}");
    // Apply coupon logic if there's a coupon code in the cart
    $appliedCoupon = null;
    if (!empty($get_cart[0]->coupon_code)) {
        $couponCode = $get_cart[0]->coupon_code;
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon && $grandTotal >= $coupon->min_cost) {
            if ($coupon->dstype === 'Rupee') {
                $grandTotal -= $coupon->value;
            } elseif ($coupon->dstype === 'Percent') {
                $discountAmount = ($coupon->value / 100) * $grandTotal;
                $grandTotal -= $discountAmount;
            }
            $appliedCoupon = $coupon;
        }
    }

    // Prepare response data
    $responseData = [
        'status' => true,
        'data' => $get_cart,
		  'total_before_discount' => $totalBeforeDiscount,
        'grand_total' => $grandTotal,
    ];

    if ($appliedCoupon) {
        $responseData['applied_coupon'] = $appliedCoupon;
    }

    return response()->json($responseData);
}

public function getCart_previous(Request $request)
{
    // Fetch cart data for the requested user with order_id null and type 'Delivery'
    $added_time_data = Cart::where('user_id', $request->user_id)
        ->where('order_id', null)
        ->where('type', 'Delivery')
        ->get();

    // Group by recipe_id and sum quantities
    $groupedCart = $added_time_data->groupBy('recipe_id')->map(function ($group) {
        $firstItem = $group->first();
        $firstItem->quantity = $group->sum('quantity');
        return $firstItem;
    });

    $added_time_ids = $groupedCart->pluck('recipe_id')->toArray();

    $items = Menu::whereIn('id', $added_time_ids)->get();

    foreach ($items as $item) {
        $cardData = $groupedCart->firstWhere('recipe_id', $item->id);

        if ($cardData) {
            $recipe_price = $cardData->quantity * $item->price;
            Cart::where('user_id', $request->user_id)
                ->where('recipe_id', $item->id)
                ->update([
                    'recipe_name' => $item->recipe,
                    'recipe_price' => $recipe_price,
                ]);
        }
    }

    // Fetch and join data to get the final cart items
    $get_cart = Cart::where('cart.user_id', $request->user_id)
        ->where('order_id', null)
        ->where('cart.type', 'Delivery')
        ->select('cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.coupon_code', 'cart.recipe_name', 'cart.varient', 'cart.recipe_price', 'cart.quantity', 'recipe.recipe', 'restro.restaurant', 'coupon.value')
        ->leftJoin('restro', 'restro.id', '=', 'cart.restro_id')
        ->leftJoin('recipe', 'recipe.id', '=', 'cart.recipe_id')
        ->leftJoin('coupon', 'coupon.code', '=', 'cart.coupon_code')
        ->groupBy('cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.coupon_code', 'cart.recipe_name', 'cart.varient', 'cart.recipe_price', 'cart.quantity', 'recipe.recipe', 'restro.restaurant', 'coupon.value')
        ->where('user_id', $request->user_id)
        ->get();

    // Merge quantities for the same recipe_id
    $mergedCart = collect();
    foreach ($get_cart as $item) {
        $existingItem = $mergedCart->firstWhere('recipe_id', $item->recipe_id);
        if ($existingItem) {
            $existingItem->quantity += $item->quantity;
            $existingItem->recipe_price += $item->recipe_price;
        } else {
            $mergedCart->push($item);
        }
    }

    // Add index to each item
    $mergedCart = $mergedCart->map(function ($item, $index) {
        $item['index'] = $index + 1; // Index starts from 1
        return $item;
    });

    // Calculate grand total of recipe prices in the cart
    $grandTotal = $mergedCart->sum('recipe_price');
    $totalBeforeDiscount = $grandTotal; // Store the total before applying any discount

    // Apply coupon logic if there's a coupon code in the cart
    $appliedCoupon = null;
    if (!empty($mergedCart[0]->coupon_code)) {
        $couponCode = $mergedCart[0]->coupon_code;
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon && $grandTotal >= $coupon->min_cost) {
            if ($coupon->dstype === 'Rupee') {
                $grandTotal -= $coupon->value;
            } elseif ($coupon->dstype === 'Percent') {
                $discountAmount = ($coupon->value / 100) * $grandTotal;
                $grandTotal -= $discountAmount;
            }
            $appliedCoupon = $coupon;
        }
    }

    // Prepare response data
    $responseData = [
        'status' => true,
        'data' => $mergedCart,
        'total_before_discount' => $totalBeforeDiscount,
        'grand_total' => $grandTotal,
    ];

    if ($appliedCoupon) {
        $responseData['applied_coupon'] = $appliedCoupon;
		    return response()->json([
        'status' => true,
        'data' => $mergedCart,
        'total_before_discount' => $totalBeforeDiscount,
        'grand_total' => $grandTotal,
		'message'=>'Coupon Applied'
    ]);

    }else{
		  return response()->json([
        'status' => true,
        'data' => $mergedCart,
        'total_before_discount' => $totalBeforeDiscount,
        'grand_total' => $grandTotal,
		'message'=>'Coupon Not Applied'
    ]);


	}

   // return response()->json($responseData);
}

	public function getCartX(Request $request)
{
    // Fetch cart data for the requested user with order_id null and type 'Delivery'
    $added_time_data = Cart::where('user_id', $request->user_id)
        ->where('order_id', null)
        ->where('type', 'Delivery')
        ->get();

    // Group by recipe_id and sum quantities
    $groupedCart = $added_time_data->groupBy('recipe_id')->map(function ($group) {
        $firstItem = $group->first();
        $firstItem->quantity = $group->sum('quantity');
        return $firstItem;
    });

    $added_time_ids = $groupedCart->pluck('recipe_id')->toArray();

    $items = Menu::whereIn('id', $added_time_ids)->get();

    foreach ($items as $item) {
        $cardData = $groupedCart->firstWhere('recipe_id', $item->id);

        if ($cardData) {
            $total_recipe_price = $cardData->quantity * $item->price;
                        $recipe_price = $item->price;
			Cart::where('user_id', $request->user_id)
                ->where('recipe_id', $item->id)
                ->update([
                    'recipe_name' => $item->recipe,
                    'recipe_price' => $recipe_price,
                ]);
        }
    }

    // Fetch and join data to get the final cart items
    $get_cart = Cart::where('cart.user_id', $request->user_id)
        ->where('order_id', null)
        ->where('cart.type', 'Delivery')
        ->select('cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.coupon_code', 'cart.recipe_name', 'cart.varient', 'cart.recipe_price', 'cart.quantity', 'recipe.recipe', 'restro.restaurant')
        ->leftJoin('restro', 'restro.id', '=', 'cart.restro_id')
        ->leftJoin('recipe', 'recipe.id', '=', 'cart.recipe_id')
        ->leftJoin('coupon', 'coupon.code', '=', 'cart.coupon_code')
        ->groupBy('cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.coupon_code', 'cart.recipe_name', 'cart.varient', 'cart.recipe_price', 'cart.quantity', 'recipe.recipe', 'restro.restaurant')
        ->where('user_id', $request->user_id)
        ->get();

    // Merge quantities for the same recipe_id
    $mergedCart = collect();
    foreach ($get_cart as $item) {
        $existingItem = $mergedCart->firstWhere('recipe_id', $item->recipe_id);
        if ($existingItem) {
            $existingItem->quantity += $item->quantity;
            //$existingItem->recipe_price += $item->recipe_price;
            $existingItem->total_recipe_price += $item->recipe_price;

        } else {
            $mergedCart->push($item);
        }
    }

    // Add index to each item
    $mergedCart = $mergedCart->map(function ($item, $index) {
        $item['index'] = $index + 1; // Index starts from 1
        return $item;
    });

    // Calculate grand total of recipe prices in the cart
    //$grandTotal = $mergedCart->sum('recipe_price');
        $grandTotal = $mergedCart->sum('total_recipe_price');
		$totalBeforeDiscount = $grandTotal; // Store the total before applying any discount

    // Apply coupon logic if there's a coupon code in the cart
    $appliedCoupon = null;
    if (!empty($mergedCart[0]->coupon_code)) {
        $couponCode = $mergedCart[0]->coupon_code;
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon && $grandTotal >= $coupon->min_cost) {
            if ($coupon->dstype === 'Rupee') {
                $grandTotal -= $coupon->value;
            } elseif ($coupon->dstype === 'Percent') {
                $discountAmount = ($coupon->value / 100) * $grandTotal;
                $grandTotal -= $discountAmount;
            }
            $appliedCoupon = $coupon;
        }
    }

    // Prepare response data
    $responseData = [
        'status' => true,
        'data' => $mergedCart,
        'total_before_discount' => $totalBeforeDiscount,
        'grand_total' => $grandTotal,
    ];

    if ($appliedCoupon) {
        $responseData['applied_coupon'] = $appliedCoupon;
		    return response()->json([
        'status' => true,
        'data' => $mergedCart,
        'total_before_discount' => $totalBeforeDiscount,
        'grand_total' => $grandTotal,
		'message'=>'Coupon Applied'
    ]);

    }else{
		  return response()->json([
        'status' => true,
        'data' => $mergedCart,
        'total_before_discount' => $totalBeforeDiscount,
        'grand_total' => $grandTotal,
		'message'=>'Coupon Not Applied'
    ]);


	}

   // return response()->json($responseData);
}


	public function getCart(Request $request)
{
    // Fetch cart data for the requested user with order_id null and type 'Delivery'
    $cartItems = Cart::where('user_id', $request->user_id)
        ->where('order_id', null)
        ->where('type', 'Delivery')
        ->get();

    // Group by recipe_id and sum quantities
    $groupedCart = $cartItems->groupBy('recipe_id')->map(function ($group) {
        $firstItem = $group->first();
        $firstItem->quantity = $group->sum('quantity');
        return $firstItem;
    });

    $recipeIds = $groupedCart->pluck('recipe_id')->toArray();
    $recipes = Menu::whereIn('id', $recipeIds)->get();

    foreach ($recipes as $recipe) {
        $cartItem = $groupedCart->firstWhere('recipe_id', $recipe->id);

        if ($cartItem) {
            $cartItem->recipe_price = $recipe->price;
            $cartItem->total_recipe_price = $cartItem->quantity * $recipe->price;

            Cart::where('user_id', $request->user_id)
                ->where('recipe_id', $recipe->id)
                ->update([
                    'recipe_name' => $recipe->recipe,
                    'recipe_price' => $recipe->price,
                ]);
        }
    }

    // Fetch and join data to get the final cart items
    $getCart = Cart::where('user_id', $request->user_id)
        ->where('order_id', null)
        ->where('cart.type', 'Delivery')
        ->select('cart.*', 'recipe.recipe', 'restro.restaurant')
        ->leftJoin('restro', 'restro.id', '=', 'cart.restro_id')
        ->leftJoin('recipe', 'recipe.id', '=', 'cart.recipe_id')
        ->leftJoin('coupon', 'coupon.code', '=', 'cart.coupon_code')
        ->get();

    // Merge quantities for the same recipe_id
    $mergedCart = $getCart->groupBy('recipe_id')->map(function ($group) {
        $firstItem = $group->first();
        $firstItem->quantity = $group->sum('quantity');
        $firstItem->total_recipe_price = $firstItem->quantity * $firstItem->recipe_price;
        return $firstItem;
    });

    // Calculate grand total of recipe prices in the cart
    $grandTotal = $mergedCart->sum('total_recipe_price');
    $totalBeforeDiscount = $grandTotal; // Store the total before applying any discount

    // Apply coupon logic if there's a coupon code in the cart
    $appliedCoupon = null;
    if (!empty($mergedCart->first()->coupon_code)) {
        $couponCode = $mergedCart->first()->coupon_code;
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon && $grandTotal >= $coupon->min_cost) {
            if ($coupon->dstype === 'Rupee') {
                $grandTotal -= $coupon->value;
            } elseif ($coupon->dstype === 'Percent') {
                $discountAmount = ($coupon->value / 100) * $grandTotal;
                $grandTotal -= $discountAmount;
            }
            $appliedCoupon = $coupon;
        }
    }

    // Prepare response data
    $responseData = [
        'status' => true,
        'data' => $mergedCart->values(), // Convert collection to array
        'total_before_discount' => $totalBeforeDiscount,
        'grand_total' => $grandTotal,
        'message' => $appliedCoupon ? 'Coupon Applied' : 'Coupon Not Applied'
    ];

    if ($appliedCoupon) {
        $responseData['applied_coupon'] = $appliedCoupon;
    }

    return response()->json($responseData);
}


public function addToCart___working(Request $request)
{
    // Delete existing records for the user and restaurant combination
    $delete = Cart::where('user_id', $request->user_id)
        ->where('restro_id', $request->restro_id)
        ->where('order_id', null)
        ->delete();

    $item = explode(',', $request->recipe_id);
    $quantity = explode(',', $request->quantity);

    $insert = false;

    for ($i = 0; $i < count($item); $i++) {
        if (isset($request->recipe_id[$i])) {
            $item_details = Menu::where('id', $item[$i])->select('recipe', 'price', 'varient')->first();

            $insert = Cart::create([
                'user_id' => $request->user_id,
                'restro_id' => $request->restro_id,
                'recipe_id' => $item[$i],
				 'type' => "Delivery",

                'recipe_name' => $item_details->recipe,
                'quantity' => $quantity[$i],
				'varient'=>$item_details->varient,
                'recipe_price' => $quantity[$i] * $item_details->price, // Corrected column name
                'status' => 'Pending',
                'verify' => 1
            ]);
        }
    }


    if ($insert) {
        return response()->json(['status' => true, 'message' => 'data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
}



	public function addToCart1(Request $request)
{
    // Delete existing records for the user and restaurant combination

    $item = $request->recipe_id;
    $quantity = 1;

    $item_details = Menu::where('id', $item)
		->whereNotNull('varient')
		->select('recipe', 'price', 'varient')->first();
//dd($item_details);
    if ($item_details) {
        $insert = Cart::create([
            'user_id' => $request->user_id,
            'restro_id' => $request->restro_id,
            'recipe_id' => $item,
            'type' => "Delivery",
            'recipe_name' => $item_details->recipe,
            'quantity' => $quantity,
            'varient' => $item_details->varient,
            'recipe_price' => $quantity * $item_details->price,
            'status' => 'Pending',
            'verify' => 1
        ]);

        if ($insert) {
            return response()->json(['status' => true, 'message' => 'Data has been submitted']);
        } else {
            return response()->json(['status' => false, 'message' => 'Data not found']);
        }
    } else {
        return response()->json(['status' => false, 'message' => 'Item details not found']);
    }
}

public function addToCart(Request $request)
{
    $items = explode(',', $request->recipe_id); // Split the recipe IDs
    //$quantities = explode(',', $request->quantity); // Split the quantities
    $quantity = 1;

    $insert = false;

    for ($i = 0; $i < count($items); $i++) {
        $item = $items[$i];
        //$quantity = isset($quantities[$i]) ? $quantities[$i] : 1; // Use the provided quantity or default to 1

        $item_details = Menu::where('id', $item)
            ->whereNotNull('varient') // Ensure varient is not null
            ->select('recipe', 'price', 'varient')
            ->first();

        if ($item_details) {
            $insert = Cart::create([
                'user_id' => $request->user_id,
                'restro_id' => $request->restro_id,
                'recipe_id' => $item,
                'type' => "Delivery",
                'recipe_name' => $item_details->recipe,
                'quantity' => $quantity,
                'varient' => $item_details->varient,
                'recipe_price' => $quantity * $item_details->price,
                'status' => 'Pending',
                'verify' => 1
            ]) || $insert; // Ensure insert flag is true if any insertion succeeds
        }
    }

    if ($insert) {
        return response()->json(['status' => true, 'message' => 'Data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'No valid items to add to cart']);
    }
}


public function addToCartWithoutVarient(Request $request)
{
// Delete existing records for the user and restaurant combination
    //$delete = Cart::where('user_id', $request->user_id)
     //   ->where('restro_id', $request->restro_id)
	//	->where('varient', null)
      //  ->where('order_id', null)
     //   ->delete();

    $item = explode(',', $request->recipe_id);
    //$quantity = explode(',', $request->quantity);
    $quantity = 1;

    $insert = false;

    for ($i = 0; $i < count($item); $i++) {
        if (isset($item[$i])) {
            $item_details = Menu::where('id', $item[$i])
                ->whereNull('varient')  // Check for null varient
                ->select('recipe', 'price', 'varient')
                ->first();
//dd($item_details);
            if ($item_details) {  // Only process if item_details is found
                $insert = Cart::create([
                    'user_id' => $request->user_id,
                    'restro_id' => $request->restro_id,
                    'recipe_id' => $item[$i],
                    'type' => "Delivery",
                    'recipe_name' => $item_details->recipe,
                    //'quantity' => $quantity[$i],
					'quantity' => $quantity,
                    'varient' => $item_details->varient,
                    //'recipe_price' => $quantity[$i] * $item_details->price,
                    'recipe_price' => $quantity * $item_details->price,
                    //'recipe_price' => $item_details->price,
					'status' => 'Pending',
                    'verify' => 1
                ]);
            }
        }
    }

    if ($insert) {
        return response()->json(['status' => true, 'message' => 'Data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}



public function removeLatestCart(Request $request)
{
$latestCart = Cart::where('user_id', $request->user_id)
	->orderBy('created_at', 'desc')
	->first();

	if($latestCart)
	{
		$remove = $latestCart->delete();
		 if ($remove) {
            return response()->json(['status' => true, 'message' => 'Data Deleted Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Data Deletion Failed']);
        }
    } else {
        return response()->json(['status' => false, 'message' => 'User Not Found']);

	}

}

public function updateAddToCart(Request $request)
{
   $cartId = $request->cart_id;
   $newQuantity = $request->quantity;

	$cartItem = Cart::find($cartId);

	if($cartItem){
	$itemDetails = Menu::where('id', $cartItem->recipe_id)->select('price')->first();

		$cartItem->quantity = $newQuantity;
		$cartItem->recipe_price = $newQuantity*$itemDetails->price;
		$cartItem->save();


		  $delete = Cart::where('recipe_id', $cartItem->recipe_id)
            ->where('id', '!=', $cartId) // Exclude the current cart item
        ->where('order_id', null)
        ->delete();


		return response()->json(['status', true, 'message', 'Cart Updated Successfully']);
	}else{
		return response()->json(['status', false, 'message', 'Cart Item not found']);
	}
    }



public function remove_cart(Request $request)
            {
                $remove = cart::where('recipe_id', $request->recipe_id)
                ->where('restro_id', $request->restro_id)
               ->delete();

               if ($remove) {
                   return response()->json(['status' => true, 'message' => 'Data Deleted Successfully']); //array
                } else {
                   return response()->json(['status' => false, 'message' => 'User Not Found']); //array
                }
           }



public function postOrder2(Request $request){

	//dd($request->all());
    $insert = Order::create([
        'order_id2' => 'OD'.time(),
        'restro_id' => $request->restro_id,
        'total' => $request->total,
     'type'=>'Delivery',
        'payment_mode'=>$request->payment_mode,
        'address'=>$request->address,
        'delivery_type'=>$request->delivery_type,
       // 'delivery_charges'=>$request->delivery_charges,
       'contact_number'=>$request->contact,
      //  'alternate_number'=>$request->alternate_number,
      //  'coupon_code'=>$request->coupon_code,
       // 'assign_delivery'=>$request->assign_delivery,
         // 'user_id'=>$request->user_id,
     //   'approval'=>$request->approval,
        'order_date'=>$request->order_date,
		'cooking_instruction'=>$request->cooking_instruction,
		'paymentId'=>$request->paymentId,
        'status'=> "Your order is Pending", //Just massage to show
        'verify' => 1
    ]);

$insert->user_id = $request->user_id;
$insert->save();

    $cart_update = Cart :: where('user_id',$request->user_id)
    ->where('order_id',null)
    ->update([
        'order_id'=>$insert->id,
    ]);

	            $insert->coupon_code = $cart_update->coupon_code;

  // Check if coupon code exists and calculate discount if applicable
    if (coupon_code) {
        $coupon = Coupon::where('restaurant_id', $request->restro_id)
                        ->where('code', $request->coupon_code)
                        ->first();
 $discountAmount = 0;
        if ($coupon) {
            if ($coupon->dstype == 'Rupee') {
                $discountAmount = $coupon->value;
            } elseif ($coupon->dstype == 'Percent') {
                // Calculate discount amount based on percentage
                $discountAmount = ($request->total * $coupon->value) / 100;
            }

			  // Log discount amount for debugging
             \Log::info('Discount Amount:', ['discount' => $discountAmount]);


            // Update order with discount amount
            $insert->discount = $discountAmount;
            $insert->save();
        }
    }

    if($insert) {
        return response()->json(['status' => true, 'message' => 'data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
    }


	public function postOrder(Request $request){
    // Create a new order
    $insert = Order::create([
        'order_id2' => 'OD'.time(),
        'restro_id' => $request->restro_id,
        'total' => $request->total,
        'type' => 'Delivery',
        'payment_mode' => $request->payment_mode,
        'address' => $request->address,
        'delivery_type' => $request->delivery_type,
        'contact_number' => $request->contact,
        'order_date' => $request->order_date,
        'cooking_instruction' => $request->cooking_instruction,
        'paymentId' => $request->paymentId,
        'status' => "Your order is Pending", // Just a message to show
        'verify' => 1,
    ]);

    $insert->user_id = $request->user_id;
    $insert->save();

    // Update the cart with the new order ID
    $cart_update = Cart::where('user_id', $request->user_id)
                        ->where('order_id', null)
                        ->update([
                            'order_id' => $insert->id,
                        ]);

    // Retrieve the coupon code from the cart
    $cart = Cart::where('user_id', $request->user_id)
                ->where('order_id', $insert->id)
                ->first();

    if ($cart && $cart->coupon_code) {
        $coupon_code = $cart->coupon_code;
    } else {
        $coupon_code = null;
    }

    // Check if coupon code exists and calculate discount if applicable
    if ($coupon_code) {
        $coupon = Coupon::where('restaurant_id', $request->restro_id)
                        ->where('code', $coupon_code)
                        ->first();
        $discountAmount = 0;
        if ($coupon) {
            if ($coupon->dstype == 'Rupee') {
                $discountAmount = $coupon->value;
            } elseif ($coupon->dstype == 'Percent') {
                // Calculate discount amount based on percentage
                $discountAmount = ($request->total * $coupon->value) / 100;
            }

            // Log discount amount for debugging
            \Log::info('Discount Amount:', ['discount' => $discountAmount]);

            // Update order with discount amount
            $insert->discount = $discountAmount;
            $insert->coupon_code = $coupon_code;
            $insert->save();
        }
    }

    if($insert) {
        return response()->json(['status' => true, 'message' => 'data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
}


// get order against user id and order id

public function get_order_history2(Request $request)
{

	//$apiKey = env('API_KEY');
   $get_allorder_by_user_id = DB::table('order')
    ->leftjoin('cart', 'cart.order_id', '=', 'order.id')
    ->leftjoin('restro', 'restro.id', '=', 'order.restro_id')
    ->where('order.user_id', $request->user_id)
	->where('order.type', 'Delivery')
    ->orwhere('order.order_id2', $request->order_id)
    ->select('order.id','order.address as order_address','order.otp', 'order.total as grand_total','order.created_at', 'order.order_date','order.status','order.order_id2', 'order.type', 'restro.restaurant',
    'restro.address as restro_address',  'cart.recipe_price', 'cart.recipe_name','cart.quantity', 'cart.varient')
    ->orderBy('order.id','desc') // Optional: Order the results by order ID
    ->get();


// dd($get_allorder_by_user_id);


// Group the results by order ID
$groupedOrders = $get_allorder_by_user_id->groupBy('id');
// Transform the grouped results
$item_list_against_userid = $groupedOrders->map(function ($orders) {
    return [
        'id' => $orders->first()->id,
        'order_id2' => $orders->first()->order_id2,
         'grand_total' => $orders->first()->grand_total,
        'order_date' => $orders->first()->created_at,
		//'otp'=>$orders->first()->otp,
        'recipe_price'=> $orders->first()->recipe_price,
        'restaurant' => $orders->first()->restaurant,
		'order_address'=> $orders->first()->order_address,
		'type'=> $orders->first()->type,
        'restro_address'=> $orders->first()->restro_address,
        'status' => $orders->first()->status,
        'cards' => $orders->map(function ($card) {
			static $index = 0; // Initialize the index
            $index++; // Increment the index for each card
            return [
				'index' => $index, // Add 1 to start index from 1
                'recipe_name' => $card->recipe_name,
                'quantity' => $card->quantity,
				'recipe_price'=>$card->recipe_price,
				'varient'=>$card->varient,

                // 'recipe_price' => $card->recipe_price,
            ];
        })->toArray(),
    ];

})->values()->all();
// dd($get_allorder_by_user_id);
if (!empty($item_list_against_userid)) {
    return response()->json(['status' => true, 'data' => $item_list_against_userid]);
} else {
    return response()->json(['status' => false, 'message' => 'Data not found']);
}
}


	public function get_order_history(Request $request)
{
    //$apiKey = env('API_KEY');
    $get_allorder_by_user_id = DB::table('order')
        ->leftJoin('cart', 'cart.order_id', '=', 'order.id')
        ->leftJoin('restro', 'restro.id', '=', 'order.restro_id')
		->leftJoin('delivery_boy', 'delivery_boy.user_id', '=', 'order.delivery_boy_id')
		->leftJoin('coupon', 'coupon.code', '=', 'cart.coupon_code')

        ->where('order.user_id', $request->user_id)
        ->where('order.type', 'Delivery')
        ->orWhere('order.order_id2', $request->order_id)
        ->select('order.id', 'order.address as order_address', 'order.otp','cart.coupon_code', 'coupon.value', 'order.discount','order.total as grand_total', 'order.created_at', 'order.order_date', 'order.status', 'order.order_id2', 'order.type', 'order.cooking_instruction', 'restro.restaurant', 'restro.address as restro_address', 'restro.avg_cooking_time', 'cart.recipe_price', 'cart.recipe_name', 'cart.quantity', 'cart.varient', 'delivery_boy.latitude', 'delivery_boy.longitude')
        ->orderBy('order.id', 'desc') // Optional: Order the results by order ID
        ->get();

    // Group the results by order ID
    $groupedOrders = $get_allorder_by_user_id->groupBy('id');
    // Transform the grouped results
    $item_list_against_userid = $groupedOrders->map(function ($orders) {
        $firstOrder = $orders->first();
        $orderData = [
            'id' => $firstOrder->id,
            'order_id2' => $firstOrder->order_id2,
			'coupon_code' => $firstOrder->coupon_code,
			'coupon_code_value' => $firstOrder->value,
			'discount' => $firstOrder->discount,
            'grand_total' => $firstOrder->grand_total,
            'order_date' => $firstOrder->created_at,
            'restaurant' => $firstOrder->restaurant,
            'order_address' => $firstOrder->order_address,
            'type' => $firstOrder->type,
			'cooking_instruction' => $firstOrder->cooking_instruction,
            'restro_address' => $firstOrder->restro_address,
			'delivery_boy_latitude' => $firstOrder->latitude,
            'delivery_boy_longitude' => $firstOrder->longitude,
			'avg_cooking_time' => $firstOrder->avg_cooking_time,
            'status' => $firstOrder->status,
        ];

        // Conditionally add OTP based on the order status
        if ($firstOrder->status !== 'Order Delivered') {
            $orderData['otp'] = $firstOrder->otp;
        }

        $orderData['cards'] = $orders->map(function ($card) {
            static $index = 0; // Initialize the index
            $index++; // Increment the index for each card
            return [
                'index' => $index, // Add 1 to start index from 1
                'recipe_name' => $card->recipe_name,
                'quantity' => $card->quantity,
                'recipe_price' => $card->recipe_price,
                'varient' => $card->varient,
            ];
        })->toArray();

        return $orderData;
    })->values()->all();

    if (!empty($item_list_against_userid)) {
        return response()->json(['status' => true, 'data' => $item_list_against_userid]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}



public function order_send_to_waiter(Request $request)
            {
                $accept_order = Order::where('order_id2', $request->order_id)->first();
                if ($accept_order->id) {
                    $accept_order->update([
                        'status'=>'Searching for Waiter',
						// 'restro_status'=>'Pending Delivery Boy',
                        'waiter_status'=>'Searching for Waiter',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }


public function order_send_to_kitchen(Request $request)
            {
                $accept_order = Order::where('order_id2', $request->order_id)->first();
                if ($accept_order->id) {
                    $accept_order->update([
                        //'status'=>'Searching for Waiter',
						'kitchen_status'=>'Waiting for Kitchen',
                        'waiter_status'=>'Waiting for Kitchen',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }



public function get_restro(Request $request)
{
    $restro = Restro::
    // where('category_id', $request->category_id)

    // join is used to show category name without this it will only show category id.
    leftjoin('city','city.id','=','restro.city')
    ->leftjoin('category','category.id','=','restro.category')
      ->leftjoin('time_slot', 'time_slot.restro_id', '=', 'restro.id')
    ->select('restro.*','category.category', 'city.city', 'time_slot.*')
    ->get();
    if($restro)
    {
        return response()->json(['status'=>true,'data'=>$restro]);
    }else{
        return response()->json(['status'=>false,'message'=>'data not found']);
    }
}

	public function get_restro_data(Request $request)
{
    $restro = Restro::
        where('restro.city', $request->city_id)
        ->leftjoin('city','city.id','=','restro.city')
       // ->leftjoin('category','category.id','=','restro.category')
        ->leftjoin('time_slot', 'time_slot.restro_id', '=', 'restro.id')
        ->select('restro.*', 'city.city', 'time_slot.open_at', 'time_slot.close_at')
        ->get();

    if($restro->isNotEmpty()) {
        $groupedRestro = $restro->groupBy('id')->map(function($items) {
            $restroDetails = $items->first();
            $timeSlots = $items->map(function($item) {
                return [
                    'open_at' => $item->open_at,
                    'close_at' => $item->close_at,
                ];
            })->toArray();


			   // Decode the category JSON string
            // $categoryIds = json_decode($restroDetails->category, true);
            $categoryIds = $restroDetails->category;

            if (is_array($categoryIds)) {
                // Fetch the category names based on the IDs
                $categories = Category::whereIn('id', $categoryIds)->pluck('category')->toArray();
                $restroDetails->category = $categories;
            } else {
                $restroDetails->category = [];
            }


            $restroDetails->time_slots = $timeSlots;
            return $restroDetails;
        });

        return response()->json(['status'=>true,'data'=>$groupedRestro->values()]);
    } else {
        return response()->json(['status'=>false,'message'=>'Data not found']);
    }
}



public function get_restro_new(Request $request)
{
    $restro = Restro::
    where('restro.city', $request->city_id)

    // join is used to show category name without this it will only show category id.
    ->leftjoin('city','city.id','=','restro.city')
    ->leftjoin('category','category.id','=','restro.category')
    ->select('restro.*','category.category', 'city.city')
    ->get();
    if($restro)
    {
        return response()->json(['status'=>true,'data'=>$restro]);
    }else{
        return response()->json(['status'=>false,'message'=>'data not found']);
    }
}


//-------------------------------


public function get_restro_against_category(Request $request)
{
    // Ensure $request->category_id is not an empty string before exploding
    $categoryIds = $request->category_id ? explode(',', $request->category_id) : [];

    if (!empty($categoryIds)) {
        $restro = Restro::
            where(function ($query) use ($categoryIds) {
                foreach ($categoryIds as $categoryId) {
                    $query->orWhere('restro.category', 'LIKE', '%' . $categoryId . '%');
                }
            })
            ->leftjoin('city', 'city.id', '=', 'restro.city')
            ->leftjoin('category', 'category.id', '=', 'restro.category')
            ->select('restro.*', 'category.category', 'city.city')
            ->get();

        if ($restro->isNotEmpty()) {
            return response()->json(['status' => true, 'data' => $restro]);
        } else {
            return response()->json(['status' => false, 'message' => 'Data not found']);
        }
    } else {
        return response()->json(['status' => false, 'message' => 'Invalid category IDs']);
    }
}

// ------------------------------

public function getMenu222(Request $request)
{
    $restaurantId = $request->input('restaurant_id');

    if (!$restaurantId) {
        return response()->json(['status' => false, 'message' => 'Restaurant ID not provided']);
    }

    $menu = Recipe::leftJoin('restro', 'restro.id', '=', 'recipe.restaurant_id')
    ->leftjoin('category','category.id','=','recipe.category_id')
        ->where('recipe.restaurant_id', $restaurantId) // Filter by restaurant_id
        ->select('recipe.*', 'restro.address', 'restro.restaurant', 'category.category')
        ->get();

    if ($menu->isNotEmpty()) {
        return response()->json(['status' => true, 'data' => $menu]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}


	// it will show only recipes which has lowest price
	// like if there is one recipes with 2 entries 1 with half and 1 with full varient then it shows only
	//that recipe details which has lowest price that means which has varient half...
	public function getMenu(Request $request)
{
    $restaurantId = $request->input('restaurant_id');
 //   $tableId = $request->input('table_id');

    if (!$restaurantId) {
        return response()->json(['status' => false, 'message' => 'Restaurant ID not provided']);
    }

    // Retrieve the table number based on the provided table ID
  //  $tableNumber = Table::where('id', $tableId)->value('table');

   // if (!$tableNumber) {
    //    return response()->json(['status' => false, 'message' => 'Table not found']);
 //   }

    // Subquery to select the recipes with the minimum and maximum prices for each name within the requested restaurant
    $subquery = DB::table('recipe')
                ->select('recipe', DB::raw('MIN(price) as min_price'), DB::raw('MAX(price) as max_price'))
                ->where('restaurant_id', $restaurantId)
                ->groupBy('recipe');

    // Retrieve menu data based on the provided conditions and the comparison of prices
    $menu = Menu::leftJoin('restro', 'restro.id', '=', 'recipe.restaurant_id')
        ->leftJoin('category', 'category.id', '=', 'recipe.category_id')
        ->joinSub($subquery, 'sub', function ($join) {
            $join->on('recipe.recipe', '=', 'sub.recipe');
            $join->on('recipe.price', '=', 'sub.min_price');
        })
        ->where('recipe.restaurant_id', $restaurantId) // Filter by requested restaurant_id
     //   ->where('recipe.type', 'Dine In') // Filter by type "Dine In"
	//	->orWhere('recipe.type', 'Dine In,Delivery') // Filter by type "Dine In"

        ->orderBy('recipe.recipe') // Optionally, order by recipe name
        ->orderBy('recipe.price') // Optionally, order by price
        ->select('recipe.*', 'restro.address', 'restro.restaurant', 'category.category')
        ->get();

    if ($menu->isNotEmpty()) {
        //return response()->json(['status' => true, 'table_number' => $tableNumber, 'data' => $menu]);
    return response()->json(['status' => true, 'data' => $menu]);
	} else {
        return response()->json(['status' => false, 'message' => 'Menu not found']);
    }
}


public function get_search_restro(Request $request)
{
    $get_restro = Restro::
        // where('city_id', $request->city_id)
        where('restaurant', 'like', '%' . $request->restaurant . '%')
			->where('city', $request->city_id)

        ->orderByRaw("CASE WHEN restaurant LIKE '{$request->restaurant}%' THEN 0 ELSE 1 END")
        ->orderBy('restaurant')
        ->get();

    if ($get_restro->isNotEmpty()) {
        return response()->json(['status' => true, 'data' => $get_restro]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}


// search menu against recipe alphabetically

public function get_search_menu(Request $request)
{
    $menu = Menu::
    // where('restaurant', 'like', '%' . $request->restaurant . '%')
    where('recipe', 'like', '%' . $request->recipe . '%')
    // where('category_id', $request->category_id)
    ->orderByRaw("CASE WHEN recipe LIKE '{$request->recipe}%' THEN 0 ELSE 1 END")
    ->orderBy('recipe')


    // join is used to show category name without this it will only show category id.
    ->join('restro','restro.id','=','recipe.restaurant_id')
    ->leftjoin('category','category.id','=','recipe.category_id')
    ->select('recipe.*','category.category', 'restro.restaurant')
    ->get();
    if($menu)
    {
        return response()->json(['status'=>true,'data'=>$menu]);
    }else{
        return response()->json(['status'=>false,'message'=>'data not found']);
    }
}


public function restro_login(Request $request)
{
    $user = Restro::where('email', $request->email)->first();
    if ($user && Hash::check($request->password, $user->password)) {
        return response()->json(['status' => true,  'message' => 'User Login Successfully', 'user' => $user,]);
    } else {
        return response()->json(['status' => false, 'message' => 'User Not Found']);
    }
}

public function getRestroOrder(Request $request)
{
    $restaurantId = $request->input('restro_id');

    if (!$restaurantId) {
        return response()->json(['status' => false, 'message' => 'Restaurant ID not provided']);
    }

    $restro_order = Order::leftJoin('cart', 'cart.order_id', '=', 'order.id')
    ->leftjoin('users','users.id','=','order.user_id')
        ->where('order.restro_id', $restaurantId) // Filter by restaurant_id
		->where('order.type', 'Delivery') // Filter by null type
        ->select('order.id','order.user_id','order.coupon_code', 'order.cooking_instruction', 'order.discount', 'order.address as order_address', 'order.total as grand_total', 'order.restro_status', 'order.order_id2',   'order.created_at', 'order.updated_at', 'cart.recipe_name', 'cart.recipe_price', 'cart.quantity', 'cart.varient', 'users.name', 'users.contact')
		 ->orderBy('order.id','desc') // Optional: Order the results by order ID
        // 'restro.address', 'restro.restaurant', 'category.category')
        ->get();


// Group the results by order ID
$groupedOrders = $restro_order->groupBy('id');
// Transform the grouped results
$item_list_against_userid = $groupedOrders->map(function ($orders) {
	 $firstOrder = $orders->first();

	$createdAt = optional($firstOrder->updated_at);
        $currentTime = Carbon::now();

	  // Check if the restro_status should be updated to 'Rejected'
      //  if ($createdAt->diffInMinutes($currentTime) > 1 && $firstOrder->restro_status == 'In Progress') {
      //      $firstOrder->restro_status = 'Rejected';
		    if ($createdAt && $createdAt->diffInSeconds($currentTime) > 59 && $firstOrder->restro_status == 'In Progress') {
        $firstOrder->restro_status = 'Rejected';

			Order::where('id', $firstOrder->id)->update(['restro_status'=>'Rejected', 'status'=>'Restaurant is busy at the moment, try again']);
        }
    return [
        'id' => $orders->first()->id,
        'user_id' => $orders->first()->user_id,
		'coupon_code' => $firstOrder->coupon_code,
		'cooking_instruction'=>$firstOrder->cooking_instruction,
		'discount' => $firstOrder->discount,
        'grand_total' => $orders->first()->grand_total,
        'order_date' => optional($firstOrder->created_at)->format('Y-m-d H:i:s'), // Use optional to handle null values
		//'order_date' => $orders->first()->created_at->format('Y-m-d H:i:s'),
        'status' => $orders->first()->restro_status,
        'order_id2'=> $orders->first()->order_id2,
        'name' => $orders->first()->name,
        'contact' => $orders->first()->contact,
		'order_address'=> $orders->first()->order_address,

        // 'address'=> $orders->first()->address,

        'cards' => $orders->map(function ($card) {
		static $index = 0; // Initialize the index
        $index++; // Increment the index for each card

            return [
				'index' => $index, // Add 1 to start index from 1
                'recipe_name' => $card->recipe_name,
                'quantity' => $card->quantity,
				'recipe_price'=>$card->recipe_price,
				'varient'=>$card->varient,
                // 'recipe_price' => $card->recipe_price,
            ];
        })->toArray(),
    ];

})->values()->all();
// dd($get_allorder_by_user_id);
if (!empty($item_list_against_userid)) {
    return response()->json(['status' => true, 'data' => $item_list_against_userid]);
} else {
    return response()->json(['status' => false, 'message' => 'Data not found']);
}
}

	//-----------------------------------------------------



	public function restro_order_again(Request $request)
{
    $orderId = $request->input('order_id');

    Order::where('id', $orderId)
         ->where('restro_status', 'Rejected')
         ->update(['restro_status' => 'In Progress', 'status' => 'Your order is Pending']);
        return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);

}


public function getRestroOrder2(Request $request)
{
    $restaurantId = $request->input('restro_id');

    if (!$restaurantId) {
        return response()->json(['status' => false, 'message' => 'Restaurant ID not provided']);
    }

    $order = Order::leftJoin('cart', 'cart.order_id', '=', 'order.id')
    ->leftjoin('users','users.id','=','order.user_id')
        ->where('order.restro_id', $restaurantId) // Filter by restaurant_id
        ->select('order.id','order.user_id', 'order.total as grand_total', 'order.order_date','order.status','order.order_id2', 'cart.recipe_name', 'cart.recipe_price', 'cart.quantity', 'users.name')
        // 'restro.address', 'restro.restaurant', 'category.category')
        ->get();

    if ($order->isNotEmpty()) {
        return response()->json(['status' => true, 'data' => $order]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}

	//-------------------------------------------




public function getRestroInfo(Request $request)
{

    $restroID= $request->input('id');
    $restro= Restro::where('id', $restroID)->get();

if($restro->isEmpty()){
    return response()->json(['status'=>false, 'message'=>'data not found']);
}
else{
    return response()->json(['status' => true, 'message' => 'All data retrieved successfully', 'data' => $restro], 200);

}}


//to accept order

public function accept_order(Request $request)
            {
                $accept_order = Order::where('order_id2', $request->order_id)->first();
                if ($accept_order->id) {
                    $accept_order->update([
                       // 'status'=>$request->status,
						'restro_status'=>'Searching Delivery Boy',
						 'status'=>'In Progress',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }

//to cancel order

            public function cancel_order(Request $request){
                $cancel_order = Order::where('order_id2', $request->order_id)->first();
                if ($cancel_order->id) {
                    $cancel_order->update([
                       // 'status'=>$request->status,
                         'restro_status'=>'Order Cancelled',
                        'status'=>'Your Order is Cancelled',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }

  public function delivery_address(Request $request)
{


    // Create a new DeliveryAddress instance
    $address = DeliveryAddress::create([
        'user_id' => $request->input('user_id'),
        'address_type' => $request->input('address_type'),
        'contact_number' => $request->input('contact_number'),
        'full_name' => $request->input('full_name'),
        'landmark' => $request->input('landmark'),
        'house_number' => $request->input('house_number'),
        'address' => $request->input('address'),
    ]);

    // Check if the creation was successful
    if ($address) {
        return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Something Error Occurred At Server']);
    }
}





// get delivery address against user id
public function get_delivery_address(Request $request)
{
    $delivey_address = DeliveryAddress::where('user_id', $request->user_id)
        ->get();
        if($delivey_address)
        {
            return response()->json(['status'=>true,'data'=>$delivey_address]);
        }else{
            return response()->json(['status'=>false,'message'=>'data not found']);
        }
}

// get delivery Address against delivery id


public function get_delivery_address_by_id(Request $request)
{
    $delivey_address = DeliveryAddress::where('id', $request->id)
        ->get();
        if($delivey_address)
        {
            return response()->json(['status'=>true,'data'=>$delivey_address]);
        }else{
            return response()->json(['status'=>false,'message'=>'data not found']);
        }
}


public function delete_delivery_address(Request $request)
{
    // Validate the user_id
    $request->validate([
        'id' => 'required|integer',
    ]);

    // Attempt to delete delivery addresses for the specified user_id
    $deletedCount = DeliveryAddress::where('id', $request->id)->delete();

    if ($deletedCount > 0) {
        return response()->json(['status' => true, 'message' => 'Delivery addresses deleted successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'No delivery addresses found for the user']);
    }
}

	public function update_delivery_address(Request $request)
{
		   // Find the existing delivery address for the user_id
    $address = DeliveryAddress::where('id', $request->input('id'))->first();

    if ($address) {
        // Update the existing address
        $address->update([
            'address_type' => $request->input('address_type'),
            'contact_number' => $request->input('contact_number'),
            'full_name' => $request->input('full_name'),
            'landmark' => $request->input('landmark'),
            'house_number' => $request->input('house_number'),
            'address' => $request->input('address'),
        ]);

        return response()->json(['status' => true, 'message' => 'Address updated successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Address not found for the user']);
    }
}
//Delivery Boy API


// Delivery Boy Registration
    public function delivery_registration(Request $request)
    {
        $insert = User::create([


            'name' => $request->name,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'address' =>$request->address,
            'email' =>$request->email,
            'role'=>'delivery',
        ]);

        if ($insert) {
            return response()->json(['status' => true, 'message' => 'Data Submitted Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something error occurred']);
        }
    }

// Delivery Boy Login
   public function delivery_check(Request $request)
{
    $user = User::where('contact', $request->contact)->first();
    if ($user && Hash::check($request->password, $user->password)) {
        return response()->json(['status' => true,  'message' => 'User Login Successfully', 'user' => $user,]);
    } else {
        return response()->json(['status' => false, 'message' => 'User Not Found']);
    }
}

//check delivery info
    public function get_delivery_boy_info(Request $request)
    {
        $get_delivery_boy_info = User::find($request->id);
        if ($get_delivery_boy_info) {
            return response()->json(['status' => true, 'data' => $get_delivery_boy_info]);
        } else {
            return response()->json(['status' => false, 'message' => 'User not found']);
        }
    }



// Update Delivery Boy info

//updated api dont need to pass id
public function updateDeliveryBoy(Request $request)
    {
        $updateDeliveryBoy = DeliveryBoy::where('id', $request->id)->orderby('id', 'desc')->first();
        if ($updateDeliveryBoy) {
            $updateDeliveryBoy->update([
                'first_name' => $request->first_name,
				'last_name' => $request->last_name,
                'primary_contact' => $request->primary_contact,
                'secondary_contact' => $request->secondary_contact,
                'email' => $request->email,
                'address' => $request->address,
            ]);
        }
        if ($updateDeliveryBoy->id) {
            return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
        }
    }



    // update delivery boy lat long

    public function update_delivery_location(Request $request)
{
    // Find the delivery boy record by ID
 //   $deliveryBoy = DeliveryBoy::find($request->delivery_boy_id);
$deliveryBoy = DeliveryBoy::where('user_id', $request->id)->first();

    if (!$deliveryBoy) {
        return response()->json(['status' => false, 'message' => 'Delivery boy not found'], 404);
    }

    // Update latitude and longitude fields
    $deliveryBoy->latitude = $request->latitude;
    $deliveryBoy->longitude = $request->longitude;
    $deliveryBoy->save();

    return response()->json(['status' => true, 'message' => 'Location Updated Successfully']);
}


public function get_delivery_location(Request $request){

	 $order_id = $request->input('order_id');
	 $location = Order:: where('order.id', $order_id)
	 ->leftjoin('delivery_boy', 'delivery_boy.user_id', '=', 'order.delivery_boy_id')
		 ->select('delivery_boy.latitude', 'delivery_boy.longitude', 'delivery_boy.first_name', 'delivery_boy.last_name', 'delivery_boy.primary_contact')
		 ->get();
	return response()->json(['status'=>true, 'data'=>$location]);
}



// show records to delivery boy only if status of order is 'In Progress'

public function get_order_status2(Request $request)
{
    try {
        $status = Order::where('status', 'In Progress')->get	();

        if ($status->isNotEmpty()) {
            return response()->json(['status' => true, 'data' => $status]);
        } else {
            return response()->json(['status' => false, 'message' => 'No orders in progress']);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'Something went wrong at the server']);
    }
}


public function get_order_status_without(Request $request)
{
    $orders = Order::with(['carts' => function ($query) {
        $query->select('order_id', 'recipe_name', 'recipe_price', 'quantity');
    }])
        ->where('status', 'In Progress')
        ->get();

    if ($orders->isNotEmpty()) {
        $item_list_against_userid = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'order_id2' => $order->order_id2,
                'order_date' => $order->order_date,
                'total' => $order->total,
                'payment_mode' => $order->payment_mode,
                'delivery_type' => $order->delivery_type,
                'delivery_charges' => $order->delivery_charges,
                'coupon_code' => $order->coupon_code,
                //'item' => $order->carts->pluck('recipe_name')->unique()->toArray(),
                'pickup_address' => $order->address,
                'user_name' => $order->full_name,
                'contact_number' => $order->contact_number,
                'landmark' => $order->landmark,
                'house_number' => $order->house_number,
                'address' => $order->address,
                'cards' => $order->carts->toArray(),
            ];
        });

        return response()->json(['status' => true, 'data' => $item_list_against_userid]);
    } else {
        return response()->json(['status' => false, 'message' => 'No orders in progress']);
    }
}

public function get_delivery_order(Request $request)
{
    // Retrieve orders with related carts, delivery address, and restro
    $orders = Order::with(['carts', 'deliveryAddress', 'restro'])
       // ->where('status', 'In Progress')
		 ->where('restro_status', 'Searching Delivery Boy')
		 ->orwhere('restro_status', 'Order Accepted')
		->orwhere('delivery_status', 'Order Cooking')
		->orwhere('delivery_status', 'Ready for Pickup')
		->orwhere('delivery_status', 'Ready for Delivery')
        ->orwhere('delivery_status', 'Order Delivered')
        ->get();

    if ($orders->isNotEmpty()) {
        // Transform the results
        $item_list_against_userid = $orders->map(function ($order) {

			 // Retrieve dstype from coupon based on coupon_code
            $dstype = null;
			$coupon_value = null;
            if ($order->coupon_code) {
                $coupon = Coupon::where('code', $order->coupon_code)->first();
                if ($coupon) {
                    $dstype = $coupon->dstype;
					$coupon_value = $coupon->value;
                }
            }
            return [
                'id' => $order->id,
                'order_id2' => $order->order_id2,
				'order_date' => $order->created_at->format('Y-m-d H:i:s'),
                'total' => $order->total,
                'payment_mode' => $order->payment_mode,
                'delivery_type' => $order->delivery_type,
                'delivery_charges' => $order->delivery_charges,
                'coupon_code' => $order->coupon_code,
				'dstype' => $dstype,
				'coupon_code_value'=>$coupon_value,
				'status' => $order->delivery_status,
				'contact_number'=>$order->contact_number,
                'item' => $order->carts->map(function ($cart) {
					static $index = 0; // Initialize the index
       				 $index++; // Increment the index for each card
                    return [
						'index' => $index, // Add 1 to start index from 1
                        'recipe_name' => $cart->recipe_name,
                        'quantity' => $cart->quantity,
                        'recipe_price' => $cart->recipe_price,
						'varient'=>$cart->varient,

                    ];
                })->toArray(),
                'pickup_address' => $order->restro->address,
				'restro_contact_no'=>$order->restro->mobilenumber,
				'restro_name' =>$order->restro->restaurant,

                'delivery_address' => [
                    'address_type' => $order->deliveryAddress->address_type,
                   // 'contact_number' => $order->deliveryAddress->contact_number,
                    'full_name' => $order->deliveryAddress->full_name,
                    'landmark' => $order->deliveryAddress->landmark,
                    'house_number' => $order->deliveryAddress->house_number,
                    'address' => $order->deliveryAddress->address,
                ],
            ];
        });

//---------------------------------------
  // Update the status of orders to 'Pending Delivery Boy'
  //$orderIds = $orders->pluck('id');
  //Order::whereIn('id', $orderIds)->update(['restro_status' => 'Pending Delivery Boy']);

//---------------------------------------


        return response()->json(['status' => true, 'data' => $item_list_against_userid]);
    } else {
        return response()->json(['status' => false, 'message' => 'No orders in progress']);
    }
}


// Accept order by delivery boy
public function delivery_accept_order(Request $request)
            {
	                $delivery_boy_id = $request->input('delivery_boy_id');
                $accept_delivery_order = Order::where('order_id2', $request->order_id)->first();
                if ($accept_delivery_order->id) {
                    $accept_delivery_order->update([
                       // 'status'=>$request->status,
						'restro_status'=>'Order Accepted',
						 'status' =>'Order Accepted',
						'delivery_status'=>'In Progress',
						'delivery_boy_id' =>$delivery_boy_id,
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }


//to cancel order

            public function delivery_cancel_order(Request $request){
                $cancel_order = Order::where('order_id2', $request->order_id)->first();
                if ($cancel_order->id) {
                    $cancel_order->update([
                       // 'status'=>$request->status,
                        'restro_status'=>'Searching Delivery Boy',
						'status'=>'Your Order is Pending',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }


//to Pickup order

public function pickup_delivery_order(Request $request){
    $cancel_order = Order::where('order_id2', $request->order_id)->first();
    if ($cancel_order->id) {
        $cancel_order->update([
           // 'status'=>$request->status,
            'restro_status'=>'Food is On the Way',
            'status'=>'Food is On the Way',
			'delivery_status'=>'Ready for Delivery',
			'kitchen_status'=>'Order is Pickup',
        ]);
        return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
    }
}




//to Deliver order

public function delivered_delivery_order(Request $request){
    $cancel_order = Order::where('order_id2', $request->order_id)->first();
    if ($cancel_order->id) {
        $cancel_order->update([
           // 'status'=>$request->status,
            'restro_status'=>'Order Delivered',
            'status'=>'Order Delivered',
			'kitchen_status'=>'Order Delivered',
        ]);
        return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
    }
}




// Delivery OTP

//To generate 4 digit random otp // store otp into database and to send it get_order_history, just update otp

   public function send_delivery_otp(Request $request)
    {
        // Generate a random 4-digit number
        $otp = mt_rand(1000, 9999);

        // Update the order with the generated OTP
        Order::where('order_id2', $request->order_id2)->update(['otp' => $otp]);

        return response()->json(['status' => true, 'message' => 'OTP generated and saved successfully', 'otp' => $otp]);
    }

//To varify otp
public function verify_delivery_otp(Request $request)
{
    $order = DB::table('order')->where('order_id2', $request->order_id2)->first();

    if (!$order) {
        return response()->json(['status' => false, 'message' => 'Order not found']);
    }

    $contact = $order->contact_number; // Adjust this based on your order table structure

    // Assuming $request->otp contains the submitted OTP
    if ($request->otp == $order->otp) {
        // OTP is valid
		 // Update the delivery_status in the order table
         DB::table('order')->where('order_id2', $request->order_id2)->update(['status'=> 'Order Delivered',
		 'restro_status'=> 'Order Delivered','delivery_status' => 'Order Delivered', 'kitchen_status'=> 'Order Delivered' ]);

        // For demonstration purposes, let's return a success response
        return response()->json(['status' => true, 'message' => 'OTP verified successfully']);
    } else {
        // Invalid OTP
        return response()->json(['status' => false, 'message' => 'Invalid OTP']);
    }
}



// Update Delivery Address of User

//updated api dont need to pass id

public function updateDeliveryAddress(Request $request)
    {
        $updateDeliveryAddress = DeliveryAddress::where('id', $request->id)->orderby('id', 'desc')->first();
        if ($updateDeliveryAddress) {
            $updateDeliveryAddress->update([
                'address_type' => $request->address_type,
				'contact_number' => $request->contact_number,
                'full_name' => $request->full_name,
                'landmark' => $request->landmark,
                'house_number' => $request->house_number,
                'address' => $request->address,
            ]);
        }
        if ($updateDeliveryAddress->id) {
            return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
        }
    }


// API FOR KITCHEN




public function kitchen_registration(Request $request)
{
    $insert = User::create([


        'name' => $request->name,
        'password' => Hash::make($request->password),
        'contact' => $request->contact,
        // 'address' =>$request->address,
        'email' =>$request->email,
        'restro_id'=>$request->restro_id,
        'role'=>'kitchen',
    ]);

    if ($insert) {
        return response()->json(['status' => true, 'message' => 'Data Submitted Successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Something error occurred']);
    }
}


public function get_all_restro_kitchen(Request $request)
{
    try {
        // Fetch all restaurant names from the "restaurant" field in the "restro" table
        $restaurantNames = Restro::pluck('restaurant');

        // You can return the names as a JSON response
        return response()->json(['restaurant_names' => $restaurantNames], 200);
    } catch (\Exception $e) {
        // Handle any exceptions that may occur during the database query
        return response()->json(['error' => 'Unable to fetch restaurant names.'], 500);
    }

}


public function kitchen_check(Request $request)
{
    $user = User::where('contact', $request->contact)->first();
    if ($user && Hash::check($request->password, $user->password)) {
        return response()->json(['status' => true,  'message' => 'User Login Successfully', 'user' => $user,]);
    } else {
        return response()->json(['status' => false, 'message' => 'User Not Found']);
    }
}




// get kitchen info
public function get_kitchen_info(Request $request)
{
    $get_kitchen_info = User::find($request->id);
    if ($get_kitchen_info) {
        return response()->json(['status' => true, 'data' => $get_kitchen_info]);
    } else {
        return response()->json(['status' => false, 'message' => 'User not found']);
    }
}



// Update Kitchen Registration info

//updated api dont need to pass id
public function updateKitchen(Request $request)
    {
        $updateKitchen = Kitchen::where('id', $request->id)->orderby('id', 'desc')->first();
        if ($updateKitchen) {
            $updateKitchen->update([
                'name' => $request->name,
				'contact' => $request->contact,
                'email' => $request->email,
                ]);
        }
        if ($updateKitchen->id) {
            return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
        }
    }


	// show records to kitchen only if status of order is 'Order Accepted'

		public function get_kitchen_order(Request $request)
		{
			// Retrieve orders with related carts, delivery address, and restro
			$orders = Order::with(['carts', 'deliveryAddress', 'restro'])
			   // ->where('status', 'In Progress')
				// ->where('restro_status', 'Order Accepted')
				// ->orwhere('restro_status', 'Order Cooking')
				->where('delivery_status', 'In Progress')
				->orwhere('delivery_status', 'Order Cooking')
				->orwhere('delivery_status', 'Ready for Pickup')
				->orwhere('delivery_status', 'Order is Pickup')
				->orwhere('delivery_status', 'Order Delivered')
				->orwhere('delivery_status', 'Ready for Delivery')
        ->orderBy('created_at', 'desc')
				->get();

			if ($orders->isNotEmpty()) {
				// Transform the results
				$item_list_against_userid = $orders->map(function ($order) {
					return [
						'id' => $order->id,
						'order_id2' => $order->order_id2,
 						 'order_date' => $order->created_at->format('Y-m-d H:i:s'),
						'type' => $order-> type,
						'total' => $order->total,
						'payment_mode' => $order->payment_mode,
						'delivery_type' => $order->delivery_type,
						'delivery_charges' => $order->delivery_charges,
						'coupon_code' => $order->coupon_code,
						'status' => $order->delivery_status,
						'item' => $order->carts->map(function ($cart) {
							static $index = 0; // Initialize the index
						 $index++; // Increment the index for each card
							return [
								'index' => $index, // Add 1 to start index from 1
								'recipe_name' => $cart->recipe_name,
								'quantity' => $cart->quantity,
								'recipe_price' => $cart->recipe_price,
								'varient'=>$cart->varient,

							];
						})->toArray(),
						'pickup_address' => $order->restro->address, // Use the restro address as pickup address
						// 'user_name' => $order->full_name,
						// 'contact_number' => $order->contact_number,
						// 'landmark' => $order->landmark,
						// 'house_number' => $order->house_number,
						// 'address' => $order->address,
						'delivery_address' => [
							'address_type' => $order->deliveryAddress->address_type,
							'contact_number' => $order->deliveryAddress->contact_number,
							'full_name' => $order->deliveryAddress->full_name,
							'landmark' => $order->deliveryAddress->landmark,
							'house_number' => $order->deliveryAddress->house_number,
							'address' => $order->deliveryAddress->address,
						],
					];
				});

		//---------------------------------------
		  // Update the status of orders to 'Pending Delivery Boy'
		  //$orderIds = $orders->pluck('id');
		  //Order::whereIn('id', $orderIds)->update(['restro_status' => 'Pending Delivery Boy']);

		//---------------------------------------


				return response()->json(['status' => true, 'data' => $item_list_against_userid]);
			} else {
				return response()->json(['status' => false, 'message' => 'No orders in progress']);
			}
		}




// Accept order by Kitchen
public function kitchen_accept_order(Request $request)
            {
                $accept_kitchen_order = Order::where('order_id2', $request->order_id)->first();
                if ($accept_kitchen_order->id) {
                    $accept_kitchen_order->update([
                       // 'status'=>$request->status,
						'restro_status'=>'Order Cooking',
						 'status' =>'Order Cooking',
                         'delivery_status'=>'Order Cooking',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }


//to cancel order

            public function kitchen_cancel_order(Request $request){
                $cancel_order = Order::where('order_id2', $request->order_id)->first();
                if ($cancel_order->id) {
                    $cancel_order->update([
                       // 'status'=>$request->status,
                        'restro_status'=>'Searching Delivery Boy',
						'status'=>'Your Order is Pending',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }


// Complete order by Kitchen
public function kitchen_order_completed(Request $request)
{
    $complete_kitchen_order = Order::where('order_id2', $request->order_id)->first();
    if ($complete_kitchen_order->id) {
        $complete_kitchen_order->update([
           // 'status'=>$request->status,
            'restro_status'=>'Ready for Pickup',
             'delivery_status'=>'Ready for Pickup',
			'kitchen_status'=>'Ready for Pickup',
        ]);
        return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
    }
}


// API Key

public function api_key(Request $request)
{
    $apiKey = env('API_KEY');
    return response()->json(['status'=>true,'data'=>$apiKey]);

}

// Waiter



 public function waiter_registration(Request $request)
    {
        $insert = User::create([

            //'name' => $request->name,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,

            'role'=>'waiter',
        ]);

        if ($insert) {
            return response()->json(['status' => true, 'message' => 'Data Submitted Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something error occurred']);
        }
 }



// Delivery Boy Login

public function waiter_check(Request $request)
{
    $user = User::where('contact', $request->contact)->first();
    if ($user && Hash::check($request->password, $user->password)) {
        return response()->json(['status' => true,  'message' => 'User Login Successfully', 'user' => $user,]);
    } else {
        return response()->json(['status' => false, 'message' => 'User Not Found']);
    }
}




// Update Kitchen Registration info

//updated api dont need to pass id
public function updateWaiter(Request $request)
    {
        $updateWaiter = Waiter::where('id', $request->id)->orderby('id', 'desc')->first();
        if ($updateWaiter) {
            $updateWaiter->update([
                'name' => $request->first_name,
				'contact' => $request->contact,
                'email' => $request->email,
                ]);
        }
        if ($updateWaiter->id) {
            return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
        }
    }


// To View Waiter Ifo

public function waiter_info(Request $request)
{
    $waiter = User::find($request->id);

    if ($waiter) {
        return response()->json(['status' => true, 'message' => 'Waiter data retrieved successfully', 'data' => $waiter], 200);
    } else {
        return response()->json(['status' => false, 'message' => 'Waiter not found'], 404);
    }

}

// Dine In Flow

	// it will show only recipes which has lowest price
	// like if there is one recipes with 2 entries 1 with half and 1 with full varient then it shows only
	//that recipe details which has lowest price that means which has varient half...
	public function dine_in_menu(Request $request)
{
    $restaurantId = $request->input('restaurant_id');
 //   $tableId = $request->input('table_id');

    if (!$restaurantId) {
        return response()->json(['status' => false, 'message' => 'Restaurant ID not provided']);
    }

    // Retrieve the table number based on the provided table ID
  //  $tableNumber = Table::where('id', $tableId)->value('table');

   // if (!$tableNumber) {
    //    return response()->json(['status' => false, 'message' => 'Table not found']);
 //   }

    // Subquery to select the recipes with the minimum and maximum prices for each name within the requested restaurant
    $subquery = DB::table('recipe')
                ->select('recipe', DB::raw('MIN(price) as min_price'), DB::raw('MAX(price) as max_price'))
                ->where('restaurant_id', $restaurantId)
                ->groupBy('recipe');

    // Retrieve menu data based on the provided conditions and the comparison of prices
    $menu = Menu::leftJoin('restro', 'restro.id', '=', 'recipe.restaurant_id')
        ->leftJoin('category', 'category.id', '=', 'recipe.category_id')
        ->joinSub($subquery, 'sub', function ($join) {
            $join->on('recipe.recipe', '=', 'sub.recipe');
            $join->on('recipe.price', '=', 'sub.min_price');
        })
        ->where('recipe.restaurant_id', $restaurantId) // Filter by requested restaurant_id
        ->where('recipe.type', 'Dine In') // Filter by type "Dine In"
		->orWhere('recipe.type', 'Dine In,Delivery') // Filter by type "Dine In"

        ->orderBy('recipe.recipe') // Optionally, order by recipe name
        ->orderBy('recipe.price') // Optionally, order by price
        ->select('recipe.*', 'restro.address', 'restro.restaurant', 'category.category')
        ->get();

    if ($menu->isNotEmpty()) {
        //return response()->json(['status' => true, 'table_number' => $tableNumber, 'data' => $menu]);
    return response()->json(['status' => true, 'data' => $menu]);
	} else {
        return response()->json(['status' => false, 'message' => 'Menu not found']);
    }
}


public function get_varients_old(Request $request){
    $recipeId = $request->input('recipe_id');

    if (!$recipeId) {
        return response()->json(['status' => false, 'message' => 'Recipe ID not provided']);
    }

    // Retrieve the restaurant ID associated with the provided recipe ID
    $restaurantId = Recipe::where('id', $recipeId)->value('restaurant_id');

    if (!$restaurantId) {
        return response()->json(['status' => false, 'message' => 'Restaurant ID not found for the provided Recipe ID']);
    }

    // Retrieve all recipe details matching the recipe name and restaurant ID of the requested recipe ID
    $recipes = Recipe::where('recipe', function ($query) use ($recipeId) {
            $query->select('recipe')
                ->from('recipe')
                ->where('id', $recipeId);
        })
        ->where('restaurant_id', $restaurantId)
        ->get();

    if ($recipes->isNotEmpty()) {
        return response()->json(['status' => true, 'data' => $recipes]);
    } else {
        return response()->json(['status' => false, 'message' => 'Recipes not found matching the requested criteria']);
    }
}

public function get_varients(Request $request){
    $recipeId = $request->input('recipe_id');

    if (!$recipeId) {
        return response()->json(['status' => false, 'message' => 'Recipe ID not provided']);
    }

    // Retrieve the restaurant ID associated with the provided recipe ID
    $restaurantId = Recipe::where('id', $recipeId)->value('restaurant_id');

    if (!$restaurantId) {
        return response()->json(['status' => false, 'message' => 'Restaurant ID not found for the provided Recipe ID']);
    }

    // Retrieve all recipe details matching the recipe name and restaurant ID of the requested recipe ID
    $recipes = Recipe::select('id', 'recipe', 'price', 'varient')
        ->where('recipe', function ($query) use ($recipeId) {
            $query->select('recipe')
                ->from('recipe')
                ->where('id', $recipeId);
        })
        ->where('restaurant_id', $restaurantId)
        ->get();

    if ($recipes->isNotEmpty()) {
        return response()->json(['status' => true, 'data' => $recipes]);
    } else {
        return response()->json(['status' => false, 'message' => 'Recipes not found matching the requested criteria']);
    }
}


public function dine_in_post_order(Request $request){

	//dd($request->all());
    $insert = Order::create([
        'user_id'=> $request->user_id,
		'waiter_id'=>$request->waiter_id,
		'order_id2' => 'OD'.time(),
        'restro_id' => $request->restro_id,
        'table_id' => $request->table_id,
        'total' => $request->total,

       // 'delivery_type'=>$request->delivery_type,
       'contact_number'=>$request->contact,
        'order_date'=>$request->order_date,
        'status'=> "Send to Waiter", //Just massage to show
        //'waiter_status'=>"Searching for Waiter",
        'type'=>"Dine In",
        'verify' => 1
    ]);

$insert->user_id = $request->user_id;
$insert->save();

    $cart_update = Cart :: where('user_id',$request->user_id)
    ->where('order_id',null)
    ->update([
        'order_id'=>$insert->id,
    ]);

    if($insert) {
        return response()->json(['status' => true, 'message' => 'data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
    }


public function get_dine_in_order(Request $request)
{
    $get_allorder_by_user_id = DB::table('order')
        ->leftjoin('cart', 'cart.order_id', '=', 'order.id')
        ->leftjoin('restro', 'restro.id', '=', 'order.restro_id')
        ->where('order.user_id', $request->user_id)
        ->where('order.type', 'Dine In') // Filter orders with type "Delivery In"
        ->where(function($query) {
            $query->where('waiter_status', 'Searching for Waiter')
                  ->orWhere('waiter_status', 'Send to Waiter')
                  ->orWhere('waiter_status', 'In Progress')
                  ->orWhere('waiter_status', 'Send to Kitchen')
                  ->orWhere('waiter_status', 'Order is Cooking')
                  ->orWhere('waiter_status', 'Food is Ready')
                  ->orWhere('waiter_status', 'Order Completed')
				  ->orWhere('waiter_status', 'Waiting for Kitchen')
				  ->orWhere('order.waiter_status', 'Food is on the Table');

        })
        ->select('order.id','order.address as order_address', 'order.otp', 'order.total as grand_total','order.created_at',      'order.order_date','order.status','order.table_id','order.type','order.restro_id','order.order_id2', 'restro.restaurant',
        'restro.address as restro_address', 'cart.id as cart_id', 'cart.recipe_id', 'cart.recipe_price', 'cart.recipe_name','cart.quantity', 'cart.varient', 'cart.recipe_status')
        ->orderBy('order.id','desc') // Optional: Order the results by order ID
        ->get();

    // Group the results by order ID
    $groupedOrders = $get_allorder_by_user_id->groupBy('id');

    // Transform the grouped results
    $item_list_against_userid = $groupedOrders->map(function ($orders) {
        return [
            'id' => $orders->first()->id,
            'order_id2' => $orders->first()->order_id2,
            'grand_total' => $orders->first()->grand_total,
            'order_date' => $orders->first()->created_at,
            'otp'=>$orders->first()->otp,
            'type'=>$orders->first()->type,
            'recipe_price'=> $orders->first()->recipe_price,
            'restaurant' => $orders->first()->restaurant,
            'order_address'=> $orders->first()->order_address,
            'restro_address'=> $orders->first()->restro_address,
            'restro_id'=> $orders->first()->restro_id,
            'table_id'=> $orders->first()->table_id,
            'status' => $orders->first()->status,
            'cards' => $orders->map(function ($card) {
                static $index = 0; // Initialize the index
                $index++; // Increment the index for each card
                return [
                    'index' => $index, // Add 1 to start index from 1
					'cart_id' =>$card->cart_id,
					'recipe_id' => $card-> recipe_id,
                    'recipe_name' => $card->recipe_name,
                    'quantity' => $card->quantity,
                    'recipe_price'=>$card->recipe_price,
					'recipe_status'=>$card->recipe_status,
                    'varient'=>$card->varient,
                ];
            })->toArray(),
        ];
    })->values()->all();

    if (!empty($item_list_against_userid)) {
        return response()->json(['status' => true, 'data' => $item_list_against_userid]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}


//to get "Dine In" order and order added by waiter in that "Dine In" order and set recipe_status = "Recipe Updated"
// while getting data only that data whose recipe status of cart is not null



public function get_dine_in_waiter_order(Request $request)
{
 // Step 1: Get waiter_id from request
    $waiterId = $request->input('waiter_id');
$dd= User::where('id',$request->waiter_id)->first();
	//echo json_encode($dd);
	//$get_allorder_by_user_id = DB::table('order')
     //   ->leftjoin('cart', 'cart.order_id', '=', 'order.id')
    //    ->leftjoin('restro', 'restro.id', '=', 'order.restro_id')
     //   ->leftJoin('users', 'users.id', '=', 'order.user_id')
    //    ->where('order.restro_id',$dd->restro_id)
	//	->get();
	//echo json_encode($get_allorder_by_user_id);
	//exit();



    $get_allorder_by_user_id = DB::table('order')
        ->leftjoin('cart', 'cart.order_id', '=', 'order.id')
        ->leftjoin('restro', 'restro.id', '=', 'order.restro_id')
        ->leftJoin('users', 'users.id', '=', 'order.user_id')
   //->where('users.id', $waiterId) // Filter by waiter_id
    //    ->where('order.restro_id', $restroId) // Match restro_id with waiter's restro_id
             ->leftJoin('users as waiters', 'waiters.waiter_id', '=', 'order.user_id') // Join users table again for waiter's info

              ->where('order.restro_id',$dd->restro_id)

        ->where(function ($query) {
            $query->where('order.type', 'Dine In')
                ->where('order.waiter_status', 'Send to Waiter')
				->orWhere('order.waiter_status', 'Searching for Waiter')
				->orWhere('order.waiter_status', 'Send to Kitchen')
                ->orWhere('order.waiter_status', 'Waiting for Kitchen')
                ->orWhere('order.waiter_status', 'Order is Cooking')
                ->orWhere('order.waiter_status', 'Food is Ready')
                ->orWhere('order.waiter_status', 'Order Completed')
			    ->orWhere('order.waiter_status', 'Food is on the Table');

        })
 ->where(function ($query) {
            $query->where('cart.recipe_status', '<>', 'Recipe Updated') // Exclude cart items with "Recipe Updated"
                ->orWhereNull('cart.recipe_status');
        })
		->select(
            'order.id',
			'order.user_id',
            'order.address as order_address',
            'order.otp',
            'order.total as grand_total',
            'order.created_at',
            'order.order_date',
            'order.status',
            'order.order_id2',
            'order.restro_id',
            'order.table_id',
			'order.cooking_instruction',
            'restro.restaurant',
            'restro.address as restro_address',
            'cart.recipe_price',
            'cart.recipe_name',
            'cart.quantity',
            'cart.varient',
            'cart.recipe_status',
            'cart.id as cart_id',
            'cart.recipe_id',
            DB::raw("CASE WHEN users.role = 'waiter' THEN waiters.name ELSE users.name END AS user_name"), // Conditional selection for user_name
            DB::raw("CASE WHEN users.role = 'waiter' THEN waiters.contact ELSE users.contact END AS user_contact"), // Conditional selection for user_contact
            'order.waiter_status'
        )
        ->orderBy('order.id', 'desc')
        ->get();

    $groupedOrders = $get_allorder_by_user_id->groupBy('id');
//dd($groupedOrders);
    $item_list_against_userid = $groupedOrders->map(function ($orders) {
        return [
            'id' => $orders->first()->id,
			'user_id'=> $orders->first()->user_id,
            'order_id2' => $orders->first()->order_id2,
            'grand_total' => $orders->first()->grand_total,
            'order_date' => $orders->first()->created_at,
            'otp' => $orders->first()->otp,
            'recipe_price' => $orders->first()->recipe_price,
            'restaurant' => $orders->first()->restaurant,
            'order_address' => $orders->first()->order_address,
			'cooking_instruction' => $orders->first()->cooking_instruction,
            'restro_address' => $orders->first()->restro_address,
            'restro_id' => $orders->first()->restro_id,
            'table_id' => $orders->first()->table_id,
            'status' => $orders->first()->waiter_status,
            'user_name' => $orders->first()->user_name,
            'user_contact' => $orders->first()->user_contact,
            'cards' => $orders->map(function ($card) {
                static $index = 0;
                $index++;
                return [
                    'index' => $index,
                    'recipe_name' => $card->recipe_name,
                    'quantity' => $card->quantity,
                    'recipe_price' => $card->recipe_price,
                    'varient' => $card->varient,
                    'recipe_status' => $card->recipe_status,
                    'recipe_id' => $card->recipe_id,
                    'cart_id' => $card->cart_id,
                ];
            })->toArray(),
        ];
    })->values()->all();

    if (!empty($item_list_against_userid)) {
        return response()->json(['status' => true, 'data' => $item_list_against_userid]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}

public function get_dine_in_waiter_order222(Request $request)
{
   $get_allorder_by_user_id = DB::table('order')
        ->leftjoin('cart', 'cart.order_id', '=', 'order.id')
        ->leftjoin('restro', 'restro.id', '=', 'order.restro_id')
        ->leftJoin('users', 'users.id', '=', 'order.user_id')
        ->leftJoin('users as waiters', 'waiters.waiter_id', '=', 'order.user_id') // Join users table again for waiter's info
        ->where(function ($query) {
            $query->where('order.type', 'Dine In')
                ->where('order.waiter_status', 'Send to Waiter')
                ->orWhere('order.waiter_status', 'Waiting for Kitchen')
                ->orWhere('order.waiter_status', 'Order is Cooking')
                ->orWhere('order.waiter_status', 'Food is Ready')
                ->orWhere('order.waiter_status', 'Order Completed');
        })
        ->whereNotNull('cart.recipe_status')
        ->select(
            'order.id',
            'order.address as order_address',
            'order.otp',
            'order.total as grand_total',
            'order.created_at',
            'order.order_date',
            'order.status',
            'order.order_id2',
            'order.restro_id',
            'order.table_id',
            'restro.restaurant',
            'restro.address as restro_address',
            'cart.recipe_price',
            'cart.recipe_name',
            'cart.quantity',
            'cart.varient',
            'cart.recipe_status',
            'cart.id as cart_id',
            'cart.recipe_id',
            DB::raw("CASE WHEN users.role = 'waiter' THEN (SELECT name FROM users WHERE waiter_id = waiters.waiter_id ORDER BY created_at DESC LIMIT 1) ELSE users.name END AS user_name"), // Conditional selection for user_name
            DB::raw("CASE WHEN users.role = 'waiter' THEN (SELECT contact FROM users WHERE waiter_id = waiters.waiter_id ORDER BY created_at DESC LIMIT 1) ELSE users.contact END AS user_contact"), // Conditional selection for user_contact
            'order.waiter_status'
        )
        ->orderBy('order.id', 'desc')
        ->get();
    // Remaining code to group and format the orders...
 $groupedOrders = $get_allorder_by_user_id->groupBy('id');

    $item_list_against_userid = $groupedOrders->map(function ($orders) {
        return [
            'id' => $orders->first()->id,
            'order_id2' => $orders->first()->order_id2,
            'grand_total' => $orders->first()->grand_total,
            'order_date' => $orders->first()->created_at,
            'otp' => $orders->first()->otp,
            'recipe_price' => $orders->first()->recipe_price,
            'restaurant' => $orders->first()->restaurant,
            'order_address' => $orders->first()->order_address,
            'restro_address' => $orders->first()->restro_address,
            'restro_id' => $orders->first()->restro_id,
            'table_id' => $orders->first()->table_id,
            'status' => $orders->first()->waiter_status,
            'user_name' => $orders->first()->user_name,
            'user_contact' => $orders->first()->user_contact,
            'cards' => $orders->map(function ($card) {
                static $index = 0;
                $index++;
                return [
                    'index' => $index,
                    'recipe_name' => $card->recipe_name,
                    'quantity' => $card->quantity,
                    'recipe_price' => $card->recipe_price,
                    'varient' => $card->varient,
                    'recipe_status' => $card->recipe_status,
                    'recipe_id' => $card->recipe_id,
                    'cart_id' => $card->cart_id,
                ];
            })->toArray(),
        ];
    })->values()->all();

    if (!empty($item_list_against_userid)) {
        return response()->json(['status' => true, 'data' => $item_list_against_userid]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}


public function get_dine_in_waiter_order_card_works(Request $request)
{
    $get_allorder_by_user_id = DB::table('order')
        ->leftJoin('cart', 'cart.order_id', '=', 'order.id')
        ->leftJoin('restro', 'restro.id', '=', 'order.restro_id')
        ->leftJoin('users', 'users.id', '=', 'order.user_id')
        ->leftJoin('users as waiters', 'waiters.waiter_id', '=', 'order.user_id') // Join users table again for waiter's info
        ->where('order.type', 'Dine In')
        ->whereIn('order.waiter_status', ['Send to Waiter', 'Waiting for Kitchen', 'Order is Cooking', 'Food is Ready', 'Order Completed'])
        ->whereNotNull('cart.recipe_status')
        ->select(
            'order.id',
            'order.address as order_address',
            'order.otp',
            'order.total as grand_total',
            'order.created_at',
            'order.order_date',
            'order.status',
            'order.order_id2',
            'order.restro_id',
            'order.table_id',
            'restro.restaurant',
            'restro.address as restro_address',
            'cart.recipe_price',
            'cart.recipe_name',
            'cart.quantity',
            'cart.varient',
            'cart.recipe_status',
            'cart.id as cart_id',
            'cart.recipe_id',
            DB::raw("CASE WHEN users.role = 'waiter' THEN waiters.name ELSE users.name END AS user_name"), // Conditional selection for user_name
            DB::raw("CASE WHEN users.role = 'waiter' THEN waiters.contact ELSE users.contact END AS user_contact"), // Conditional selection for user_contact
            'order.waiter_status'
        )
        ->orderBy('order.id', 'desc')
        ->get();

    $groupedOrders = $get_allorder_by_user_id->groupBy('id');

    $item_list_against_userid = $groupedOrders->map(function ($orders) {
        $firstOrder = $orders->first();

        $formattedOrder = [
            'id' => $firstOrder->id,
            'order_id2' => $firstOrder->order_id2,
            'grand_total' => $firstOrder->grand_total,
            'order_date' => $firstOrder->created_at,
            'otp' => $firstOrder->otp,
            'restaurant' => $firstOrder->restaurant,
            'order_address' => $firstOrder->order_address,
            'restro_address' => $firstOrder->restro_address,
            'restro_id' => $firstOrder->restro_id,
            'table_id' => $firstOrder->table_id,
            'status' => $firstOrder->waiter_status,
            'user_name' => $firstOrder->user_name,
            'user_contact' => $firstOrder->user_contact,
            'cards' => []
        ];

        // Extract card data only once per order
        $cards = $orders->map(function ($card) {
            return [
                'recipe_name' => $card->recipe_name,
                'quantity' => $card->quantity,
                'recipe_price' => $card->recipe_price,
                'varient' => $card->varient,
                'recipe_status' => $card->recipe_status,
                'recipe_id' => $card->recipe_id,
                'cart_id' => $card->cart_id,
            ];
        })->unique('cart_id')->values()->all(); // Remove duplicates based on cart_id

        $formattedOrder['cards'] = $cards;

        return $formattedOrder;
    })->values()->all();

    if (!empty($item_list_against_userid)) {
        return response()->json(['status' => true, 'data' => $item_list_against_userid]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}

public function get_dine_in_waiter_order_last(Request $request)
{
    $get_allorder_by_user_id = DB::table('order')
        ->leftJoin('cart', 'cart.order_id', '=', 'order.id')
        ->leftJoin('restro', 'restro.id', '=', 'order.restro_id')
        ->leftJoin('users', 'users.id', '=', 'order.user_id')
        ->leftJoin('users as waiters', 'waiters.waiter_id', '=', 'order.user_id') // Join users table again for waiter's info
        ->leftJoin('users as latest_waiter_user', function ($join) {
            $join->on('latest_waiter_user.waiter_id', '=', 'waiters.waiter_id');
            $join->whereRaw('latest_waiter_user.created_at = (SELECT MAX(created_at) FROM users WHERE waiter_id = waiters.waiter_id)');
        })
        ->where('order.type', 'Dine In')
        ->whereIn('order.waiter_status', ['Send to Waiter', 'Waiting for Kitchen', 'Order is Cooking', 'Food is Ready', 'Order Completed'])
        ->whereNotNull('cart.recipe_status')
        ->select(
            'order.id',
            'order.address as order_address',
            'order.otp',
            'order.total as grand_total',
            'order.created_at',
            'order.order_date',
            'order.status',
            'order.order_id2',
            'order.restro_id',
            'order.table_id',
            'restro.restaurant',
            'restro.address as restro_address',
            'cart.recipe_price',
            'cart.recipe_name',
            'cart.quantity',
            'cart.varient',
            'cart.recipe_status',
            'cart.id as cart_id',
            'cart.recipe_id',
            DB::raw("CASE WHEN users.role = 'waiter' THEN latest_waiter_user.name ELSE users.name END AS user_name"), // Conditional selection for user_name
            DB::raw("CASE WHEN users.role = 'waiter' THEN latest_waiter_user.contact ELSE users.contact END AS user_contact"), // Conditional selection for user_contact
            'order.waiter_status'
        )
        ->orderBy('order.id', 'desc')
        ->get();

    $groupedOrders = $get_allorder_by_user_id->groupBy('id');

    $item_list_against_userid = $groupedOrders->map(function ($orders) {
        $firstOrder = $orders->first();

        $formattedOrder = [
            'id' => $firstOrder->id,
            'order_id2' => $firstOrder->order_id2,
            'grand_total' => $firstOrder->grand_total,
            'order_date' => $firstOrder->created_at,
            'otp' => $firstOrder->otp,
            'restaurant' => $firstOrder->restaurant,
            'order_address' => $firstOrder->order_address,
            'restro_address' => $firstOrder->restro_address,
            'restro_id' => $firstOrder->restro_id,
            'table_id' => $firstOrder->table_id,
            'status' => $firstOrder->waiter_status,
            'user_name' => $firstOrder->user_name,
            'user_contact' => $firstOrder->user_contact,
            'cards' => []
        ];

        // Extract card data only once per order
        $cards = $orders->map(function ($card) {
            return [
                'recipe_name' => $card->recipe_name,
                'quantity' => $card->quantity,
                'recipe_price' => $card->recipe_price,
                'varient' => $card->varient,
                'recipe_status' => $card->recipe_status,
                'recipe_id' => $card->recipe_id,
                'cart_id' => $card->cart_id,
            ];
        })->unique('cart_id')->values()->all(); // Remove duplicates based on cart_id

        $formattedOrder['cards'] = $cards;

        return $formattedOrder;
    })->values()->all();

    if (!empty($item_list_against_userid)) {
        return response()->json(['status' => true, 'data' => $item_list_against_userid]);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}



public function dine_in_add_to_cart(Request $request)
{
    $items = explode(',', $request->recipe_id); // Split the recipe IDs
    //$quantities = explode(',', $request->quantity); // Split the quantities
    $quantity = 1;

    $insert = false;

    for ($i = 0; $i < count($items); $i++) {
        $item = $items[$i];
        //$quantity = isset($quantities[$i]) ? $quantities[$i] : 1; // Use the provided quantity or default to 1

        $item_details = Menu::where('id', $item)
            ->whereNotNull('varient') // Ensure varient is not null
            ->select('recipe', 'price', 'varient')
            ->first();

        if ($item_details) {
            $insert = Cart::create([
                'user_id' => $request->user_id,
                'restro_id' => $request->restro_id,
				'table_id' => $request->table_id,
                'recipe_id' => $item,
				'type'=>"Dine In",
                'recipe_name' => $item_details->recipe,
                'quantity' => $quantity,
                'varient' => $item_details->varient,
                'recipe_price' => $quantity * $item_details->price,
                'status' => 'Pending',
				'restro_status' => 'Your order is Pending',
				'recipe_status'=>'Dine In Order',
                'verify' => 1
            ]) || $insert; // Ensure insert flag is true if any insertion succeeds
        }
    }

    if ($insert) {
        return response()->json(['status' => true, 'message' => 'Data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'No valid items to add to cart']);
    }
}


public function dineInaddToCartWithoutVarient(Request $request)
{
// Delete existing records for the user and restaurant combination
    //$delete = Cart::where('user_id', $request->user_id)
     //   ->where('restro_id', $request->restro_id)
	//	->where('varient', null)
      //  ->where('order_id', null)
     //   ->delete();

    $item = explode(',', $request->recipe_id);
    //$quantity = explode(',', $request->quantity);
    $quantity = 1;

    $insert = false;

    for ($i = 0; $i < count($item); $i++) {
        if (isset($item[$i])) {
            $item_details = Menu::where('id', $item[$i])
                ->whereNull('varient')  // Check for null varient
                ->select('recipe', 'price', 'varient')
                ->first();
//dd($item_details);
            if ($item_details) {  // Only process if item_details is found
                $insert = Cart::create([
                    'user_id' => $request->user_id,
                    'restro_id' => $request->restro_id,
                    'recipe_id' => $item[$i],
                    'type' => "Dine In",
                    'recipe_name' => $item_details->recipe,
                    //'quantity' => $quantity[$i],
					'quantity' => $quantity,
                    'varient' => $item_details->varient,
                    //'recipe_price' => $quantity[$i] * $item_details->price,
                    'recipe_price' => $quantity * $item_details->price,
                    //'recipe_price' => $item_details->price,
					'table_id' => $request->table_id,
 					'status' => 'Pending',
					'restro_status' => 'Your order is Pending',
					'recipe_status'=>'Dine In Order',
					'verify' => 1
                ]);
            }
        }
    }

    if ($insert) {
        return response()->json(['status' => true, 'message' => 'Data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'Data not found']);
    }
}
public function dine_in_add_to_cart2(Request $request)
{
// Delete existing records for the user and restaurant combination
    $delete = Cart::where('user_id', $request->user_id)
        ->where('restro_id', $request->restro_id)
		->where('table_id', $request->table_id)
        ->where('order_id', null)
        ->delete();

    $item = explode(',', $request->recipe_id);
    $quantity = explode(',', $request->quantity);

    $insert = false;

    for ($i = 0; $i < count($item); $i++) {
        if (isset($request->recipe_id[$i])) {
            $item_details = Menu::where('id', $item[$i])->select('recipe', 'price', 'varient')->first();

            $insert = Cart::create([
                'user_id' => $request->user_id,
                'restro_id' => $request->restro_id,
				'table_id' => $request->table_id,
				'order_id2' => $request->order_id2,
                'recipe_id' => $item[$i],
                'recipe_name' => $item_details->recipe,
                'quantity' => $quantity[$i],
                'varient'=>$item_details->varient,
                'recipe_price' => $quantity[$i] * $item_details->price, // Corrected column name
                'restro_status' => 'Your order is Pending',
				'type'=>"Dine In",
				'recipe_status'=>'Dine In Order',
                'verify' => 1,
            ]);
        }
    }
    if ($insert) {
        return response()->json(['status' => true, 'message' => 'data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
}

public function get_dine_in_cart(Request $request)
{
    $added_time_data = Cart::where('user_id', $request->user_id)
        ->where('order_id', null)
        ->where('cart.type', "Dine In")
        ->get();

    $added_time_ids = $added_time_data->pluck('recipe_id')->toArray();

    $items = Menu::whereIn('id', $added_time_ids)->get();

    foreach ($items as $item) {
        $cardData = $added_time_data->firstWhere('recipe_id', $item->id);

        if ($cardData) {
            $recipe_price = $cardData->quantity * $item->price;
            Cart::where('user_id', $request->user_id)
                ->where('recipe_id', $item->id)
                ->update([
                    'recipe_name' => $item->recipe,
                    'recipe_price' => $recipe_price,
                ]);
        }
    }

    $get_cart = Cart::where('user_id', $request->user_id)
        ->where('order_id', null)
		->where('cart.type', 'Dine In')
        ->select('cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.recipe_name','cart.varient', 'cart.recipe_price', 'cart.quantity', 'cart.type', 'cart.table_id', 'recipe.recipe', 'restro.restaurant')
        ->leftjoin('restro', 'restro.id', '=', 'cart.restro_id')
        ->leftjoin('recipe', 'recipe.id', '=', 'cart.recipe_id')
       ->groupBy('cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.recipe_name','cart.varient', 'cart.recipe_price', 'cart.quantity', 'cart.type', 'cart.table_id',  'recipe.recipe', 'restro.restaurant')

		// Include 'recipe_price' in the GROUP BY clause
       // ->where('user_id', $request->user_id)
        ->get();

           // Add index to each item
    $get_cart = $get_cart->map(function ($item, $index) {
        $item['index'] = $index + 1; // Index starts from 1
        return $item;
    });

    $grandTotal = $get_cart->sum('recipe_price');
\Log::info("Grand Total: {$grandTotal}");
    // Apply coupon logic if there's a coupon code in the cart
    $appliedCoupon = null;
    if ($get_cart->first() && $get_cart->first()->coupon_code) {
        $couponCode = $get_cart->first()->coupon_code;
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon && $grandTotal >= $coupon->min_cost) {
            if ($coupon->dstype === 'Rupee') {
                $grandTotal -= $coupon->value;
            } elseif ($coupon->dstype === 'Percent') {
                $discountAmount = ($coupon->value / 100) * $grandTotal;
                $grandTotal -= $discountAmount;
            }
            $appliedCoupon = $coupon;
        }
    }

    if ($get_cart) {
        return response()->json(['status' => true, 'data' => $get_cart, 'grand_total' => $grandTotal]);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
}


public function get_dine_in_cart2(Request $request)
{
    // Fetch initial cart data
    $added_time_data = Cart::where('user_id', $request->user_id)
        ->where('order_id', null)
        ->where('type', "Dine In")
        ->get();

    // Collect recipe IDs
    $added_time_ids = $added_time_data->pluck('recipe_id')->toArray();

    // Fetch menu items based on recipe IDs
    $items = Menu::whereIn('id', $added_time_ids)->get();

    // Update cart items with recipe names and prices
    foreach ($items as $item) {
        $cardData = $added_time_data->firstWhere('recipe_id', $item->id);
        if ($cardData) {
            $recipe_price = $cardData->quantity * $item->price;
            Cart::where('user_id', $request->user_id)
                ->where('recipe_id', $item->id)
                ->update([
                    'recipe_name' => $item->recipe,
                    'recipe_price' => $recipe_price,
                ]);
        }
    }

    // Fetch updated cart data with necessary joins
    $get_cart = Cart::where('user_id', $request->user_id)
        ->where('order_id', null)
        ->where('cart.type', 'Dine In')
        ->select(
            'cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code',
            'cart.recipe_name', 'cart.varient', 'cart.recipe_price', 'cart.quantity', 'cart.type',
            'cart.table_id', 'recipe.recipe', 'restro.restaurant'
        )
        ->leftJoin('restro', 'restro.id', '=', 'cart.restro_id')
        ->leftJoin('recipe', 'recipe.id', '=', 'cart.recipe_id')
        ->groupBy(
            'cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code',
            'cart.recipe_name', 'cart.varient', 'cart.recipe_price', 'cart.quantity', 'cart.type',
            'cart.table_id', 'recipe.recipe', 'restro.restaurant'
        )
        ->get();

    // Add index to each item
    $get_cart = $get_cart->map(function ($item, $index) {
        $item['index'] = $index + 1; // Index starts from 1
        return $item;
    });

    // Calculate grand total of recipe prices in the cart
    $grandTotal = $get_cart->sum('recipe_price');
    \Log::info("Grand Total: {$grandTotal}");

    // Apply coupon logic if there's a coupon code in the cart
    $appliedCoupon = null;
    if ($get_cart->first() && $get_cart->first()->coupon_code) {
        $couponCode = $get_cart->first()->coupon_code;
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon && $grandTotal >= $coupon->min_cost) {
            if ($coupon->dstype === 'Rupee') {
                $grandTotal -= $coupon->value;
            } elseif ($coupon->dstype === 'Percent') {
                $discountAmount = ($coupon->value / 100) * $grandTotal;
                $grandTotal -= $discountAmount;
            }
            $appliedCoupon = $coupon;
        }
    }

    if ($get_cart->isNotEmpty()) {
        return response()->json(['status' => true, 'data' => $get_cart, 'grand_total' => $grandTotal]);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
}


public function dine_in_remove_cart(Request $request)
            {
                $remove = cart::where('recipe_id', $request->recipe_id)
                ->where('restro_id', $request->restro_id)
               ->delete();

               if ($remove) {
                   return response()->json(['status' => true, 'message' => 'Data Deleted Successfully']); //array
                } else {
                   return response()->json(['status' => false, 'message' => 'User Not Found']); //array
                }
           }




public function dine_in_add_to_cart_through_waiter(Request $request)
{



    // Delete existing records for the user and restaurant combination
    $existing_cart_items  = Cart::where('user_id', $request->user_id)
        ->where('restro_id', $request->restro_id)
		->where('table_id', $request->table_id)
        ->where('order_id', $request->order_id)
		//->where('order_id2', $request->order_id2)

		->exists();
   // If there are no existing cart items for the same order_id, delete old records
    if (!$existing_cart_items) {
        $delete = Cart::where('user_id', $request->user_id)
            ->where('restro_id', $request->restro_id)
            ->where('table_id', $request->table_id)
            ->where('order_id', $request->order_id)
			//->where('order_id2', $request->order_id2)

            ->delete();
    }
    $item = explode(',', $request->recipe_id);
    $quantity = explode(',', $request->quantity);

    $insert = false;

    for ($i = 0; $i < count($item); $i++) {
        if (isset($request->recipe_id[$i])) {
            $item_details = Menu::where('id', $item[$i])->select('recipe', 'price', 'varient')->first();

            $insert = Cart::create([
                'user_id' => $request->user_id,
                'restro_id' => $request->restro_id,
				'order_id' => $request->order_id,
				'order_id2' => $request->order_id2,
				'table_id' => $request->table_id,
                'recipe_id' => $item[$i],
                'recipe_name' => $item_details->recipe,
                'quantity' => $quantity[$i],
                'varient'=>$item_details->varient,
                'recipe_price' => $quantity[$i] * $item_details->price, // Corrected column name
                'restro_status' => 'Your order is Pending',
				'type'=>"Dine In",
                'verify' => 1,
            ]);
        }
    }


    if ($insert) {
        return response()->json(['status' => true, 'message' => 'data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
}


public function get_dine_in_cart_waiter2222222222(Request $request)
{
    $added_time_data = Cart::where('user_id', $request->user_id)
       // ->where('order_id', $request->order_id)
        ->where('type', "Dine In")
	    ->whereNull('recipe_status')
		->get();

    $added_time_ids = $added_time_data->pluck('recipe_id')->toArray();

    $items = Menu::whereIn('id', $added_time_ids)->get();

    foreach ($items as $item) {
        $cardData = $added_time_data->firstWhere('recipe_id', $item->id);

        if ($cardData) {
            $recipe_price = $cardData->quantity * $item->price;
            Cart::where('user_id', $request->user_id)
                ->where('recipe_id', $item->id)
                ->update([
                    'recipe_name' => $item->recipe,
                    'recipe_price' => $recipe_price,
                ]);
        }
    }

    $get_cart = Cart::where('cart.user_id', $request->user_id)
      //  ->where('order_id', $request->order_id)
        ->select('cart.id as cart_id','cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.recipe_name','cart.varient', 'cart.recipe_price', 'cart.quantity', 'cart.type', 'cart.table_id', 'recipe.recipe', 'restro.restaurant')
        ->leftjoin('restro', 'restro.id', '=', 'cart.restro_id')
        ->leftjoin('recipe', 'recipe.id', '=', 'cart.recipe_id')
       ->groupBy('cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.recipe_name','cart.varient', 'cart.recipe_price', 'cart.quantity', 'cart.type', 'cart.table_id',  'recipe.recipe', 'restro.restaurant')

		// Include 'recipe_price' in the GROUP BY clause
        ->where('user_id', $request->user_id)
        ->get();

           // Add index to each item
    $get_cart = $get_cart->map(function ($item, $index) {
        $item['index'] = $index + 1; // Index starts from 1
        return $item;
    });

    $grand_total = DB::table('cart')
        ->where('cart.user_id', $request->user_id)
       // ->where('order_id', $request->order_id)
        ->sum('recipe_price');

    if ($get_cart) {
        return response()->json(['status' => true, 'data' => $get_cart, 'grand_total' => $grand_total]);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
}

public function get_dine_in_cart_waiter(Request $request)
{
    $added_time_data = Cart::where('user_id', $request->user_id)
        ->where('type', "Dine In")
        ->whereNull('recipe_status')
        ->get();

    $added_time_ids = $added_time_data->pluck('recipe_id')->toArray();

    $items = Menu::whereIn('id', $added_time_ids)->get();

    foreach ($items as $item) {
        $cardData = $added_time_data->firstWhere('recipe_id', $item->id);

        if ($cardData) {
            $recipe_price = $cardData->quantity * $item->price;
            Cart::where('user_id', $request->user_id)
				        ->where('type', 'Dine In')

                ->where('recipe_id', $item->id)
                ->update([
                    'recipe_name' => $item->recipe,
                    'recipe_price' => $recipe_price,
                ]);
        }
    }

    $get_cart = Cart::where('cart.user_id', $request->user_id)
		    ->where('cart.type', 'Dine In')
        ->whereNull('recipe_status') // Filter by recipe_status being null
        ->select('cart.id as cart_id','cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.recipe_name','cart.varient', 'cart.recipe_price', 'cart.quantity', 'cart.type', 'cart.table_id', 'recipe.recipe', 'restro.restaurant')
        ->leftjoin('restro', 'restro.id', '=', 'cart.restro_id')
        ->leftjoin('recipe', 'recipe.id', '=', 'cart.recipe_id')
        ->groupBy('cart.id', 'cart.order_id', 'cart.recipe_id', 'cart.restro_id', 'cart.coupon_code_id', 'cart.recipe_name','cart.varient', 'cart.recipe_price', 'cart.quantity', 'cart.type', 'cart.table_id',  'recipe.recipe', 'restro.restaurant')
        ->get();

    // Add index to each item
    $get_cart = $get_cart->map(function ($item, $index) {
        $item['index'] = $index + 1; // Index starts from 1
        return $item;
    });

    // Calculate grand total from the filtered cart data
    $grand_total = $added_time_data->sum('recipe_price');

    if ($get_cart->isNotEmpty()) {
        return response()->json(['status' => true, 'data' => $get_cart, 'grand_total' => $grand_total]);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
}


// update total in order table
public function dine_in_waiter_update_order(Request $request){
    // Get the existing order, if any
    $existingOrder = Order::where('id', $request->order_id)
					->first();

    // Calculate new total by adding old total and new total
    $newTotal = $existingOrder ? $existingOrder->total + $request->total : $request->total;

    // Update the order if it exists
    if($existingOrder) {
        // Update existing order
        $existingOrder->total = $newTotal;
	    $existingOrder->kitchen_status = 'In Progress'; // Update kitchen status
	    $existingOrder->waiter_status = 'Send to Kitchen'; // Update waiter status
		$existingOrder->status = 'Send to Waiter'; // Update user status
        $existingOrder->save();

  // Update cart items related to the order with recipe_status = null
        Cart::where('order_id', $request->order_id)
			->where('user_id', $request->user_id)
            ->whereNull('recipe_status')
             ->update([
            'recipe_status' => 'Recipe Updated',
        ]);

        return response()->json(['status' => true, 'message' => 'data has been submitted']);

    } else {
        return response()->json(['status' => false, 'message' => 'Order not found']);
    }
}



// update total in order table
public function dine_in_user_update_order(Request $request){
    // Get the existing order, if any
    $existingOrder = Order::where('id', $request->order_id)
					->first();

    // Calculate new total by adding old total and new total
    $newTotal = $existingOrder ? $existingOrder->total + $request->total : $request->total;

    // Update the order if it exists
    if($existingOrder) {
        // Update existing order
        $existingOrder->total = $newTotal;
	    $existingOrder->kitchen_status = 'In Progress'; // Update kitchen status
	    $existingOrder->waiter_status = 'Send to Waiter'; // Update waiter status
		$existingOrder->status = 'Send to Waiter'; // Update user status
        $existingOrder->save();

  // Update cart items related to the order with recipe_status = null
        Cart::where('order_id', $request->order_id)
			->where('user_id', $request->user_id)
            ->whereNull('recipe_status')
             ->update([
            'recipe_status' => 'Recipe Updated',
        ]);

        return response()->json(['status' => true, 'message' => 'data has been submitted']);

    } else {
        return response()->json(['status' => false, 'message' => 'Order not found']);
    }
}



	public function dine_in_waiter_update_order2222(Request $request)
{
    // Get the existing order, if any
    $existingOrder = Order::where('id', $request->order_id)->first();

    // Calculate new total by adding old total and new total
    $newTotal = $existingOrder ? $existingOrder->total + $request->total : $request->total;

    // Update the order if it exists
    if ($existingOrder) {
        // Update existing order
        $existingOrder->total = $newTotal;
		 $existingOrder->kitchen_status = 'In Progress'; // Update kitchen status
    $existingOrder->waiter_status = 'Waiting for Kitchen'; // Update waiter status
        $existingOrder->save();

        // Update cart items related to the order with recipe_status = null
        $updated = Cart::where('order_id', $request->order_id)
                        ->where('user_id', $request->user_id)
                        ->whereNull('recipe_status')
                        ->update(['recipe_status' => 'Recipe Updated']);

        if ($updated !== false) {
            return response()->json(['status' => true, 'message' => 'Data has been submitted']);
        } else {
            return response()->json(['status' => false, 'message' => 'No records found to update']);
        }
    } else {
        return response()->json(['status' => false, 'message' => 'Order not found']);
    }
}


	public function dine_in_remove_waiter_order_item(Request $request)
{
    try {
        // Get the cart item to be deleted
        $cartItem = Cart::where('id', $request->cart_id)
            ->where('recipe_id', $request->recipe_id)
            ->first();

        if (!$cartItem) {
            return response()->json(['status' => false, 'message' => 'Cart item not found'], 404);
        }

        // Update the total price in the order table
        $existingOrder = Order::find($cartItem->order_id);
        if (!$existingOrder) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }

        // Calculate new total by subtracting the price of the deleted recipe
        $newTotal = $existingOrder->total - ($cartItem->quantity * $cartItem->recipe_price);

        // Update the total in the order table
        $existingOrder->total = $newTotal;
        $existingOrder->save();

        // Delete the cart item
        $cartItem->delete();

		 // Check if any remaining carts have recipe_status of "Recipe Updated" for the same order_id
        $remainingCarts = Cart::where('order_id', $cartItem->order_id)
            ->where('recipe_status', 'Recipe Updated')
            ->exists();

        if (!$remainingCarts) {
            // No remaining carts with recipe_status "Recipe Updated"
            $existingOrder->status = 'Food is on the Table';
            $existingOrder->waiter_status = 'Food is on the Table';
            $existingOrder->kitchen_status = 'Order Cooked';
            $existingOrder->save();
        }

        return response()->json(['status' => true, 'message' => 'Data deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'Failed to delete data'], 500);
    }
}



public function Register_new_user_by_waiter_old(Request $request)
{

	//dd($request->all());
    // Check if a user with the provided name and contact already exists
    $existingUser = User::where('name', $request->name)
                        ->where('contact', $request->contact)
                        ->first();

    if ($existingUser) {
        // If user already exists, return a response with user data
        return response()->json(['status' => false, 'message' => 'User already exists', 'data' => $existingUser]);
    }

    // If user doesn't exist, create a new user
    $insert = User::create([
        'name' => $request->name,
        // 'password' => Hash::make($request->password),
        'contact' => $request->contact,
       'restro_id' =>$request->restro_id,
		'waiter_id' =>$request->waiter_id,
      'table_no' =>$request->table_no,
        'role' => 'user',
    ]);

    if ($insert) {
        return response()->json(['status' => true, 'message' => 'Data Submitted Successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Something error occurred']);
    }
}

public function Register_new_user_by_waiter(Request $request)
{
    // Check if a user with the provided name and contact already exists
    $existingUser = User::where('name', $request->name)
                        ->where('contact', $request->contact)
                        ->first();

    if ($existingUser) {
        // If user already exists, return a response with user data
        return response()->json(['status' => false, 'message' => 'User already exists', 'data' => $existingUser]);
    }

    // If user doesn't exist, create a new user
    $newUser = new User();
    $newUser->name = $request->name;
    // $newUser->password = Hash::make($request->password); // Optionally hash the password
    $newUser->contact = $request->contact;
    $newUser->restro_id = $request->restro_id;
    $newUser->waiter_id = $request->waiter_id;
    $newUser->table_no = $request->table_no;
    $newUser->role = 'user';
    $newUser->save();

    // Check if user was successfully created
    if ($newUser) {
        // Return a response with success message and user data including ID
        return response()->json([
            'status' => true,
            'message' => 'Data Submitted Successfully',
            'user_id' => $newUser->id, // Include the ID of the newly created user
            'data' => $newUser
        ]);
    } else {
        // Return an error response if something went wrong
        return response()->json(['status' => false, 'message' => 'Something error occurred']);
    }
}


public function check_user(Request $request)
{
    $user = User::where('contact', $request->newcontact)->first();

    if($user){
        return response()->json([
            'message'=>'User is registered',
            'user'=>$user->name,
        ]);
    }
    else{
        return response()->json([
            'message'=>'User is not Registered',
        ],
        404);
    }

}


//to accept order

public function waiter_accept_order(Request $request)
            {
                $accept_order = Order::where('order_id2', $request->order_id)->first();
                if ($accept_order->id) {
                    $accept_order->update([
                        'status'=>'Accepted',
						// 'restro_status'=>'Pending Delivery Boy',
                        'waiter_status'=>'Send to Kitchen',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }

//to cancel order

            public function waiter_cancel_order(Request $request){
                $cancel_order = Order::where('order_id2', $request->order_id)->first();
                if ($cancel_order->id) {
                    $cancel_order->update([
                       // 'status'=>$request->status,
                        'status'=>'Order Cancelled',
                        // 'restro_status'=>'Your Order is Cancelled',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }




// Complete order by waiter
public function dine_in_waiter_order_completed(Request $request)
{
    $complete_waiter_order = Order::where('order_id2', $request->order_id)->first();
    if ($complete_waiter_order->id) {
        $complete_waiter_order->update([
			'waiter_status'=>'Order Completed',
            'status'=>'Order Completed',

            ]);

        return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
    }
}



// Dine In kitchen API

// get order

public function get_dine_in_kitchen_order(Request $request)
{

 //  $waiterId = $request->input('waiter_id');
//$dd= User::where('id',$request->waiter_id)->first();
		//echo json_encode($dd);

    // Retrieve orders with related carts, delivery address, and restro
    $orders = Order::with(['carts', 'deliveryAddress', 'restro', 'table'])
         //->where('order.restro_id',$dd->restro_id)
		 ->where('waiter_status', 'Waiting for Kitchen')
		 ->orwhere('waiter_status', 'Order is Cooking')
		->orwhere('waiter_status', 'Food is Ready')
		->orwhere('waiter_status', 'Food is on the Table')
		->orwhere('waiter_status', 'Order Completed')
        ->get();
//	echo json_encode($orders);
	//exit();

    if ($orders->isNotEmpty()) {
        // Transform the results
        $item_list_against_userid = $orders->map(function ($order) {

			  $index = 0; // Initialize the index

            // Filter and sort carts for 'Dine In'
            $filteredCarts = $order->carts
                ->filter(function ($cart) {
                    return $cart->type === 'Dine In';
                })
                ->sortByDesc('created_at');


            return [
                'id' => $order->id,
                'order_id2' => $order->order_id2,
				//'order_date' => $orders->first()->created_at,
                'order_date' => $order->first()->created_at->format('Y-m-d H:i:s'),
				'type' => $order-> type,
				'table_id' => $order-> table_id,
                'total' => $order->total,
                'payment_mode' => $order->payment_mode,
                'delivery_type' => $order->delivery_type,
                'delivery_charges' => $order->delivery_charges,
                'coupon_code' => $order->coupon_code,
				'status' => $order->waiter_status,
                'contact_number'=>$order->contact_number,
                 'item' => $filteredCarts->values()->map(function ($cart) use (&$index) {
                    $index++; // Increment the index for each cart

                    return [
						'index' => $index, // Add 1 to start index from 1
                        'recipe_name' => $cart->recipe_name,
                        'quantity' => $cart->quantity,
                        'recipe_price' => $cart->recipe_price,
						'varient'=>$cart->varient,
						'recipe_status'=>$cart->recipe_status,

                    ];
                })->toArray(),
                'pickup_address' => $order->restro->address, // Use the restro address as pickup address
               // 'table_number' => $order->table->table, // Retrieve table number from the table relationship
				'table_number' => $order->table->table ?? null,

            ];
        });


        return response()->json(['status' => true, 'data' => $item_list_against_userid]);
    } else {
        return response()->json(['status' => false, 'message' => 'No orders in progress']);
    }
}


// Accept order by Kitchen
public function dine_in_kitchen_accept_order(Request $request)
            {
                $accept_kitchen_order = Order::where('order_id2', $request->order_id)->first();
                if ($accept_kitchen_order->id) {
                    $accept_kitchen_order->update([
                       // 'status'=>$request->status,
						'status'=>'Order is Cooking',
						 'waiter_status' =>'Order is Cooking',
                         'kitchen_status'=>'Order is Cooking',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }


//to cancel order

            public function dine_in_kitchen_cancel_order(Request $request){
                $cancel_order = Order::where('order_id2', $request->order_id)->first();
                if ($cancel_order->id) {
                    $cancel_order->update([
                       // 'status'=>$request->status,
                        'waiter_status'=>'Pending Kitchen',
						'status'=>'Pending Kitchen',
                    ]);
                    return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
                }
            }




// Complete order by Kitchen
public function dine_in_waiter_order_serve(Request $request)
{
    $waiter_serve_order = Order::where('order_id2', $request->order_id)->first();
    if ($waiter_serve_order->id) {
        $waiter_serve_order->update([
           // 'status'=>$request->status,
            'status'=>'Food is on the Table',
            'waiter_status'=>'Food is on the Table',

            ]);

        return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
    }
}




// Complete order by Kitchen
public function dine_in_kitchen_order_completed(Request $request)
{
    $complete_kitchen_order = Order::where('order_id2', $request->order_id)->first();
    if ($complete_kitchen_order->id) {
        $complete_kitchen_order->update([
           // 'status'=>$request->status,
            'status'=>'Food is Ready to Serve',
             'waiter_status'=>'Food is Ready',
             'kitchen_status'=>'Order Cooked',
            ]);

		  // Update recipe_status in Cart table where order_id matches
        Cart::where('order_id', $complete_kitchen_order->id)
            ->update(['recipe_status' => 'Order Completed']);

        return response()->json(['status' => true, 'message' => 'Data Updated Successfully']);
    } else {
        return response()->json(['status' => false, 'message' => 'Something Error Occure At Server']);
    }
}



// get order against user id and order id

public function generate_bill(Request $request)
{

	//$apiKey = env('API_KEY');
   $get_allorder_by_user_id = DB::table('order')
    ->leftjoin('cart', 'cart.order_id', '=', 'order.id')
    ->leftjoin('restro', 'restro.id', '=', 'order.restro_id')
   // ->where('order.user_id', $request->user_id)
	//->whereNull('order.type') // Filter orders where type is null
    ->where('order.id', $request->order_id)
    ->select('order.id', 'order.total as grand_total','order.created_at', 'order.order_date','order.order_id2', 'order.restro_id',
      'cart.recipe_price', 'cart.recipe_name','cart.quantity', 'cart.varient', 'restro.restaurant', 'restro.address', )
    ->orderBy('order.id','desc') // Optional: Order the results by order ID
    ->get();


// dd($get_allorder_by_user_id);


// Group the results by order ID
$groupedOrders = $get_allorder_by_user_id->groupBy('id');
// Transform the grouped results
$item_list_against_userid = $groupedOrders->map(function ($orders) {
    return [
        'order.id' => $orders->first()->id,
        'order_id2' => $orders->first()->order_id2,
         'grand_total' => $orders->first()->grand_total,
        'order_date' => $orders->first()->created_at,
		//'otp'=>$orders->first()->otp,
        //'recipe_price'=> $orders->first()->recipe_price,
            'restro_name' => $orders->first()->restaurant, // Access restaurant name
            'restro_address' => $orders->first()->address, // Access restaurant name

        'cards' => $orders->map(function ($card) {
			static $index = 0; // Initialize the index
            $index++; // Increment the index for each card
            return [
				'index' => $index, // Add 1 to start index from 1
                'recipe_name' => $card->recipe_name,
                'quantity' => $card->quantity,
				'recipe_price'=>$card->recipe_price,
				'varient'=>$card->varient,

                // 'recipe_price' => $card->recipe_price,
            ];
        })->toArray(),
    ];

})->values()->all();
// dd($get_allorder_by_user_id);
if (!empty($item_list_against_userid)) {
    return response()->json(['status' => true, 'data' => $item_list_against_userid]);
} else {
    return response()->json(['status' => false, 'message' => 'Data not found']);
}
}




// New Registration login and forget password flow

	 public function registration(Request $request)
    {
        // Check if the mobile number already exists in the database
        $existingUser = User::where('contact', $request->contact)->first();

        if ($existingUser) {
            // If a user with the same mobile number already exists, return an error response
            return response()->json(['status' => false, 'message' => 'Mobile number already exists']);
        }

        // If the mobile number doesn't exist, proceed with registration
        $insert = User::create([
            'name' => $request->full_name,
            'contact' => $request->contact,
           // 'email' => $request->email,
          //  'address' => $request->address,
            'password' => Hash::make($request->pin),
			'role'=>'user',

        ]);

        if ($insert) {
            return response()->json(['status' => true, 'message' => 'Data Submitted Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something error occurred']);
        }
    }


    public function login(Request $request)
    {
        $user = User::where('contact', $request->contact)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json(['status' => true,  'message' => 'User Login Successfully', 'user' => $user,]);
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Found']);
        }
    }



    public function forget_verify_otp(Request $request)
    {
        // Check if the mobile number exists in the user model
        $user = User::where('contact', '=', $request->contact)->first();

        if ($user !== null) {

			  $otp = rand(1000, 9999);
        $name = 'Sir/Mam';
        $msg = 'Dear ' . $name . ', Your OTP is ' . $otp . '. Send by WEBMEDIA';
        $msg = urlencode($msg);
        $to = $request->contact;


			  $data1 = "uname=habitm1&pwd=habitm1&senderid=WMEDIA&to=" .
            $to . "&msg=" . $msg .
            "&route=T&peid=1701159196421355379&tempid=1707161527969328476";
        $ch = curl_init('http://bulksms.webmediaindia.com/sendsms?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
            return response()->json($otp);
        } else {
            // Mobile number doesn't exist in the user model, return a response indicating that
            return response()->json(['status' => false, 'data' => 'Mobile number not registered.']);
        }
    }




    public function forget_change_password(Request $request)
    {
        // Validate the request
        $request->validate([
            // 'mobile' => 'required|string',
            // 'new_password' => 'required|string|min:6',
        ]);


        $existingUser = User::where('contact', $request->contact)->first();

        if (!$existingUser) {

            return response()->json(['error' => 'Mobile number not found.'], 404);
        }


        $existingUser->update([
            'password' => Hash::make($request->pin),
        ]);

        // Return success response
        return response()->json(['success' => 'Password changed successfully.'], 200);
    }








	//------------------------------------------

 public function forget_verify_otp_register(Request $request)
{

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'contact' => 'required|string|regex:/^[0-9]{10}$/',
        ]);

        if ($validator->fails()) {
            // If validation fails, return error response
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 400);
        }

        // Check if a user with the same mobile number already exists
        $existingUser = User::where('contact', $request->contact)->first();

        if ($existingUser) {
            // If a user with the same mobile number already exists, return an error response
            return response()->json(['status' => false, 'message' => 'Mobile number already exists'], 400);
        }

        // Generate a random 4-digit OTP
        $otp = rand(1000, 9999);

        // Construct SMS message
        $name = 'Sir/Madam';
        $msg = 'Dear ' . $name . ', Your OTP is ' . $otp . '. Sent by WEBMEDIA';
        $msg = urlencode($msg);
        $to = $request->contact;

        // Send SMS via cURL
    	  $data1 = "uname=habitm1&pwd=habitm1&senderid=WMEDIA&to=" .
            $to . "&msg=" . $msg .
            "&route=T&peid=1701159196421355379&tempid=1707161527969328476";
        $ch = curl_init('http://bulksms.webmediaindia.com/sendsms?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        if (!$result) {
            // Log the error
            error_log('SMS API Error: ' . curl_error($ch));
            // Return error response or handle accordingly
            return response()->json(['status' => false, 'message' => 'Failed to send OTP via SMS'], 500);
        }

        curl_close($ch);

        // Store OTP and user data in the database
        $user = User::create([
            'name' => $request->full_name,
            'contact' => $request->contact,
			'role' => "user",
            'otp' => $otp,
        ]);

        if ($user) {
            // If user data is successfully stored, return success response
            return response()->json(['status' => true, 'message' => 'Data submitted successfully', 'otp' => $otp]);
        } else {
            // If user data insertion fails, return error response
            return response()->json(['status' => false, 'message' => 'Failed to submit data'], 500);
        }

}



public function dine_in_update_post_order(Request $request){

	 // Retrieve the user's cart entry to get order_id2
    $cart = Cart::where('user_id', $request->user_id)->first();

    if (!$cart) {
        // Handle case where cart entry for the user is not found
        return response()->json(['error' => 'Cart not found'], 404);
    }

    // Extract order_id2 from the cart entry
    $order_id2 = $cart->order_id2;
	//dd($request->all());
    $insert = Order::create([
        'user_id'=> $request->user_id,
		'waiter_id'=>$request->waiter_id,
		'order_id2' => $order_id2,
        'restro_id' => $request->restro_id,
        'table_id' => $request->table_id,
        'total' => $request->total,

       // 'delivery_type'=>$request->delivery_type,
       'contact_number'=>$request->contact,
        'order_date'=>$request->order_date,
        'status'=> "Send to Waiter", //Just massage to show
        'waiter_status'=>"Send to Waiter",
        'type'=>"Dine In",
        'verify' => 1
    ]);

$insert->user_id = $request->user_id;
$insert->save();

    $cart_update = Cart :: where('user_id',$request->user_id)
    ->where('order_id',null)
    ->update([
        'order_id'=>$insert->id,
    ]);

    if($insert) {
        return response()->json(['status' => true, 'message' => 'data has been submitted']);
    } else {
        return response()->json(['status' => false, 'message' => 'data not found']);
    }
    }

public function dine_in_update_post_order2(Request $request){
	 // Get the existing order, if any
    $existingOrder = Order::where('order_id2', $request->order_id2)
					->first();

    // Calculate new total by adding old total and new total
    $newTotal = $existingOrder ? $existingOrder->total + $request->total : $request->total;

    // Update the order if it exists
    if($existingOrder) {
        // Update existing order
        $existingOrder->total = $newTotal;
        $existingOrder->save();

  // Update cart items related to the order with recipe_status = null
        Cart::where('order_id2', $request->order_id2)
			->where('user_id', $request->user_id)
            ->whereNull('recipe_status')
            ->update(['recipe_status' => 'Recipe Updated']);

        return response()->json(['status' => true, 'message' => 'data has been submitted']);

    } else {
        return response()->json(['status' => false, 'message' => 'Order not found']);
    }
}


//notification

public function get_notification(){
$notification = Notification::all();
	if($notification){
	return response()->json(['status' => true, 'data'=>$notification]);
}
	else{
	return response()->json(['status'=>false, 'message'=>'Notification Not Found']);
	}
}

//updated api dont need to pass id
public function apply_coupon222(Request $request)
    {
         // Check if there's an unprocessed cart entry for the user
		$total_before_coupon = $request->total_before_discount;
        $cart = Cart::where('user_id', $request->user_id)
                    ->whereNull('order_id')
                    ->first();

//echo json_encode($cart);
        if ($cart) {
            // Update the coupon_code in the cart
            $cart->coupon_code = $request->coupon_code;
            $cart->save();

            return response()->json([
                'message' => 'Coupon applied successfully',
               // 'cart' => $cart
            ]);
        }

        return response()->json([
            'message' => 'No active cart found for this user',
        ], 404);
    }

	public function apply_coupon(Request $request)
{
    $total_before_coupon = $request->total_before_discount;
    $coupon_code = $request->coupon_code;

    // Check if there's an unprocessed cart entry for the user
    $cart = Cart::where('user_id', $request->user_id)
                ->whereNull('order_id')
                ->first();

    if ($cart) {
        // Check if the coupon exists
        $coupon = Coupon::where('code', $coupon_code)->first();

        if ($coupon && $total_before_coupon >= $coupon->min_cost) {
            // Update the coupon_code in the cart
            $cart->coupon_code = $coupon_code;
            $cart->save();

            return response()->json([
                'message' => 'Coupon applied successfully',
                'cart' => $cart,
            ]);
        } else {
            return response()->json([
                'message' => 'Coupon could not be applied. Minimum cart value should be ' . ($coupon ? $coupon->min_cost : 'N/A'),
            ], 400);
        }
    }

    return response()->json([
        'message' => 'No active cart found for this user',
    ], 404);
}



public function get_gst(){
$gst = GST::all();
return response()->json(['status' => true, 'data' => $gst]);

}


public function capturePayment(Request $request)
{
$api = new Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_SECRET_KEY'));
$input = $request->all();        $payment = $api->payment->fetch($input['paymentId']);
if(count($input)  && !empty($input['paymentId']))
        {
            try
            {
$response = $api->payment->fetch($input['paymentId'])->capture(array('amount'=>$payment['amount']));
               return response()->json(['status' => true, 'message' => 'This payment captured successfully']);

            }
            catch (\Exception $e)
            {
                return response()->json(['status' => false, 'message' => $e->message()]);
            }
        }

}





public function downloadQrCode($restaurant_id, $table_number)
{

    $restro = Restro::find($restaurant_id);

    // if (!$restro) {
    //     return response()->json(['error' => 'Restaurant not found'], 404);
    // }

    // $menu = Menu::where('restaurant_id', $restaurant_id)->get();

    // Concatenate restaurant name, table number, and menu details into a single string
    // $qrData = $restro->restaurant . "\n";
    $qrData = "restaurant_id: " . $restaurant_id . "\n"; // Include table number
    $qrData .= "table_number: " . $table_number . "\n"; // Include table number

    // foreach ($menu as $menuItem) {
    //     // $qrData .= $menuItem->recipe . ' | ' . $menuItem->varient . ' | ' . $menuItem->price . ' | ' . $menuItem->description . "\n";
    // }

    return view('admin.qr-code', [
        'restaurant_id' => $restaurant_id,
        'table_number' => $table_number, // Pass $table_id to the view
        'qrData' => $qrData,
        // 'restro' => $restro, // Pass $restro to the view
        // 'menu' => $menu,     // Pass $menu to the view
    ]);
}


//-----------------------

	public function send_mobile_verify_otp(Request $request)
    {
        $user = User::
        where('contact', '=', $request->contact)
        //->select('employee_registraions.contact')
        ->first(); //check already exist
        // echo json_encode($user);
        // exit();
    if ($user && !empty($user->password)) {
        return response()->json(['data'=>['status'=>false, 'message' => 'Mobile Number already exists']], 400);
    }
		    $otp = rand(1000, 9999);
        $name = 'Sir/Mam';
       $msg = 'Dear ' . $name . ', Your OTP is ' . $otp . '. Send
           by WEBMEDIA';
        $msg = urlencode($msg);
        $to = $request->contact;
       // $user->mobile;
        //$request->mobile;
        $data1 = "uname=habitm1&pwd=habitm1&senderid=WMEDIA&to=" .
            $to . "&msg=" . $msg .
            "&route=T&peid=1701159196421355379&tempid=1707161527969328476";
        $ch = curl_init('http://bulksms.webmediaindia.com/sendsms?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

			  if ($user) {
        $user->otp = $otp;
        $user->save();
        return response()->json(['data' => ['otp' => $otp, 'id' => $user->id]], 200);
    }

    $newUser = User::create([
        'contact' => $request->contact,
        'name' => $request->name,
        'otp' => $otp,
        'role' => 'user',
    ]);
			    return response()->json(['data' => ['otp' => $otp, 'id' => $newUser->id]], 200);

    }
	//Dear User, Your OTP is {#var#}. Use this OTP for login to your MKDINE application for booking a table.
    // Check User


     public function user_registration(Request $request)
     {
        $user = User::
		 //where('role_name_id',27)
       where('contact', '=', $request->contact)
        //->select('employee_registraions.contact')
        ->first(); //check already exist
        if (isset($user) && $user != null) {
            //   return $user;
             return response()->json(['status' => true, 'data' => $user]); //return already exist user
        } else {
             return response()->json(['status' => false, 'data' => 'please register yourself']);
         }
     }

public function otpVerification(Request $request)
{
    $user = User::where('id', $request->user_id)
        ->where('otp', $request->otp)
        ->first();
    if ($user) {
        // OTP is correct
        return response()->json(['status' => true, 'message' => 'OTP verification successful']);
    } else {
        // OTP is incorrect
        return response()->json(['status' => false, 'message' => 'Incorrect OTP'], 400);
    }
}
		}
