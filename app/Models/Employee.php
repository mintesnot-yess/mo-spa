<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees'; 
    protected $fillable = [
        'code',
        'service_group',
        'branch_id',
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
    ];
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
