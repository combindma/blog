<?php

namespace Combindma\Blog\Models;

use Combindma\Blog\Traits\HasImage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Author extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;
    use Sluggable;
    use SortableTrait;
    use HasImage;

    protected $fillable = ['name', 'slug', 'job', 'description', 'order_column', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    protected static function newFactory()
    {
        return \Combindma\Blog\Database\Factories\AuthorFactory::new();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->singleFile()
            ->acceptsFile(function (File $file) {
                return ($file->mimeType === 'image/jpeg') or ($file->mimeType === 'image/jpg') or ($file->mimeType === 'image/png');
            });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->performOnCollections('images')
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->width(300)
            ->performOnCollections('images')
            ->nonQueued();
    }

    public function avatar()
    {
        return $this->getFirstMediaUrl('images', 'preview');
    }
}
