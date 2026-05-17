<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Service Model for managing Menu Items (Meals and Drinks)

 */
class Service extends Model
{
    use HasFactory;

    /**

     */


    /**

     */
    protected $table = 'services';

    /**

     */


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
