<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Event Model
 * Represents the Event entity in the database.
 */
class Event extends Model
{
    use HasFactory;


    protected $table = 'events';
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'location',
        'image_path',
        'status', // 'upcoming', 'ongoing', 'passed'
    ];
}
