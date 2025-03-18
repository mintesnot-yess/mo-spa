<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'code',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'email',
        'sex',
        'dob',
        'join_date',
        'created_by',
        'status',
    ];
}
