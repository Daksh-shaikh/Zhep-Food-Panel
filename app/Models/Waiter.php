<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    use HasFactory;
    protected $table = "waiter";
    protected $fillable = [
        'restro_id',
        'name',
        'contact',
        'email',
        'password',

    ];
}
