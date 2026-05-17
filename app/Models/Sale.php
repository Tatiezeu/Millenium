<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

/**
 * Sale Model
 * Represents the Sale entity in the database.
 */
class Sale extends Model
{

    protected $table = 'sales';
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'order_id',
        'items',
        'amount',
        'payment_method',
        'cashier_id',
    ];
    /**
     * Order.
     */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    /**
     * Cashier.
     */

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
