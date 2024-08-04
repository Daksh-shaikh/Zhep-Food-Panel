<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterBillItems extends Model
{
    use HasFactory;
    protected $table = "counter_bill_items";

    protected $fillable = [
        'counter_bill_id',
        'item_id',
        'item',
        'quantity',
        'price_id',
        'price',
        'total',

    ];
}
