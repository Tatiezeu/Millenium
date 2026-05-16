<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Setting extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'settings';

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
