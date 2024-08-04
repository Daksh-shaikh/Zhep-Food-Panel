<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table = "banner";

    protected $fillable = [
        'banner',
        'city',
        'status',

    ];
    public function city_name()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }
}
