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
        'have_items',
        'items',
        'type',
        'created_by',
        'updated_by',
        'status',
    ];
    protected $casts = [
        'items' => 'array',
    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedUser(){
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function categories(){
        return $this->belongsTo(Category::class, 'category');
    }
     public function itemServices()
{
    return $this->hasMany(ServiceItems::class, 'service_id');
}
}
