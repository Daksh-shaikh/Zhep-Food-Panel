<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restro;
use App\Models\City;
use App\Models\Category;
use App\Models\User;
use App\Models\TimeSlot;
use App\Models\Days;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;


class RestroController extends Controller
{
    public function index(Request $request)
    {
        $restro=Restro::all();
        $city=City::all();
        $category = Category::all();
        $email = $request->input('email', '');
        $password = $request->input('password', '');
        $days = Days::all();

     // Process restros to include categories
     $restro->map(function ($restro) {
        // Directly use the category field if it's already an array
        $categoryIds = $restro->category;
        if (is_array($categoryIds)) {
            $restro->categories = Category::whereIn('id', $categoryIds)->get();
        } else {
            // Handle cases where category field is not an array
            $restro->categories = collect();
        }
        return $restro;
    });
    // dd($days);
        return view('frontend.restro', ['restro'=>$restro,
        'city'=>$city,
        'category'=>$category,
        'email'=>$email,
        'password'=>$password,
        'days'=>$days]);
    }


    public function restroStore(Request $request)
    {

        //    dd($request->all());
            $request->validate([
            'city'=>'required',
            'restaurant'=>'required',
            'address' => 'required',
            'latitude'=>'nullable',
            'longitude'=>'nullable',
            'contact_person'=>'required',
            'mobilenumber' => 'required|digits:10',
            'email' => 'required',
            'password' => 'required',
            'avg_cooking_time' => 'required',
            'banner'=>'nullable|image|mimes:jpeg,png,jpg,gif',
           // 'category' => 'nullable|array', // Accept array or string
            'details'=>'nullable',
            'food'=>'required|array',
            'type'=>'required|array',

        ]);

        $filename = null;
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('banner/'), $filename);
        }

        // $food = implode(',', $request->input('food'));

        // to allow food nullable
        $food = $request->input('food');
        if ($food !== null && is_array($food)) {
            $food = implode(',', $food);
        }
//         $categories = $request->input('category');
// if ($categories !== null && is_array($categories)) {
//     $categories = implode(',', $categories);
// }




$type = $request->input('type');
if ($type !== null && is_array($type)) {
    $type = implode(',', $type);
    $type = str_replace('"', '', $type); // Remove double quotes
}

        $hashedPassword = Hash::make($request->input('password'));


        $data = [
            'banner' => $filename,
            'city' => $request->input('city'),
            // 'city_alias' =>$request->input('city_alias'),
            'restaurant' => $request->input('restaurant'),
            'address' => $request->input('address'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'contact_person' => $request->input('contact_person'),
            'mobilenumber' => $request->input('mobilenumber'),
            'email' => $request->input('email'),
            'password' => $hashedPassword,
            'avg_cooking_time' => $request->input('avg_cooking_time'),
            'category' => $request->input('category'),
            // 'food' => $request->input('food'),
            'details' => $request->input('details'),
            'food' => $food,
            'type'=> $type,
            'service_charges_type'=>$request->input('service_charges_type'),
            'service_charges_value'=>$request->input('service_charges_value'),

        ];

        $restro = Restro::create($data);

           // Attach categories directly to the restro instance
    // $categories = $request->input('category');
    // if ($categories !== null && is_array($categories)) {
    //     $restro->category_name()->attach($categories);
    // }

        //   // Fetch the newly created Restro instance with its categories
        // $restroWithCategories = Restro::with('category_name')->find($restro->id);


//......................................................

         // Extract days information from the request
    $days = Days::all(); // Get all available days
    $selectedDays = $request->input('days', []); // Assume you have a form field named 'days'

    // Loop through each day and create time_slot entries
    foreach ($days as $day) {
        $dayId = $day->id;

        // Check if the day is selected in the form
        if (in_array($dayId, $selectedDays)) {
            // Create a new entry in the time_slot table
            TimeSlot::create([
                'restro_id' => $restro->id,
                'days_id' => $dayId,
                'open_at' => $request->input("open_at_$dayId"),
                'close_at' => $request->input("close_at_$dayId"),
                'is_close' => $request->has("is_close_$dayId"),
            ]);
        }
    }

    //........................................................

          // Create a corresponding user record
        $user = User::create([
        'restro_id'=>$restro->id,
        'restaurant' => $request->input('restaurant'), // You may adjust the name field as needed
        'email' => $request->input('email'),
        'password' => $hashedPassword,
        // ... other fields as needed
    ]);



        return redirect(route('restroIndex'))->with('success', 'Restaurant added successfully');
        // return redirect(route('restroIndex'));
    }

