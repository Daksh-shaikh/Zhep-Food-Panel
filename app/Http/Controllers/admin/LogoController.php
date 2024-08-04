<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;

class LogoController extends Controller
{
    public function index(){
        return view('admin.logo');
    }

    public function updateLogo(Request $request)
    {
        $restro_id = auth()->user()->restro_id;

        if ($request->hasFile('logo')) {
            // Handle file upload
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('logo/'), $filename);

            // Update existing logo if it exists
            $logo = Logo::where('restro_id', $restro_id)->first();
            if ($logo) {
                $logo->update([
                    'logo' => $filename,
                ]);
            } else {
                // Create new logo record if it doesn't exist
                Logo::create([
                    'logo' => $filename,
                    'restro_id' => $restro_id,
                ]);
            }

            return redirect()->route('add-logo')->with(['success' => true, 'message' => 'Logo updated successfully!']);
        }

        // Handle case where no file is uploaded
        return redirect()->route('add-logo')->with(['error' => true, 'message' => 'No file uploaded.']);
    }

}
