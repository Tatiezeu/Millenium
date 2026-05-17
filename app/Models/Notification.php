<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;


    protected $table = 'notifications';

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

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
