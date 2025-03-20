<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'type',
        'parent_category_id',
        'created_by',
    ];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
