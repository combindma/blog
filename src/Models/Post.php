<?php

namespace Combindma\Blog\Models;

use BenSampo\Enum\Traits\CastsEnums;
use Combindma\Blog\Enums\Languages;
use Combindma\Blog\Traits\HasImage;
use Combindma\Blog\Traits\HasPostCategories;
use Combindma\Blog\Traits\HasTags;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;
    use SoftDeletes;
    use Filterable;
    use HasPostCategories;
    use HasTags;
    use CastsEnums;
    use HasImage;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'language',
        'content',
        'description',
        'markdown',
        'reading_time',
        'published_at',
        'modified_at',
        'is_published',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'published_at' => 'date',
        'modified_at' => 'date',
        'language' => Languages::class,
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected static function newFactory()
    {
        return \Combindma\Blog\Database\Factories\PostFactory::new();
    }

    public static function getAllPosts()
    {
        return Cache::rememberForever('posts', function () {
            return self::published()
                ->orderBy('published_at', 'desc')
                ->orderBy('id', 'desc')
                ->with(['categories', 'media'])
                ->simplePaginate(10, ['id', 'author_id', 'title', 'slug', 'description', 'reading_time', 'published_at', 'is_published']);
        });
    }

    public static function getPost($slug)
    {
        return self::published()
            ->whereSlug($slug)
            ->with(['author', 'author.media', 'categories', 'tags', 'media'])
            ->firstOrFail();
    }

    public static function getFeaturedPosts()
    {
        return Cache::rememberForever('featuredPosts', function () {
            return self::published()
                ->featured()
                ->orderBy('published_at', 'desc')
                ->orderBy('id', 'desc')
                ->with(['categories', 'media'])
                ->get(['id', 'title', 'slug', 'description', 'reading_time', 'published_at', 'is_published']);
        });
    }

    public static function getPostsForSitemap()
    {
        return self::published()
            ->orderBy('published_at', 'desc')
            ->get(['id', 'slug','published_at', 'modified_at', 'is_published']);
    }

    public function author()
    {
        return $this->belongsTo(Author::class)->withDefault();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    public function scopeFindByCategory($query, $category_id)
    {
        return $query->whereHas('categories', function ($query) use ($category_id) {
            $query->where('post_category_id', $category_id);
        });
    }

    public function getDatePublicationAttribute()
    {
        return $this->published_at->ago();
    }

    public function getCategoriesNames()
    {
        return implode(", ", $this->categories->pluck('name')->toArray());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->withResponsiveImages()
            ->singleFile()
            ->acceptsFile(function (File $file) {
                return ($file->mimeType === 'image/jpeg') or ($file->mimeType === 'image/jpg') or ($file->mimeType === 'image/png');
            });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->performOnCollections('images')
            ->nonQueued();
    }

    public function featured_image()
    {
        return $this->getFirstMedia('images');
    }

    public function featured_image_url()
    {
        return $this->getFirstMediaUrl('images');
    }
}
