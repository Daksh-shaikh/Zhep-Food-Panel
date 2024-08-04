<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliverySlotTiming;

class DeliverySlotTimingController extends Controller
{
    public function index(){
        $slot=DeliverySlotTiming::all();
        return view('admin.delivery-slots-timing', ['slot' => $slot]);
    }

    public function deliverySlotStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'day' => 'required',
            'shift' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            // Add other validation rules as needed
        ]);

        $slot = new DeliverySlotTiming;
        $slot->day = $request->day;
        $slot->shift = $request->shift;
        $slot->start_time = $request->start_time;
        $slot->end_time = $request->end_time;

       // $event->event_video = $videoName;
        $slot->save();
        return redirect()->route('delivery_slots_timing')->with('success', 'Field Added successfully');
    }

    public function deliverySlotDestroy($id){
        $slot = DeliverySlotTiming::find($id);

        if ($slot) {
            $slot->delete();
            return redirect(route('delivery_slots_timing'))->with('success', 'Field Deleted Successfully');
        } else {
            return redirect(route('delivery_slots_timing'))->with('error', 'Field not found');
        }
    }

    public function deliverySlotEdit($id){
        $deliveryEdit = DeliverySlotTiming::find($id);
        $delivery = DeliverySlotTiming::all();
        return view('admin.delivery-slots-timing_edit', ['deliveryEdit'=>$deliveryEdit, 'delivery'=>$delivery]);
    }



public function deliverySlotUpdate(Request $request)
{

    // dd($request->all());

    $request->validate([
        'day' => 'required',
        'shift' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        // Add other validation rules as needed
    ]);
    // Validation rules
    // $rules = [
    //     'restaurant' => 'required|regex:/^[\pL\s\-]+$/u|max:255|unique:users,name',
    //     'code' => 'required',
    //     'start_from' => 'required|date',
    //     'upto' => 'required|date',
    // ];

    // Custom error messages
   //  $messages = [
   //      'contactNo.digits' => 'The contact number must be exactly 10 digits.',
   //      'contactNo.max' => 'The contact number must not exceed 10 digits.',
   //  ];

    // Validate the request
    // $validator = Validator::make($request->all(), $rules);

    // Check for validation errors
    // if ($validator->fails()) {
    //     return redirect()->route('restroIndex') // Replace 'your.form.route' with the actual route name
    //         ->withErrors($validator)
    //         ->withInput();
    // }



    DeliverySlotTiming::where('id',$request->id)->update([
        'day'=>$request->day,
        'shift'=>$request->shift,
        'start_time'=>$request->start_time,
        'end_time'=>$request->end_time,

        ]
    );


    return redirect(route('delivery_slots_timing'))->with('success','Successfully Updated !');
}

}


