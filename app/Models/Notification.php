<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Notification Model
 * Represents the Notification entity in the database.
 */
class Notification extends Model
{
    use HasFactory;


    protected $table = 'notifications';
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'type', // e.g., 'message', 'alert', 'reservation'
        'is_read',
        'attachments',
        'parent_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
    /**
     * Sender.
     */

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    /**
     * Receiver.
     */

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
