<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'events';

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
