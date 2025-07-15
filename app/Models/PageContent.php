<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'section_name',
        'content_key',
        'content_value',
        'content_type',
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
     * Get content by page and key
     */
    public static function getContent($page, $section, $key, $default = null)
    {
        $content = static::where('page_name', $page)
            ->where('section_name', $section)
            ->where('content_key', $key)
            ->where('is_active', true)
            ->first();

        return $content ? $content->content_value : $default;
    }

    /**
     * Set content by page and key
     */
    public static function setContent($page, $section, $key, $value, $type = 'text')
    {
        return static::updateOrCreate(
            [
                'page_name' => $page,
                'section_name' => $section,
                'content_key' => $key,
            ],
            [
                'content_value' => $value,
                'content_type' => $type,
                'is_active' => true,
            ]
        );
    }

    /**
     * Get all content for a page
     */
    public static function getPageContent($page)
    {
        return static::where('page_name', $page)
            ->where('is_active', true)
            ->orderBy('section_name')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section_name');
    }
}
