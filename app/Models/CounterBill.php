<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterBill extends Model
{
    use HasFactory;
    protected $table = "counter_bill";

    protected $fillable = [
        'customer_name',
        'contact',
        'discount',
        'total_amount',
        'final_amount',

    ];
}
