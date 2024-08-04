<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Area;
use Illuminate\Support\Facades\DB;


// QR
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class tableController extends Controller
{
    public function index(){
        $data = Table::all();
        $user = auth()->user(); // Assuming the currently logged-in user is a restro
        $restroId = $user->restro_id;
        $area = Area::where('restro_id', $restroId)->get();
        return view('admin.table', compact('data', 'area'));
    }

    public function tableStore(Request $request){

        // dd($request->all());
        $request->validate([
            'table' => 'required',
        ]);

        // Assuming you have a Restro model with a relationship to User
    $user = auth()->user(); // Assuming the currently logged-in user is a restro
    $restroId = $user->restro_id;

    $table = new Table;
    $table -> table = $request ->table;
    $table -> area_id = $request ->area;
    $table->restro_id = $restroId;
    $table->save();

    return redirect()->route('table')->with('success', 'Field Added successfully.');


    }


// to update status active or inactive

public function update_table_status($id){

    //get product status with the help of product ID
    $product = DB::table('table')
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
   DB::table('table')->where('id', $id)->update($values);

   session()->flash('msg', 'Table status has been updated successfully.');
   return redirect('table');
}



}
