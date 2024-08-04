<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $category= Category::all();
        return view('frontend.category', ['category'=> $category]);
    }


    public function categoryStore(Request $request)
    {

        //    dd($request->all());
           $request->validate([
            'category'=>'required|regex:/^[\pL\s\-]+$/u|max:255|unique:category,category', // here category is table name and category is column name.
            // 'type'=>'nullable|array',

        ]);

        // $type = $request->input('type');
        // if ($type !== null && is_array($type)) {
        //     $type = implode(',', $type);
        //     $type = str_replace('"', '', $type); // Remove double quotes
        // }


        $category = new Category;
        $category->category = $request->category;
        // $category->type = $type;
        $category->save();

        return redirect(route('categoryIndex'))->with('success', 'Category added successfully');
    }

    public function categoryDestroy($id){
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return redirect(route('categoryIndex'))->with('success', 'Field Deleted Successfully');
        } else {
            return redirect(route('categoryIndex'))->with('error', 'Field not found');
        }
    }

    public function categoryEdit($id){
        $categoryEdit = Category::find($id);
        $categories = Category::all();
        return view('frontend.category_edit', ['categoryEdit'=>$categoryEdit, 'categories'=>$categories]);
    }
    public function categoryUpdate(Request $request)
    {

        $request->validate([
            'category'=>'required|regex:/^[\pL\s\-]+$/u|max:255|unique:category,category',
            // 'type'=>'nullable|array',

        ]);

		//  $type = $request->input('type');
        // if ($type !== null && is_array($type)) {
        //     $type = implode(',', $type);
        //     $type = str_replace('"', '', $type); // Remove double quotes
        // }
        Category::where('id',$request->id)->update([
            'category'=>$request->category,
            // 'type'=>$type,


            ]
        );


        return redirect(route('categoryIndex'))->with(['success'=>'Successfully Updated !']);
    }


// to update status active or inactive

public function update_category_status($id){

    //get product status with the help of product ID
    $product = DB::table('category')
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
   DB::table('category')->where('id', $id)->update($values);

   session()->flash('msg', 'Category status has been updated successfully.');
   return redirect('categoryIndex');
}


}
