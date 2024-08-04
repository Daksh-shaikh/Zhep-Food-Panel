<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBoy extends Model
{
    use HasFactory;
    protected $table = "delivery_boy";
    protected $fillable = [
        'first_name',
        'last_name',
        'primary_contact',
        'secondary_contact',
        'email',
        'password',
        'city_id',
        'address',
        'residential_city',
        'latitude',
        'longitude',
        'account_number',
        'aadhar_number',
        'driving_license_number',
        'documents',
        'user_id',

    ];

    public function city_name()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function restro_name()
    {
        return $this->hasOne(Restro::class, 'id', 'restro_id');
    }


}
