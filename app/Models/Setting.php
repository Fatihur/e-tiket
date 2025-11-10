<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            return self::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value)
    {
        $setting = self::firstOrCreate(['key' => $key]);
        $setting->value = $value;
        $setting->save();

        Cache::forget("setting_{$key}");
        
        return $setting;
    }

    /**
     * Get all settings as key-value array
     */
    public static function all_settings()
    {
        return Cache::remember('all_settings', 3600, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get settings by group
     */
    public static function getByGroup($group)
    {
        return self::where('group', $group)->get();
    }

    /**
     * Clear settings cache
     */
    public static function clearCache()
    {
        Cache::forget('all_settings');
        // Clear individual caches
        $keys = self::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting_{$key}");
        }
    }
}
