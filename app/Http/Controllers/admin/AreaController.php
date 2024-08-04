<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function index(){
       $data = Area::all();
        return view('admin.area', compact('data'));
    }

    public function areaStore(Request $request){

        $request->validate([
            'area' => 'required',
        ]);

        $user = auth()->user();
        $restroId = $user->restro_id;

        $area = new Area;
        $area->area= $request -> area;
        $area->restro_id= $restroId;
        $area->save();

        return redirect()->route('area')->with('success', 'Area Added Successfully');
    }

// to update status active or inactive

public function update_area_status($id){

    //get product status with the help of product ID
    $product = DB::table('area')
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
   DB::table('area')->where('id', $id)->update($values);

   session()->flash('msg', 'Area status has been updated successfully.');
   return redirect('area');
}


}
