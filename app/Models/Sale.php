<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Sale extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'sales';

    protected $fillable = [
        'order_id',
        'items',
        'amount',
        'payment_method',
        'cashier_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
