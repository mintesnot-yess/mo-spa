<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'phone',
        'sex',
        'category',
        'remark',
        'employee_id',
        'created_by',
        'status',
    ];
}
