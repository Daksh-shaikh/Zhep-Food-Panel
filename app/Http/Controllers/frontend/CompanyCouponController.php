<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyCoupon;
use App\Models\Restro;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CompanyCouponController extends Controller
{
    public function index(){
        $coupon=CompanyCoupon::all();
        $restro = Restro::all();

        return view('frontend.company_coupon',['coupon'=> $coupon,'restro'=> $restro]);
        // return view('frontend.coupon', ['coupon'=> $coupon]);
    }

    public function companyCouponStore(Request $request)
    {
        // dd($request->all());
        $request->validate([

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

        $data = new CompanyCoupon;
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



        // $coupon = CompanyCoupon::create($data);

        return redirect(route('companyCouponIndex'))->with('success', 'Field Added Successfully');
    }

    public function companyCouponDestroy($id){
        $coupon = CompanyCoupon::find($id);

        if ($coupon) {
            $coupon->delete();
            return redirect(route('companyCouponIndex'))->with('success', 'Field Deleted Successfully');
        } else {
            return redirect(route('companyCouponIndex'))->with('error', 'Field not found');
        }
    }

    public function companyCouponEdit($id){
        $couponEdit= CompanyCoupon::find($id);
        $coupon = CompanyCoupon::all();
        $restro = Restro::all();
        return view('frontend.company_coupon_edit', ['couponEdit'=>$couponEdit, 'coupon'=>$coupon, 'restro'=>$restro]);
    }

    public function companyCouponUpdate(Request $request)
    {
        // Validation rules
        $rules = [
            'restaurant' => 'required',
            'code' => 'required',
            'start_from' => 'required|date',
            'upto' => 'required|date',
            // 'image'=>'required',
            'description'=>'required',
        ];


        $validator = Validator::make($request->all(), $rules);

        // Check for validation errors
        $coupon = CompanyCoupon::find($request->id);


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('coupon'), $filename);

            // Delete the old image file if it exists
            if ($coupon->image) {
                $oldFilePath = public_path('coupon') . $pharmacy->image;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Update the image property with the new file name
            $coupon->image = $filename;
        }

        // Update other properties
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



        return redirect(route('companyCouponIndex'))->with('success','Successfully Updated !');
        // return redirect(route('companyCouponIndex'))->with('success', 'Field Added Successfully');
    }



// to update status active or inactive

public function update_company_coupon_status($id){

    //get product status with the help of product ID
    $product = DB::table('company_coupon')
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
   DB::table('company_coupon')->where('id', $id)->update($values);

   session()->flash('msg', 'Menu status has been updated successfully.');
   return redirect('companyCouponIndex');
}

}
