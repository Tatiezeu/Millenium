<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Service Model for managing Menu Items (Meals and Drinks)
 * Extended from MongoDB Laravel Model for Atlas compatibility.
 */
class Service extends Model
{
    use HasFactory;

    /**
     * Explicitly specify the MongoDB connection from config/database.php.
     */
    protected $connection = 'mongodb';

    /**
     * Specify the collection name in MongoDB.
     */
    protected $collection = 'services';

    /**
     * The primary key for MongoDB documents is the string-based _id.
     */
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     * name: Title of the dish/drink
     * type: 'meal' or 'drink'
     * category: Sub-classification (e.g., Breakfast, Wine)
     */
    protected $fillable = [
        'name',
        'type',
        'category',
        'price',
        'description',
        'image',
    ];

    /**
     * Cast price to float for accurate currency display.
     */
    protected $casts = [
        'price' => 'float',
    ];
}
