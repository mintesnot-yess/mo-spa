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

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
