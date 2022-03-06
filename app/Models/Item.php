<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $hidden = ['is_deleted', 'deleted_at', 'updated_at', 'created_at', 'created_by', 'updated_by'];
    protected $fillable = ['category_id', 'name', 'price', 'description', 'image', 'qty', 'is_available'];
    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
