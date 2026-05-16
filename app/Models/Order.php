<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'user_id',
        'table_id',
        'items',
        'total_price',
        'status', // pending, preparing, ready, collected, out for delivery, served, delivered, completed, cancelled
        'notes',
        'service_type', // served, delivered
        'location',
        'address',
        'preparation_time', // in minutes
    ];

    /**
     * Get the user who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the table associated with the order.
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Get a summary of items in the order.
     */
    public function getItemsSummaryAttribute()
    {
        if (empty($this->items)) return 'No items';
        
        $names = array_map(function($item) {
            return $item['name'] ?? 'Item';
        }, $this->items);

        return implode(', ', array_slice($names, 0, 3)) . (count($names) > 3 ? '...' : '');
    }
}