//  to handle error "Call to a member function delete() on null" i use if else condition.
    public function restroDestroy($id){
        $restro = Restro::find($id);

        if ($restro) {
            $restro->delete();
            return redirect(route('restroIndex'))->with('success', 'Restaurant Deleted Successfully');
        } else {
            return redirect(route('restroIndex'))->with('error', 'Field not found');
        }
    }

    public function restroEdit($id){

            $restroEdit= Restro::find($id);
            $restroCollection  = Restro::all();
            $city = City::all();
            $category = Category::all();

            $days = Days::all();

            $decodedFood = json_decode($restroEdit->food, true);


 // Fetch time slots separately for easier access in the Blade template
 $timeSlots = $restroEdit->timeSlots->keyBy('days_id');

            return view('frontend.restro_edit', [
                'restroEdit' => $restroEdit,
                'restroCollection' => $restroCollection,
                'city' => $city,
                'category' => $category,
                'decodedFood' => $decodedFood, // Pass the decoded food array to the view
                'days'=>$days,
                'timeSlots' => $timeSlots,

            ]);

        }


    public function restroUpdate(Request $request)
    {
        $request->validate([
            'city' => 'required',
            'restaurant' => 'required',
            'address' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'contact_person' => 'required',
            'mobilenumber' => 'required|digits:10',
            'email' => 'required|email',
            'avg_cooking_time' => 'required',
            'category' => 'nullable|array',
            'food' => 'nullable|array',
            'type' => 'nullable|array',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'details' => 'nullable',
            'days' => 'required|array',
            // Add validation for time slots if needed
        ]);

        $restro = Restro::find($request->id);

        if (!$restro) {
            return redirect()->back()->with('error', 'Restaurant not found.');
        }

        $food = $request->input('food');
        if ($food !== null && is_array($food)) {
            $food = implode(',', $food);
        }

        $type = $request->input('type');
        if ($type !== null && is_array($type)) {
            $type = implode(',', $type);
        }

        $filename = null;
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('banner/'), $filename);

            // Delete the old banner file if it exists
            if ($restro->banner) {
                $oldFilePath = public_path('banner/') . $restro->banner;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $restro->banner = $filename;
        }

        $hashedPassword = $request->filled('password') ? Hash::make($request->input('password')) : $restro->password;

        $restro->city = $request->city;
        $restro->restaurant = $request->restaurant;
        $restro->address = $request->address;
        $restro->latitude = $request->latitude;
        $restro->longitude = $request->longitude;
        $restro->contact_person = $request->contact_person;
        $restro->mobilenumber = $request->mobilenumber;
        $restro->email = $request->email;
        $restro->avg_cooking_time = $request->avg_cooking_time;
   // Ensure category is treated as an array
   $restro->category = $request->input('category', []);
   $restro->food = $food;
        $restro->type = $type;
        $restro->details = $request->details;
        $restro->password = $hashedPassword; // Update password if provided

        $restro->save();

        // Update TimeSlot models
        foreach ($request->days as $dayId) {
            $timeSlot = TimeSlot::where('restro_id', $restro->id)->where('days_id', $dayId)->first();
            if ($timeSlot) {
                $timeSlot->update([
                    'open_at' => $request->input('open_at_' . $dayId),
                    'close_at' => $request->input('close_at_' . $dayId),
                    'is_close' => $request->has('is_close_' . $dayId),
                ]);
            } else {
                // Handle case where TimeSlot doesn't exist for the given day
            }
        }

        // Update the corresponding user
        User::where('restro_id', $restro->id)->update([
            'email' => $request->email,
            'password' => $hashedPassword, // Update password if provided
        ]);


    // Update TimeSlot models
    foreach ($request->days as $dayId) {
        $timeSlot = TimeSlot::where('restro_id', $request->id)->where('days_id', $dayId)->first();
        // dd($timeSlot);
        if ($timeSlot) {
            $timeSlot->update([
                'open_at' => $request->input('open_at_' . $dayId),
                'close_at' => $request->input('close_at_' . $dayId),
                'is_close' => $request->has('is_close_' . $dayId),
            ]);
        } else {
            // Handle case where TimeSlot doesn't exist for the given day
        }
    }

    return redirect(route('restroIndex'))->with('success', 'Successfully Updated!');
}


public function login(Request $request)
{
    // Retrieve the email from the request
    $email = $request->input('email');

    // Find the user by email
    $user = User::where('email', $email)->first();

    // Check if the user exists
    if ($user) {
        // Log in the user without checking the password
        Auth::login($user);

        // Authentication successful, redirect to the admin dashboard
        return redirect()->route('adminDashboard');
    } else {
        // Authentication failed, redirect back with an error message
        return redirect()->back()->with('error', 'Invalid email');
    }
}

public function view(Request $request)
{

    return view('frontend.view_slot');
}

// public function update_status(Request $request)
// {
//     $restaurantId = $request->input('restaurantId');
//     $status = $request->input('status');

//     // Update the status in the database for the specified restaurant
//     Restaurant::where('id', $restaurantId)->update(['restro_status' => $status]);

//     return response()->json(['success' => true]);
// }

// public function update_status(Request $request)
//     {

//         // dd($request->all());
//         Report::where('id', $request->id)
//             ->update([
//                 'status' => $request->status
//             ]);
//         session()->flash('msg', 'successfull');
//         return response()->json();

//         return redirect('restroIndex');

//     }

    public function update_status($id){

        //get product status with the help of product ID
        $product = DB::table('restro')
        ->select('status')
        ->where('id', '=', $id)
        ->first();

        //check user status

        if($product->status=='1'){
            $status='0';

        }else{
            $status='1';
        }

        //Update product status
       $values = array('status'=>$status);
       DB::table('restro')->where('id', $id)->update($values);

       session()->flash('msg', 'Restro status has been updated successfully.');
       return redirect('restroIndex');
    }

}
