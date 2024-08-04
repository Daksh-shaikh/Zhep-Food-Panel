<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBoyDocuments extends Model
{
    use HasFactory;
    protected $table = "delivery_boy_documents";
    protected $fillable = [
        'delivery_boy_id',
        'layout_image',
    ];

}
