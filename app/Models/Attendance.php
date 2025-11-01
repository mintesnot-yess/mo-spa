<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'date',
        'check_in',
        'check_out',
        'late',
        'early_leave',
        'attended',
        'absent',
        'worked',
        'break',
        'leave_type',
        'leave',
        'ot1',
        'ot2',
        'ot3'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}