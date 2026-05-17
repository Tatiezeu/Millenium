<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Gallery Model
 * Represents the Gallery entity in the database.
 */
class Gallery extends Model
{
    use HasFactory;


    protected $table = 'gallery';
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'title',
        'image_path',
        'category', // e.g., 'interior', 'food', 'events'
    ];
}
