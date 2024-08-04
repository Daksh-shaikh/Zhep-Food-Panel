<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gst extends Model
{
    use HasFactory;
    protected $table = "gst";

    protected $fillable = [
        'tax',
        'dstype',
        'value',
    ];

}
