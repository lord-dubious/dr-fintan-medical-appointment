<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;
use Illuminate\Support\Str;

class BlogPost extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTags;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'is_featured',
        'meta_data',
        'author_id',
        'published_at',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            
            if (empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 160);
            }
            
            // Calculate reading time
            $wordCount = str_word_count(strip_tags($post->content));
            $readingTime = ceil($wordCount / 200); // Average reading speed
            
            $metaData = $post->meta_data ?? [];
            $metaData['reading_time'] = $readingTime;
            $post->meta_data = $metaData;
        });
    }

    // Relationships
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByTag($query, $tag)
    {
        return $query->withAnyTags([$tag]);
    }

    // Accessors
    public function getReadingTimeAttribute()
    {
        return $this->meta_data['reading_time'] ?? 1;
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        
        $media = $this->getFirstMedia('featured');
        return $media ? $media->getUrl() : asset('assets/images/blog-default.jpg');
    }

    public function getExcerptAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->content), 160);
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')
              ->singleFile()
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
              
        $this->addMediaCollection('gallery')
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(300)
              ->height(200)
              ->sharpen(10)
              ->performOnCollections('featured', 'gallery');
              
        $this->addMediaConversion('medium')
              ->width(800)
              ->height(600)
              ->sharpen(10)
              ->performOnCollections('featured', 'gallery');
    }

    // Helper Methods
    public function isPublished(): bool
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at->isPast();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}