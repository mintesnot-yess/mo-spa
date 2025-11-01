<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',        
        'employee_id',
        'is_finished',
    ];
    // public function user(){
    //     return $this->belongsTo(User::class, 'created_by');
    // }
}
