<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

/**
 * Report Model
 * Represents the Report entity in the database.
 */
class Report extends Model
{

    protected $table = 'reports';
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'title',
        'type', // sales, inventory, staff, activity
        'data', // JSON or Array of report metrics
        'generated_by',
        'period_start',
        'period_end',
    ];
    /**
     * Creator.
     */

    public function creator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
