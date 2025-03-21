<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['service_id', 'client_id', 'employee_id', 'price','commission', 'created_by', 'updated_by','status','is_new'];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function service(){
        return $this->belongsTo(Service::class,'service_id', 'id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
