<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = "cart";

    protected $fillable = [
        'user_id',
        'order_id',
        'recipe_id',
        'restro_id',
        'coupon_code_id',
        'recipe_name',
        'recipe_price',
        'quantity',
        'varient',
        'status',
        'type',
		'recipe_status',
		'table_id',

    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
