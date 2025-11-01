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
        'image',
        'employee_id',
        'branch_id',
        'created_by',
        'status',
    ];
    protected $casts = [
    'employee_id' => 'array',
];

   public function employee() {
    return $this->belongsTo(Employee::class, 'employee_id');
}

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
