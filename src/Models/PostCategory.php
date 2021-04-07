<?php

namespace Combindma\Blog\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class PostCategory extends Model implements Sortable
{
    use SoftDeletes;
    use HasFactory;
    use Sluggable;
    use SortableTrait;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'visible_in_menu',
        'browsable',
        'order_column',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array'
    ];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post_relationship');
    }

    public static function getCategoriesBrowsable()
    {
        return Cache::remember('post_categories', 60*60*168, function () {
            return self::browsable()->orderBy('order_column')->get(['id', 'name', 'slug','order_column']);
        });

    }

    public function scopeVisibleInMenu($query)
    {
        return $query->where('visible_in_menu', 1);
    }

    public function scopeBrowsable($query)
    {
        return $query->where('browsable', 1);
    }

}
