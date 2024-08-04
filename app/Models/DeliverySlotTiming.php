<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySlotTiming extends Model
{
    use HasFactory;
    protected $table = "delivery_slot";

    protected $fillable = [
        'day',
        'shift',
        'start_time',
        'end_time',
    ];
}
