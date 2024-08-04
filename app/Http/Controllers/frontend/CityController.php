<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index()
    {
        $city=City::all();

        return view('frontend.city', ['city'=>$city]);

    }


    public function cityStore(Request $request)
    {

           // dd($request->all());
           $data=$request->validate([
            // 'city'=>'required|regex:/^[\pL\s\-]+$/u|max:255|unique:users,name',
            'city'=>'required|regex:/^[\pL\s\-,]+$/u|max:255|unique:city,city',
            'city_alias'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',


        ]);

        $city = City::create($data);


        return redirect(route('city'))->with('success', 'City added successfully');

    }

    public function cityDestroy($id){
        $city = City::find($id);

        if ($city) {
            $city->delete();
            return redirect(route('city'))->with('success', 'Field Deleted Successfully');
        } else {
            return redirect(route('city'))->with('error', 'Field not found');
        }
    }

    public function cityEdit($id){
        $cityEdit=City::find($id);
        $city = City::all();
        return view('frontend.city_edit', ['cityEdit'=>$cityEdit, 'city'=>$city]);
     }

     public function cityUpdate(Request $request)
     {
         // Validation rules
         $rules = [
             'city_alias' => 'required',

         ];

         // Custom error messages
        //  $messages = [
        //      'contactNo.digits' => 'The contact number must be exactly 10 digits.',
        //      'contactNo.max' => 'The contact number must not exceed 10 digits.',
        //  ];

         // Validate the request
         $validator = Validator::make($request->all(), $rules);

         // Check for validation errors
         if ($validator->fails()) {
             return redirect()->route('city') // Replace 'your.form.route' with the actual route name
                 ->withErrors($validator)
                 ->withInput();
         }

         City::where('id',$request->id)->update([
             'city_alias'=>$request->city_alias,

             ]
         );


         return redirect(route('city'))->with(['success' => 'Successfully Updated !']);

     }



// to update status active or inactive

public function update_city_status($id){

    //get product status with the help of product ID
    $product = DB::table('city')
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
   DB::table('city')->where('id', $id)->update($values);

   session()->flash('msg', 'City status has been updated successfully.');
   return redirect('city');
}




}
