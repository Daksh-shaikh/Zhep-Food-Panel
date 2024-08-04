<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\City;

use Illuminate\Support\Facades\DB;


class BannerController extends Controller
{
    public function index()
    {
        $banner=Banner::all();
        $city = City::all();
        return view('frontend.banner', ['banner'=>$banner, 'city'=>$city]);
    }

    public function bannerStore(Request $request)
    {
        // dd($request->all());

        // Handle file attachment if provided

        // Validate the request
        //  $request->validate([
        // 'banner' => 'required|image|mimes:jpeg,png,jpg,gif',
        // |dimensions:width=900,height=400',
    // ]);

        $file = null;

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('banner/'), $filename);
            // $store->image = $filename;
        }



            $banner = new Banner;
            $banner ->city = $request->city;
            $banner -> banner=$filename;
            $banner->save();

        return redirect()->route('bannerIndex');
    }
    public function bannerDestroy($id){
        $banner = Banner::find($id);

        if ($banner) {
            $banner->delete();
            return redirect(route('bannerIndex'))->with('success', 'Field Deleted Successfully');
        } else {
            return redirect(route('bannerIndex'))->with('error', 'Field not found');
        }
    }

    public function bannerEdit($id){
        $bannerEdit = Banner::find($id);
        $banners = Banner::all();
        return view('frontend.banner_edit', ['bannerEdit'=> $bannerEdit, 'banners'=>$banners]);
    }


    public function bannerUpdate(Request $request)
    {
        // echo json_encode($request->all());
        // exit();
        $request->validate([
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:width=900,height=400',
        ]);

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('banner/'), $filename);
         }
        Banner::where('id', $request->id)->update([
            'banner'=>$filename,
        ]
    );
    return redirect()->route('bannerIndex')->with(['success'=>true,'message'=>'Successfully Updated !']);

    }


// to update status active or inactive

public function update_banner_status($id){

    //get product status with the help of product ID
    $product = DB::table('banner')
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
   DB::table('banner')->where('id', $id)->update($values);

   session()->flash('msg', 'Banner status has been updated successfully.');
   return redirect('bannerIndex');
}


}
