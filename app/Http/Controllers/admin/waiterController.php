<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Waiter;
use App\Models\User;
use App\Models\WaiterDocuments;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;


class waiterController extends Controller
{
    public function index(){
        $data = Waiter::all();
        return view('admin.waiter', ['data'=>$data]);
    }

    public function waiter_registration(Request $request)
    {

        $hashedPassword = Hash::make($request->input('password'));
        // Assuming you have a Restro model with a relationship to User
        $user = auth()->user(); // Assuming the currently logged-in user is a restro
        $restroId = $user->restro_id;

       $waiter = new waiter;
       $waiter->name=$request->name;
       $waiter->contact=$request->contact;
       $waiter->email=$request->email;
       $waiter->password=$hashedPassword;
       $waiter->restro_id = $restroId; // Set the restro_id
       $waiter->save();

       $waiterUser= new User;
       $waiterUser->waiter_id=$waiter->id;
       $waiterUser->name=$request->name;
       $waiterUser->contact=$request->contact;
       $waiterUser->email=$request->email;
       $waiterUser->password=$hashedPassword;
       $waiterUser->restro_id = $restroId; // Set the restro_id
       $waiterUser->role='waiter';
       $waiterUser->save();


    //    ==============================================
    // Waiter Documents
    $layoutImages = $request->input('document');
    // $layoutImages = $request->input('document');

    foreach ($layoutImages as $uploadedImage) {
        if (is_string($uploadedImage)) {
            // If it's a base64 string, convert it to an image file
            list($type, $uploadedImage) = explode(';', $uploadedImage);
            list(, $uploadedImage) = explode(',', $uploadedImage);
            $uploadedImage = base64_decode($uploadedImage);

            $filename = 'image_' . Str::random(10) . '.png';
            File::put(public_path('waiter/' . $filename), $uploadedImage);

            WaiterDocuments::create([
                'waiter_id' => $waiter->id,
                'document' => 'waiter/' . $filename,
            ]);
        } else {
            // If it's not a base64 string, it's a file path, so just create a record
            WaiterDocuments::create([
                'waiter_id' => $project->id,
                'document' => $uploadedImage,
            ]);
        }
    }



    // ==================================================
       return redirect()->route('waiter_view')->with('success', 'waiter Added Successfully');

    }

    public function waiter_edit($id){
        $waiterEdit = waiter::find($id);
        $waiterAll = waiter::all();
        $layoutImages = WaiterDocuments::where('waiter_id', $waiterEdit->id)->get();
        return view('admin.waiter_edit', [
            'waiterEdit'=>$waiterEdit,
            'waiterAll'=>$waiterAll,
            'layoutImages'=>$layoutImages
        ]);
    }


       // ----------------------------------

        public function waiter_update(Request $request) {
            // Validate the request data if needed
// dd($request->all());
            $hashedPassword = Hash::make($request->input('password'));

            // Retrieve the existing delivery boy instance
            $waiter = Waiter::find($request->id);

            // Update other properties
            $waiter->name = $request->name;
            $waiter->contact = $request->contact;
            $waiter->email = $request->email;

            // Check if a new password is provided
    if ($request->has('password') && !empty($request->input('password'))) {
        $hashedPassword = Hash::make($request->input('password'));
        $waiter->password = $hashedPassword;

        // Update the corresponding user record
        $user = User::where('waiter_id', $waiter->id)->first();
        if ($user) {
            $user->password = $hashedPassword;
            $user->save();
        }
    }

            // Save the changes
            $waiter->save();

            // Update the corresponding user record
            $user = User::where('waiter_id', $waiter->id)->first();
            if ($user) {
                $user->name = $request->input('name');
                $user->contact = $request->input('contact');
                $user->email = $request->input('email');
                $user->password = $hashedPassword;
                $user->save();
            }
        else {
            // Handle the case when no corresponding user is found
            // You can log an error or perform any other necessary action
            // For example:
            \Log::error('User not found for waiter ID: ' . $waiter->id);
        }

// ---------------------------------------------------

$layoutImage = $request->input('document');

// Check if $layoutImage is not null and is an array before looping over it
if (isset($layoutImage) && is_array($layoutImage)) {
    foreach ($layoutImage as $uploadedImage) {
        if (is_string($uploadedImage)) {
            // If it's a base64 string, convert it to an image file
            list($type, $uploadedImage) = explode(';', $uploadedImage);
            list(, $uploadedImage) = explode(',', $uploadedImage);
            $uploadedImage = base64_decode($uploadedImage);

            $filename = 'image_' . Str::random(10) . '.png';
            File::put(public_path('waiter/' . $filename), $uploadedImage);

            WaiterDocuments::create([
                'waiter_id' => $waiter->id,
                'document' => 'waiter/' . $filename,
            ]);
        } else {
            // If it's not a base64 string, it's a file path, so just create a record
            HospitalBannerImages::create([
                'waiter_id' => $waiter->id,
                'document' => $uploadedImage,
            ]);
        }
    }
} else {
    // Handle the case when $bannerImage is null or not an array
    // You can log a message or perform any other action here
}

// ------------------------------------------------------------
            return redirect()->route('waiter_view')->with('success', 'waiter Updated Successfully');
        }



// to update status active or inactive

public function update_waiter_status($id){

    //get product status with the help of product ID
    $product = DB::table('waiter')
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
   DB::table('waiter')->where('id', $id)->update($values);

   session()->flash('msg', 'waiter status has been updated successfully.');
   return redirect('waiter_view');
}


public function deleteImage(Request $request, $id)
{
    try {
        $layoutImage = WaiterDocuments::find($id);

        if (!$layoutImage) {
            return response()->json(['error' => 'Document not found'], 404);
        }

        // Delete the layout image record
        $layoutImage->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error deleting document'], 500);
    }
}



}
