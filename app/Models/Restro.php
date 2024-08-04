<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Category;


class Restro extends Model
{
    use HasFactory;
    protected $table = "restro";

    protected $fillable = [
        'city',
        'city_alias',
        'restaurant',
        'address',
        'latitude',
        'longitude',
        'contact_person',
        'mobilenumber',
        'email',
        'password',
        'avg_cooking_time',
        'banner',
        'category',
        'food',
        'service_charges_type',
        'service_charges_value',
        'details',
        'type',
        'status',

    ];

    protected $casts = [
        'category' => 'array',
    ];


    // id is the column of city table and city is the field of restro table
    public function city_name()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

// in belongs to many relationship
        // public function category_name(): BelongsToMany
        // {
        //     return $this->belongsToMany(Category::class, 'category_restro', 'category', 'restro');
        // }

        // public function category_name(): BelongsToMany
        // {
        //     return $this->belongsToMany(Category::class, 'category_restro', 'restro', 'category');
        // }

        public function category_names(){
            return $this->hasMany(Category::class, 'id', 'category');
        }


        public function days()
        {
            return $this->belongsToMany(Days::class, 'time_slots', 'restro_id', 'days_id')
                ->using(TimeSlot::class)
                ->withPivot(['open_at', 'close_at', 'is_close']);
        }

        public function timeSlots()
{
    return $this->hasMany(TimeSlot::class, 'restro_id', 'id');
}

// public function user()
// {
//     return $this->belongsTo(User::class, 'restro_id', 'id');
// }


    }

