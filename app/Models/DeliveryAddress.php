<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $table = "delivery_address";

    protected $fillable = [
        'user_id',
        'address_type',
        'contact_number',
        'full_name',
        'landmark',
        'house_number',
        'address',
    ];
}
