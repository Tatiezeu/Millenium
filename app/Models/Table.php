<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Restaurant Table Model
 * Manages table availability, categorization, and pricing.
 */
class Table extends Model
{
    use HasFactory;

    /**
     * Specify the MongoDB connection.
     */
    protected $connection = 'mongodb';

    /**
     * Specify the collection name.
     */
    protected $collection = 'restaurant_tables';

    /**
     * The primary key for MongoDB documents.
     */
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     * title: e.g. 'Table 1'
     * seats: Number of people (places)
     * category: Standard, Medium, First Class
     * price: Cost to reserve
     * area: Size of the space (e.g. '15 m²')
     * status: 'available' or 'occupied'
     */
    protected $fillable = [
        'title',
        'seats',
        'category',
        'price',
        'area',
        'status',
    ];

    /**
     * Default values for attributes.
     */
    protected $attributes = [
        'status' => 'available',
    ];

    /**
     * Cast attributes to specific types.
     */
    protected $casts = [
        'seats' => 'integer',
        'price' => 'float',
    ];
}
