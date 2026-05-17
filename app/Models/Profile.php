<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Profile Model
 * Represents the Profile entity in the database.
 */
class Profile extends Model
{
    use HasFactory;


    protected $table = 'profiles';
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'bio',
        'address',
        'city',
        'country',
    ];
    /**
     * User.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
