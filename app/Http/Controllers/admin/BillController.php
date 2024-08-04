<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\CounterBill;
use App\Models\CounterBillItems;
use App\Models\User;
use App\Models\Restro;
use App\Models\Logo;

use Illuminate\Support\Facades\Auth;



class BillController extends Controller
{
    public function index(){
        return view('admin.bill');
    }

    public function counterBill()
{
    // Retrieve all necessary data
    $order = Order::all();
    $recipes = Recipe::all();
    $category = Category::all();
    $cart = Cart::all();
    $restro_id = auth()->user()->restro_id;
    $logo = Logo::where('restro_id', $restro_id);

    // Get authenticated user ID
    $restroId = auth()->user()->restro_id;

    // Fetch the Restro instance for the authenticated user
    $restro = Restro::where('id', $restroId)->first();

    // Check if the Restro instance exists
    if ($restro) {
        // Decode the category array
        $categoryIds = json_decode($restro->category);

        // Fetch the category names
        $categories = Category::whereIn('id', $categoryIds)->pluck('category', 'id');

        // Replace the category IDs with their names
        $categoryNames = [];
        foreach ($categoryIds as $categoryId) {
            if (isset($categories[$categoryId])) {
                $categoryNames[] = $categories[$categoryId];
            }
        }

    } else {
        echo "No restaurant found for the authenticated user.";
    }

    // Return the view with all necessary data
    return view('admin.generate_bill', [
        'recipes' => $recipes,
        'category' => $category,
        'cart' => $cart,
        'order' => $order,
        'restro' => $restro,
        'categoryNames' => $categoryNames, // Pass the category names to the view
        'logo'=> $logo,
    ]);
}


public function counterBillStore(Request $request){
    // dd($request->all());

    $restroId = auth::user()->restro_id;
    $bill = new Order;
    $bill->order_id2 = 'OD'.time();
    $bill->restro_id = $restroId;
    $bill->customer_name=$request->customer_name;
    $bill->contact_number=$request->contact;
    $bill->total=$request->total_amount;
    $bill->discount=$request->discount;
    $bill->final_total=$request->final_amount;
    $bill->type = 'Takeaways';
    $bill->status = 'Order Completed';

    $bill->save();

  // Items
  $items = $request->input('items', []);
  $quantities = $request->input('quantities', []);
  $prices = $request->input('prices', []);
  $totals = $request->input('totals', []);

  foreach ($items as $key => $itemId) {
    // Fetch the item name using the item_id
    $recipe = Recipe::find($itemId);
    $itemName = $recipe ? $recipe->recipe : '';

  foreach ($items as $key => $item) {
      CounterBillItems::create([
          'counter_bill_id' => $bill->id,
          'item_id' => $item,
          'item'=>$itemName,
          'quantity' => $quantities[$key],
          'price' => $prices[$key],
          'total' => $totals[$key],
      ]);
  }

// Items End

        return redirect()->route('show-counter-bill', ['bill'=>$bill->id])->with ('success', 'Bill Added Successfully');
    }
}

public function showCounterBill($id) {
    $bill = Order::find($id);
    $billItems = CounterBillItems::where('counter_bill_id', $id)->get();

    $restro_id = auth()->user()->restro_id; // Assuming this retrieves the restaurant ID of the authenticated user
    $logo = Logo::where('restro_id', $restro_id)->first(); // Retrieve the logo for the restaurant
    $user = User::all();
    return view('admin.counter-bill', compact('bill', 'billItems', 'user', 'logo'));
}

public function getRecipesByCategory2($categoryId)
{

    $category = Category::where('category', $categoryId)->select('id');
    dd($category->id);
    $recipes = Recipe::where('category_id', $category->id)->get();
    return response()->json($recipes);
}

public function getRecipesByCategory($categoryId)
{
    // Find the category by the provided category name (assuming 'category' is the column name in Category table)
    $category = Category::where('category', $categoryId)->first();

    // Check if the category was found
    if ($category) {
        $categoryId = $category->id;
        $restroId = auth()->user()->restro_id;
        // Fetch recipes based on the category ID
        $recipes = Recipe::where('restaurant_id', $restroId)
                         ->where('category_id', $categoryId)
                         ->get();
        return response()->json($recipes);
    } else {
        // Return an empty array or an appropriate response if no category is found
        return response()->json([]);
    }
}

public function getAllRecipes()
{
    $recipes = Recipe::all();
    return response()->json($recipes);
}


}
