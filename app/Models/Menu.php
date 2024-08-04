<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = "recipe";

    protected $fillable = [
        'city_id',
        'restaurant_id',
        'category_id',
        'recipe',
        'price',
        'food',
        'image',
        'varient',
        'igst',
        'cgst',
        'sgst',
        'description',
        'type',
        'status',
    ];

    public function city_name()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function restaurant_name()
    {
        return $this->hasOne(Restro::class, 'id', 'restaurant_id');
    }

    public function category_name()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
