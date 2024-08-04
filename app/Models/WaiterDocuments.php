<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaiterDocuments extends Model
{
    use HasFactory;
    protected $table = "waiter_documents";
    protected $fillable = [
        'waiter_id',
        'document',
    ];}
