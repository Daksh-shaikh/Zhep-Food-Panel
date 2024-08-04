<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'restaurant',
        'name',
        'email',
        'password',
        'contact',
        'gender',
        'address',
        'restro_id',
        'kitchen_id',
        'delivery_boy_id',
        'waiter_id',
        'profile_picture',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function restro()
    {
        return $this->belongsTo(Restro::class, 'restro_id');
    }

    // to show only corresponding recipes of authenticated restro
    // public function restros()
    // {
    //     return $this->hasMany(Restro::class, 'restro_id', 'id');
    // }

    // user table has restro_id
    // restro model also has relationship for this.
    // this is done to retrieve only the info where restro id similar with the login restro
    public function recipes()
    {
        return $this->hasManyThrough(
            Recipe::class,
            Restro::class,
            'id', // Foreign key on users table
            'restaurant_id', // Foreign key on recipes table
            'restro_id', // Local key on users table
            'id' // Local key on restro table
        );
    }

    public function orders()
    {
        return $this->hasManyThrough(
            Order::class,
            Restro::class,
            'id', // Foreign key on users table
            'restro_id', // Foreign key on order table
            'restro_id', // Local key on users table
            'id' // Local key on restro table
        )->where('order.type', '!=', 'Takeaways');
    }

    public function leaves()
    {
        return $this->hasManyThrough(
            LeaveDate::class,
            Restro::class,
            'id', // Foreign key on users table
            'restro_id', // Foreign key on leave date table
            'restro_id', // Local key on users table
            'id' // Local key on restro table
        );
    }

    public function kitchen()
    {
        return $this->hasManyThrough(
            Kitchen::class,
            Restro::class,
            'id', // Foreign key on users table
            'restro_id', // Foreign key on kitchen table
            'restro_id', // Local key on users table
            'id' // Local key on restro table
        );
    }

    public function area()
    {
        return $this->hasManyThrough(
            Area::class,
            Restro::class,
            'id', // Foreign key on users table
            'restro_id', // Foreign key on kitchen table
            'restro_id', // Local key on users table
            'id' // Local key on restro table
        );
    }

    public function table()
    {
        return $this->hasManyThrough(
            Table::class,
            Restro::class,
            'id', // Foreign key on users table
            'restro_id', // Foreign key on kitchen table
            'restro_id', // Local key on users table
            'id' // Local key on restro table
        );
    }

    public function waiter()
    {
        return $this->hasManyThrough(
            Waiter::class,
            Restro::class,
            'id', // Foreign key on users table
            'restro_id', // Foreign key on kitchen table
            'restro_id', // Local key on users table
            'id' // Local key on restro table
        );
    }


}
