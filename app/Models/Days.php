<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Days extends Model
{
    use HasFactory;
    protected $table = "days";

    protected $fillable = [
        'days'

    ];

    public function restros()
    {
        return $this->belongsToMany(Restro::class, 'time_slots', 'days_id', 'restro_id')
            ->using(TimeSlot::class)
            ->withPivot(['open_at', 'close_at', 'is_close']);
    }

}
