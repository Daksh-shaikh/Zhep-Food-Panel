<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveDate extends Model
{
    use HasFactory;
    protected $table = "leave_date";

    protected $fillable = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'restro_id',

    ];
}
