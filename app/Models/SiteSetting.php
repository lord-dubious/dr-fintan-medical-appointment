<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group_name',
        'label',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->where('is_active', true)->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value, $type = 'text')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'is_active' => true]
        );
    }

    /**
     * Get settings by group
     */
    public static function getGroup($groupName)
    {
        return static::where('group_name', $groupName)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->pluck('value', 'key');
    }
}
