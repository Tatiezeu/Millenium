<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Report extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reports';

    protected $fillable = [
        'title',
        'type', // sales, inventory, staff, activity
        'data', // JSON or Array of report metrics
        'generated_by',
        'period_start',
        'period_end',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
