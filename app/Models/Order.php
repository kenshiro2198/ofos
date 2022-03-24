<?php

namespace App\Models;

use App\Models\Model;

class Order extends Model
{
    protected $hidden = ['is_deleted', 'deleted_at', 'updated_at', 'created_at', 'created_by', 'updated_by'];
    protected $fillable = ['name'];
    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function tracker()
    {
        return $this->belongsTo(OrderTracker::class, 'order_id');
    }
}
