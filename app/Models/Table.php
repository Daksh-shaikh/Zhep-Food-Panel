<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $table = "table";
    protected $fillable = [
        'restro_id',
        'area_id',
        'table',
    ];


    public function area_name()
    {
        return $this->hasOne(Area::class, 'id', 'area_id');
    }
}
