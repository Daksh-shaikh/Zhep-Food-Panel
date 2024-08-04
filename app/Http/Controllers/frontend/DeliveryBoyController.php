<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryBoy;
use App\Models\City;
use App\Models\Restro;
use App\Models\User;
use App\Models\DeliveryBoyDocuments;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;


class DeliveryBoyController extends Controller
{
    public function index(){
        $delivery = DeliveryBoy::all();
        $city = City::all();
        $restro = Restro::all();

        return view('frontend.delivery_boy', ['delivery'=>$delivery, 'city'=>$city, 'restro'=>$restro]);
    }



    public function store_delivery_boy(Request $request){
        // dd($request->all());

        $hashedPassword = Hash::make($request->input('password'));


        $documents = null;
        if ($request->hasFile('documents')) {
            $file = $request->file('documents');
            $documentsFileName  = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('documents/'), $documentsFileName );
        }


                 // Create a corresponding user record
                 $user = User::create([
                    // 'restro_id' => $request->input('restaurant'), // You may adjust the name field as needed
                    // 'delivery_boy_id'=>$delivery->id,
                    // 'delivery_boy_id' => $delivery->id,
                    'name'=>$request->input('first_name'),
                    'email' => $request->input('email'),
                    'contact'=>$request->input('primary_contact'),
                    'password' => $hashedPassword,
                    'role'=>'delivery',
                    // ... other fields as needed
                ]);

    // Create a new DeliveryBoy instance

        $delivery = new DeliveryBoy;
        $delivery -> first_name=$request->first_name;
        $delivery -> last_name=$request->last_name;
        $delivery -> primary_contact=$request->primary_contact;
        $delivery -> secondary_contact=$request->secondary_contact;
        $delivery->email=$request->email;
        $delivery->password=$hashedPassword;
        $delivery->city_id=$request->city;
        // $delivery->restro_id=$request->restaurant;
        $delivery->address=$request->address;
        $delivery->residential_city=$request->residential_city;
        $delivery->latitude=$request->latitude;
        $delivery->longitude=$request->longitude;
        // $delivery->account_number=$request->account_number;
        $delivery->aadhar_number=$request->aadhar_number;
        $delivery->driving_license_number=$request->driving_license_number;
        // $delivery->documents=$documentsFileName;
        $delivery->user_id = $user->id; // Store the user ID


        $delivery->save();


        // document---------------------------



        $layoutImages = $request->input('layout_image');
        // $layoutImages = $request->input('layout_image');

        foreach ($layoutImages as $uploadedImage) {
            if (is_string($uploadedImage)) {
                // If it's a base64 string, convert it to an image file
                list($type, $uploadedImage) = explode(';', $uploadedImage);
                list(, $uploadedImage) = explode(',', $uploadedImage);
                $uploadedImage = base64_decode($uploadedImage);

                $filename = 'image_' . Str::random(10) . '.png';
                File::put(public_path('images/' . $filename), $uploadedImage);

                DeliveryBoyDocuments::create([
                    'delivery_boy_id' => $delivery->id,
                    'layout_image' => 'images/' . $filename,
                ]);
            } else {
                // If it's not a base64 string, it's a file path, so just create a record
                DeliveryBoyDocuments::create([
                    'delivery_boy_id' => $project->id,
                    'layout_image' => $uploadedImage,
                ]);
            }
        }


        // --------------------------


        // dd($delivery->id);

        return redirect()->route('delivery_boy')->with('success', 'Delivery Boy Added Successfully');
    }

    // ----------------------------------

    public function edit_delivery_boy($id){
        $deliveryEdit = DeliveryBoy::find($id);
        $deliveryAll = DeliveryBoy::all();
        $city = City::all();
        $layoutImages = DeliveryBoyDocuments::where('delivery_boy_id', $deliveryEdit->id)->get();


        return view('frontend.delivery_boy_edit', ['deliveryEdit'=>$deliveryEdit, 'deliveryAll'=>$deliveryAll, 'city'=>$city,
    'layoutImages'=>$layoutImages ]);
    }

        public function update_delivery_boy(Request $request) {
            // Validate the request data if needed
// dd($request->all());
            $hashedPassword = Hash::make($request->input('password'));

            // Retrieve the existing delivery boy instance
            $delivery = DeliveryBoy::find($request->id);

            // Update other properties
            $delivery->first_name = $request->first_name;
            $delivery->last_name = $request->last_name;
            $delivery->primary_contact = $request->primary_contact;
            $delivery->secondary_contact = $request->secondary_contact;
            $delivery->email = $request->email;
            // $delivery->password=$hashedPassword;
            $delivery->residential_city = $request->residential_city;
            $delivery->address = $request->address;
            $delivery->city_id = $request->city;
            $delivery->latitude = $request->latitude;
            $delivery->longitude = $request->longitude;
            // $delivery->account_number = $request->account_number;
            $delivery->aadhar_number = $request->aadhar_number;
            $delivery->driving_license_number = $request->driving_license_number;

            // Check if a new password is provided
    if ($request->has('password') && !empty($request->input('password'))) {
        $hashedPassword = Hash::make($request->input('password'));
        $delivery->password = $hashedPassword;

        // Update the corresponding user record
        $user = User::where('delivery_boy_id', $delivery->id)->first();
        if ($user) {
            $user->password = $hashedPassword;
            $user->save();
        }
    }

            // Save the changes
            $delivery->save();

            // Update the corresponding user record
            $user = User::where('delivery_boy_id', $delivery->id)->first();
            if ($user) {
                $user->name = $request->input('first_name');
                $user->contact = $request->input('primary_contact');
                $user->email = $request->input('email');
                $user->password = $hashedPassword;
                $user->save();
            }

// ---------------------------------------------------

$layoutImage = $request->input('layout_image');

// Check if $layoutImage is not null and is an array before looping over it
if (isset($layoutImage) && is_array($layoutImage)) {
    foreach ($layoutImage as $uploadedImage) {
        if (is_string($uploadedImage)) {
            // If it's a base64 string, convert it to an image file
            list($type, $uploadedImage) = explode(';', $uploadedImage);
            list(, $uploadedImage) = explode(',', $uploadedImage);
            $uploadedImage = base64_decode($uploadedImage);

            $filename = 'image_' . Str::random(10) . '.png';
            File::put(public_path('images/' . $filename), $uploadedImage);

            DeliveryBoyDocuments::create([
                'delivery_boy_id' => $delivery->id,
                'layout_image' => 'images/' . $filename,
            ]);
        } else {
            // If it's not a base64 string, it's a file path, so just create a record
            HospitalBannerImages::create([
                'delivery_boy_id' => $delivery->id,
                'layout_image' => $uploadedImage,
            ]);
        }
    }
} else {
    // Handle the case when $bannerImage is null or not an array
    // You can log a message or perform any other action here
}

// ------------------------------------------------------------
            return redirect()->route('delivery_boy')->with('success', 'Delivery Boy Updated Successfully');
        }



        public function deleteImage(Request $request, $id)
{
    try {
        $layoutImage = DeliveryBoyDocuments::find($id);

        if (!$layoutImage) {
            return response()->json(['error' => 'layout image not found'], 404);
        }

        // Delete the layout image record
        $layoutImage->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error deleting Document'], 500);
    }
}



// to update status active or inactive

public function update_delivery_boy_status($id){

    //get product status with the help of product ID
    $product = DB::table('delivery_boy')
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
   DB::table('delivery_boy')->where('id', $id)->update($values);

   session()->flash('msg', 'Delivery Boy status has been updated successfully.');
   return redirect('delivery_boy');
}


}
