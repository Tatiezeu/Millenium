<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

/**
 * Setting Model
 * Represents the Setting entity in the database.
 */
class Setting extends Model
{

    protected $table = 'settings';
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by key.
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
