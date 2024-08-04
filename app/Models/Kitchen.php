<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    use HasFactory;

    protected $table = "kitchen";
    protected $fillable = [
        'restro_id',
        'name',
        'contact',
        'email',
        'password',
        'status',

    ];
}
