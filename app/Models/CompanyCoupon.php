<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCoupon extends Model
{
    use HasFactory;
    protected $table = "company_coupon";

    protected $fillable = [
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


    public function restaurant_name()
    {
        return $this->hasOne(Restro::class, 'id', 'restaurant_id');
    }

}
