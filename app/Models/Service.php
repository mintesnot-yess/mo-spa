<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'category',
        'price',
        'type',
        'created_by',
        'updated_by',
        'status',
    ];
}
