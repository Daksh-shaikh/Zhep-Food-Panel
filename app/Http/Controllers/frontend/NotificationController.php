<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{

    public function index(){

        $notice = Notification::all();

        return view('frontend.notification', compact('notice'));
    }

    public function store(Request $request){
        $request->validate([
            'sent_type'=>'required',
            'title'=>'required',
            'message'=>'required',
            // 'image'=>'required',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('notification/'), $filename);
        }
$notification = new Notification;
$notification -> sent_type = $request -> sent_type;
$notification -> title = $request -> title;
$notification -> message = $request ->message;
$notification -> image = $filename;
$notification ->save();

return redirect(route('notification-index'))->with('success', 'Field Added Successfully');

    }

    public function Edit($id){

        $noticeEdit = Notification::find($id);
        $noticeUpdate = Notification::all();
        $noticeType = $noticeEdit->sent_type; // Assuming sent_type is the attribute you want to pre-fill

        return view('frontend.notification_edit', compact('noticeEdit', 'noticeUpdate', 'noticeType'));

    }

    public function update(Request $request){
        $notice = Notification::find($request->id);
          // Update other properties
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('notification'), $filename);

        // Delete the old image file if it exists
        if ($notice->image) {
            $oldFilePath = public_path('notification') . $notice->image;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // Update the image property with the new file name
        $notice->image = $filename;
    }
          $notice->sent_type = $request->sent_type;
          $notice->title = $request->title;
          $notice->message = $request->message;
          $notice->save();

          return redirect(route('notification-index'))->with('success', 'Field Updated Successfully');
    }

    public function destroy($id){
        $notice = Notification::find($id);

        if($notice){
            $notice->delete();

            return redirect(route('notification-index'))->with('success', 'Notification Deleted Successfully');
        }
        else{
            return redirect(route('notification-index'))->with('error', 'Notification Deleted Successfully');
        }
    }
}
