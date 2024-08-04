<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gst;

class GstController extends Controller
{
    public function index(){
        $igst = Gst::where('type', 'igst')->first();
        if (!$igst) {
            // If no IGST record found, create a new one
            $igst = new Gst();
        }
        $cgst = Gst::where('type', 'cgst')->first();
        if (!$cgst) {
            // If no IGST record found, create a new one
            $cgst = new Gst();
        }
        $sgst = Gst::where('type', 'sgst')->first();
        if (!$sgst) {
            // If no IGST record found, create a new one
            $sgst = new Gst();
        }
        return view('frontend.GST', compact('igst', 'cgst', 'sgst'));
}



    public function gstStore(Request $request)
    {

        //    dd($request->all());
        //    $data=$request->validate([
        //     'tax'=>'required',
        //     'dstype'=>'required',
        //     'value'=>'required',

        // ]);


        $gst = Gst::updateOrCreate(
            ['type' => $request->type],
            ['dstype' => $request->dstype, 'value' => $request->value]
        );
        return redirect(route('gstIndex'))->with('success', 'GST updated successfully');

    }

}
