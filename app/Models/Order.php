<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "order";

    protected $fillable = [
        'order_id2',
        'user_id',
        'customer_name',
		'waiter_id',
        'restro_id',
		'table_id',
        'order_date',
        // 'recipe_price',
        'contact_number',
        'address',
        'total',
        'discount',
        'final_total',
        'payment_mode',
        'delivery_type',
        'coupon_code',
        'status',
		'restro_status',
		'delivery_status',
		'kitchen_status',
		'waiter_status',
        'longitude',
        'latitude',
		'type',
		'paymentId',
		'delivery_boy_id',
        'gst',
'order_id2',
        'user_id',
        'customer_name',
		'waiter_id',
        'restro_id',
		'table_id',
        'order_date',
        // 'recipe_price',
        'contact_number',
        'address',
        'total',
        'discount',
        'final_total',
        'payment_mode',
        'delivery_type',
        'coupon_code',
        'status',
		'restro_status',
		'delivery_status',
		'kitchen_status',
		'waiter_status',
        'longitude',
        'latitude',
		'type',
		'paymentId',
		'delivery_boy_id',
        'gst',
		'cooking_instruction',
    ];

	   public function carts()
    {
        return $this->hasMany(Cart::class, 'order_id', 'id');
    }
	 public function deliveryAddress()
    {
        return $this->belongsTo(DeliveryAddress::class, 'user_id', 'user_id');
    }

	  public function restro()
    {
        return $this->hasOne(Restro::class, 'id', 'restro_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');

    }

	public function table()
    {
        return $this->belongsTo(Table::class);
    }

// total gst in rs
//     public function calculateTotalGst()
// {
//     $totalPriceWithoutGst = 0;
//     $totalPriceWithGst = 0;

//     // Iterate through the carts of the current order
//     foreach ($this->carts as $cart) {
//         $recipe = $cart->recipe;
//         if ($recipe) {
//             // Calculate the total price for the current recipe (excluding GST)
//             $recipeTotalPriceWithGst = $cart->quantity * $recipe->price;
//             $recipeGstPercentage = ($recipe->igst + $recipe->cgst + $recipe->sgst);

//             // Calculate the price without GST for the current recipe
//             if ($recipeGstPercentage != 0) {
//                 $priceWithoutGst = $recipeTotalPriceWithGst / (1 + $recipeGstPercentage / 100);
//             } else {
//                 $priceWithoutGst = $recipeTotalPriceWithGst;
//             }

//             // Accumulate the total prices
//             $totalPriceWithoutGst += $priceWithoutGst;
//             $totalPriceWithGst += $recipeTotalPriceWithGst;
//         }
//     }

//     // Calculate the total GST
//     $totalGst = $totalPriceWithGst - $totalPriceWithoutGst;

//     return $totalGst;
// }


// total gst in percent and Rs
// Order.php (assuming this is your Order model)

public function calculateTotalGst()
{
    $totalPriceWithoutGst = 0;
    $totalPriceWithGst = 0;

    // Iterate through the carts of the current order
    foreach ($this->carts as $cart) {
        $recipe = $cart->recipe;
        if ($recipe) {
            // Calculate the total price for the current recipe (excluding GST)
            $recipeTotalPriceWithGst = $cart->quantity * $recipe->price;
            $recipeGstPercentage = ($recipe->igst + $recipe->cgst + $recipe->sgst);

            // Calculate the price without GST for the current recipe
            if ($recipeGstPercentage != 0) {
                $priceWithoutGst = $recipeTotalPriceWithGst / (1 + $recipeGstPercentage / 100);
            } else {
                $priceWithoutGst = $recipeTotalPriceWithGst;
            }

            // Accumulate the total prices
            $totalPriceWithoutGst += $priceWithoutGst;
            $totalPriceWithGst += $recipeTotalPriceWithGst;
        }
    }

    // Calculate the total GST percentage
    $totalGstPercent = 0;
    if ($totalPriceWithGst != 0) {
        $totalGstPercent = (($totalPriceWithGst - $totalPriceWithoutGst) / $totalPriceWithoutGst) * 100;
    }

    $gstAmount = ($totalGstPercent / 100) * $totalPriceWithGst;

    return $gstAmount;
}

}
