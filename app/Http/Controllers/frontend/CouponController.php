<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Restro;
use App\Models\City;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index(){
        $coupon=Coupon::all();
        $restro = Restro::all();
        $city = City::all();

      // Process coupons to include related restaurants
      $coupon->map(function ($coupon) {
        $restroIds = $coupon->restaurant_id;
        if (is_array($restroIds)) {
            $coupon->restros = Restro::whereIn('id', $restroIds)->get();
        } else {
            // Handle cases where restaurant_id is not an array
            $coupon->restros = collect();
        }
        return $coupon;
    });

        return view('frontend.coupon',['coupon'=> $coupon,'restro'=> $restro, 'city'=>$city]);
        // return view('frontend.coupon', ['coupon'=> $coupon]);
    }

    public function couponStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'city' => 'required',
            'restaurant' => 'required',
            'code' => 'required',
            'dstype' => 'required',
            'value' => 'required',
            'start_from' => 'required',
            'upto' => 'required',
            'min_cost' => 'required',

            'description' => 'required',
        ]);

// dd($request->all());
        $filename = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('coupon/'), $filename);
            // $store->image = $filename;
        }

        $data = new Coupon;
        $data->city_id=$request->city;
        $data->restaurant_id=$request->restaurant;
        $data->code=$request->code;
        $data->dstype=$request->dstype;
        $data->value=$request->value;
        $data->start_from=$request->start_from;
        $data->upto=$request->upto;
        $data->min_cost=$request->min_cost;
        $data->description=$request->description;
        $data->image=$filename;

        $data->save();





        return redirect(route('couponIndex'))->with('success', 'Field Added Successfully');
    }

    public function couponDestroy($id){
        $coupon = Coupon::find($id);

        if ($coupon) {
            $coupon->delete();
            return redirect(route('couponIndex'))->with('success', 'Field Deleted Successfully');
        } else {
            return redirect(route('couponIndex'))->with('error', 'Field not found');
        }
    }

    public function couponEdit($id){
        $couponEdit= Coupon::find($id);
        $coupon = Coupon::all();
        $restro = Restro::all();
        $city = City::all();
        return view('frontend.coupon_edit', ['couponEdit'=>$couponEdit, 'coupon'=>$coupon, 'restro'=>$restro, 'city'=>$city]);
    }

    public function couponUpdate(Request $request)
    {
        // Validation rules
        $rules = [
            'city' => 'required',
            'restaurant' => 'required',
            'code' => 'required',
            'start_from' => 'required|date',
            'upto' => 'required|date',
            // 'image'=>'required',
            'description'=>'required',
        ];

        $coupon = Coupon::find($request->id);


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('coupon'), $filename);

            // Delete the old image file if it exists
            if ($coupon->image) {
                $oldFilePath = public_path('coupon') . $coupon->image;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Update the image property with the new file name
            $coupon->image = $filename;
        }

        // Update other properties

        $coupon->city_id=$request->city;
        $coupon->restaurant_id=$request->restaurant;
        $coupon->code=$request->code;
        $coupon->dstype=$request->dstype;
        $coupon->value=$request->value;
        $coupon->start_from=$request->start_from;
        $coupon->upto=$request->upto;
        $coupon->min_cost=$request->min_cost;
        $coupon->description=$request->description;

        // Save the changes
        $coupon->save();

        return redirect(route('couponIndex'))->with('success','Successfully Updated !');
        // return redirect(route('couponIndex'))->with('success', 'Field Added Successfully');
    }



// to update status active or inactive

public function update_coupon_status($id){

    //get product status with the help of product ID
    $product = DB::table('coupon')
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
   DB::table('coupon')->where('id', $id)->update($values);

   session()->flash('msg', 'Menu status has been updated successfully.');
   return redirect('couponIndex');
}

// public function getRestaurantsByCity(Request $request)
// {
//     $cityId = $request->get('city_id');
//     $restaurants = Restro::where('city', $cityId)->get();

//     return response()->json($restaurants);
// }


public function getRestaurantsByCity(Request $request)
{
    $cityId = $request->get('city_id');

    if (empty($cityId) || $cityId === 'All') {
        // Get all restaurants
        $restaurants = Restro::all();
    } else {
        // Get restaurants based on the selected city
        $restaurants = Restro::where('city', $cityId)->get();
    }

    return response()->json($restaurants);
}

public function getAllRestaurants()
{
    $restaurants = Restro::all(); // Fetch all restaurants
    return response()->json($restaurants);
}


}
