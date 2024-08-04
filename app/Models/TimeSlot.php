<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;
    protected $table = "time_slot";

    protected $fillable = [
        'restro_id',
        'days_id',
        'open_at',
        'close_at',
        'is_close',

    ];

}
