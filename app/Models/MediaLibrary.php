<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaLibrary extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'alt_text',
        'category',
        'uploaded_by',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who uploaded this media
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }

    /**
     * Get full URL for the media file
     */
    public function getUrlAttribute()
    {
        return asset('storage/'.$this->file_path);
    }

    /**
     * Check if file is an image
     */
    public function isImage()
    {
        return strpos($this->mime_type, 'image/') === 0;
    }

    /**
     * Get media by category
     */
    public static function getByCategory($category, $isPublic = true)
    {
        return static::where('category', $category)
            ->where('is_public', $isPublic)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
