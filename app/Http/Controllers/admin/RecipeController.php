<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class RecipeController extends Controller
{
    public function index(){
        // $recipe = Recipe::all();
        // return view('admin.add-recipe', ['recipe'=>$recipe]);

        $recipes = Recipe::all();
        $category = Category::all();
return view('admin.add-recipe', ['recipes'=>$recipes, 'category'=>$category]);

    }

    public function recipeStore(Request $request)
    {

        //    dd($request->all());
            $request->validate([
            'category'=>'required',
            'recipe'=>'required',
            'price'=>'nullable',
            'food'=>'nullable|array',
            'image'=>'nullable',
            'varient'=>'required',
            'type'=>'nullable|array',
            'description'=>'required',

        ]);
        // $file = $request->file('banner');
        // $filename = time() . '.' . $file->getClientOriginalExtension();
        // $file->move(public_path('banner/'), $filename);
// dd($request->all());
        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('recipe/'), $filename);
        }


        $food = $request->input('food');
        if ($food !== null && is_array($food)) {
            $food = implode(',', $food);
            $food = str_replace('"', '', $food); // Remove double quotes
        }



$type = $request->input('type');
if ($type !== null && is_array($type)) {
    $type = implode(',', $type);
    $type = str_replace('"', '', $type); // Remove double quotes
}


        // $food = implode(',', $request->input('food'));

        // to allow food nullable
        // $food = $request->input('food');
        // if ($food !== null && is_array($food)) {
        //     $food = implode(',', $food);
        // }

        // Fetch restaurant_id and city_id from the authenticated user
        $user = auth()->user();

        $restaurant_id = $user->restro_id; // Assuming 'restro_id' is the foreign key in the User model
        // $city_id = auth()->user()->restro->city;
// Check if the user has a related restro record
$city_id = $user->restro ? $user->restro->city : null;

if (is_null($city_id)) {
    session()->flash('error', 'Restaurant city not found.');
    return redirect(route('add_recipe'));
}

        $data = [
            'image' => $filename,
            'category_id' => $request->input('category'),
            'restaurant_id' => $restaurant_id,
            'city_id' => $city_id,
            'recipe' => $request->input('recipe'),
            'price' => $request->input('price'),
            'varient'=>$request->input('varient'),
            'igst'=>$request->input('igst'),
            'cgst'=>$request->input('gst')/2,
            'sgst'=>$request->input('gst')/2,
            'description' => $request->input('description'),
            'food' => $food,
            'type'=> $type,

        ];

        $recipe = Recipe::create($data);


        return redirect(route('add_recipe'))->with('success', 'Field Added Successfully');
    }

    public function recipeDestroy($id){
        $recipe = Recipe::find($id);

        if ($recipe) {
            $recipe->delete();
            return redirect(route('add_recipe'))->with('success', 'Field Deleted Successfully');
        } else {
            return redirect(route('add_recipe'))->with('error', 'Field not found');
        }
    }


    public function recipeEdit($id, Request $request){

        // dd($request->all());

        $recipeEdit= Recipe::find($id);
        $recipeAll  = Recipe::all();

        $category = Category::all();


        return view('admin.add-recipe_edit', ['recipeEdit'=>$recipeEdit, 'recipeAll'=>$recipeAll, 'category'=>$category]);
    }


public function recipeUpdate(Request $request)
{


    $request->validate([
        'category'=>'required',
        'recipe'=>'required',
        'price'=>'nullable',
        'image'=>'nullable',
        'description'=>'required',

    ]);


    $food = $request->input('food');
    if ($food !== null && is_array($food)) {
        $food = implode(',', $food);
        $food = str_replace('"', '', $food); // Remove double quotes
    }



$type = $request->input('type');
if ($type !== null && is_array($type)) {
$type = implode(',', $type);
$type = str_replace('"', '', $type); // Remove double quotes
}


    $recipe = Recipe::find($request->id);


    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('recipe'), $filename);

        // Delete the old image file if it exists
        if ($recipe->image) {
            $oldFilePath = public_path('recipe') . $recipe->image;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // Update the image property with the new file name
        $recipe->image = $filename;
    }

        $recipe->category_id=$request->category;
        $recipe->recipe=$request->recipe;
        $recipe->price=$request->price;
        $recipe->food= $food;
        $recipe->type= $type;
        $recipe->varient=$request->varient;
        $recipe->igst=$request->igst;
        $recipe->cgst=$request->cgst;
        $recipe->sgst=$request->sgst;
        $recipe->description=$request->description;
        // $recipe->category=$request->category;
        $recipe->save();


    // Recipe::where('id',$request->id)->update([
    //     'category_id'=>$request->category,
    //     'recipe'=>$request->recipe,
    //     'price'=>$request->price,
    //     'description'=>$request->description,
    //     'image'=>$filename,
    //     ]
    // );


    return redirect(route('add_recipe'))->with('success','Successfully Updated !');
}


// to update status active or inactive

public function update_recipe_status($id){

    //get product status with the help of product ID
    $product = DB::table('recipe')
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
   DB::table('recipe')->where('id', $id)->update($values);

   session()->flash('msg', 'Recipe status has been updated successfully.');
   return redirect('add_recipe');
}


}
