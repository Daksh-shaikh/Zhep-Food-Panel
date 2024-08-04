<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kitchen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class KitchenController extends Controller
{
    public function index(){
        $data = Kitchen::all();
        return view('admin.kitchen_registration', ['data'=>$data]);
    }

    public function kitchen_registration(Request $request)
{

    $hashedPassword = Hash::make($request->input('password'));
    // Assuming you have a Restro model with a relationship to User
    $user = auth()->user(); // Assuming the currently logged-in user is a restro
    $restroId = $user->restro_id;

   $kitchen = new Kitchen;
   $kitchen->name=$request->name;
   $kitchen->contact=$request->contact;
   $kitchen->email=$request->email;
   $kitchen->password=$hashedPassword;
   $kitchen->restro_id = $restroId; // Set the restro_id
   $kitchen->save();

   $kitchenUser= new User;
   $kitchenUser->kitchen_id=$kitchen->id;
   $kitchenUser->name=$request->name;
   $kitchenUser->contact=$request->contact;
   $kitchenUser->email=$request->email;
   $kitchenUser->password=$hashedPassword;
   $kitchenUser->restro_id = $restroId; // Set the restro_id
   $kitchenUser->role='kitchen';
   $kitchenUser->save();
   return redirect()->route('kitchen')->with('success', 'Kitchen Added Successfully');

}

public function kitchen_edit($id){
    $kitchenEdit = Kitchen::find($id);
    $kitchenAll = Kitchen::all();
    return view('admin.kitchen-edit', [
        'kitchenEdit'=>$kitchenEdit,
        'kitchenAll'=>$kitchenAll,
    ]);
}





// public function kitchen_update(Request $request){

//     $kitchenUpdate = Kitchen::find($request->id);

//     // Check if Kitchen record is found
//     if (!$kitchenUpdate) {
//         return redirect()->route('kitchen')->with('error', 'Kitchen not found');
//     }

//     // Update other fields
//     $kitchenUpdate->name = $request->name;
//     $kitchenUpdate->contact = $request->contact;
//     $kitchenUpdate->email = $request->email;

//     // Save the changes to Kitchen
//     $kitchenUpdate->save();

//     // Update the corresponding user record
//     $user = User::where('email', $request->input('email'))->first();

//     if ($user) {
//         // Update user fields only if a new password is provided
//         if ($request->filled('password')) {
//             $hashedPassword = Hash::make($request->input('password'));
//             $user->password = $hashedPassword;
//             $user->save();
//         }
//     }

//     return redirect()->route('kitchen')->with('success', 'Kitchen Updated Successfully');
// }

public function kitchen_update(Request $request) {
    // Validate the request data if needed

    $hashedPassword = Hash::make($request->input('password'));

    // Retrieve the existing kitchen boy instance
    $kitchen = Kitchen::find($request->id);
    // $kitchen = kitchenBoy::all();

    // // Handle file upload if a new document is provided
    // if ($request->hasFile('documents')) {
    //     $file = $request->file('documents');
    //     $documentsFileName = time() . '.' . $file->getClientOriginalExtension();
    //     $file->move(public_path('documents/'), $documentsFileName);

    //     // Update the document property
    //     $kitchen->documents = $documentsFileName;



    // Update other properties
    $kitchen->name = $request->name;
    $kitchen->contact = $request->contact;
    $kitchen->email = $request->email;

    // Check if a new password is provided
if ($request->has('password') && !empty($request->input('password'))) {
$hashedPassword = Hash::make($request->input('password'));
$kitchen->password = $hashedPassword;

// Update the corresponding user record
$user = User::where('email', $request->input('email'))->first();
if ($user) {
    $user->password = $hashedPassword;
    $user->save();
}
}

    // Save the changes
    $kitchen->save();

    // Update the corresponding user record
    $user = User::where('kitchen_id', $kitchen->id)->first();
    if ($user) {
        $user->name = $request->input('name');
        $user->contact = $request->input('contact');
        $user->email = $request->input('email');
        $user->password = $hashedPassword;
        $user->save();
    }

    return redirect()->route('kitchen')->with('success', 'Kitchen Updated Successfully');
}



// to update status active or inactive

public function update_kitchen_status($id){

    //get product status with the help of product ID
    $product = DB::table('kitchen')
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
   DB::table('kitchen')->where('id', $id)->update($values);

   session()->flash('msg', 'kitchen status has been updated successfully.');
   return redirect('kitchen');
}



}
