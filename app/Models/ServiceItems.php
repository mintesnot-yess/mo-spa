<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'item_id',
        'created_by',
    ];
    public function itemServices()
{
    return $this->hasMany(ItemService::class, 'service_id');
}
    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function item(){
        return $this->belongsTo(Item::class, 'item_id');
    }
}
