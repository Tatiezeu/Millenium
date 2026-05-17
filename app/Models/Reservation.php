<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Reservation Model
 * Handles table bookings and guest management.
 */
class Reservation extends Model
{
    use HasFactory;


    protected $table = 'reservations';


    /**
     * The attributes that are mass assignable.
     * table_id: Link to restaurant_tables
     * user_id: Link to users (if registered)
     * guest_name: For unregistered or quick entries
     * guest_count: Number of people
     * reservation_date: Day of booking
     * reservation_time: Hour of booking
     * status: 'pending', 'confirmed', 'cancelled', 'completed'
     */
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'table_id',
        'user_id',
        'guest_name',
        'guest_count',
        'reservation_date',
        'reservation_time',
        'status',
        'notes',
    ];

    /**
     * Default status for new reservations.
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Relationships
     */
    /**
     * Table.
     */
    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
    /**
     * User.
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
