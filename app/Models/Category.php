<?php

namespace App\Models;

use App\Models\Model;

class Category extends Model
{
    protected $hidden = ['is_deleted', 'deleted_at', 'updated_at', 'created_at', 'created_by', 'updated_by'];
    protected $fillable = ['name'];
    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}
