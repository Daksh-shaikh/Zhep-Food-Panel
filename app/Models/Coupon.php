<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = "coupon";

    protected $fillable = [
        'city_id',
        'restaurant_id',
        'code',
        'dstype',
        'value',
        'start_from',
        'upto',
        'min_cost',
        'image',
        'description',
        'status',


    ];

    protected $casts = [
        'restaurant_id' => 'array',
    ];


    public function restaurant_name()
    {
        return $this->hasOne(Restro::class, 'id', 'restaurant_id');
    }


    public function city_name()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

}
