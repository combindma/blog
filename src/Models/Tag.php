<?php

namespace Combindma\Blog\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;


class Tag extends Model implements Sortable
{
    use HasFactory, SoftDeletes, HasFactory, Sluggable, SortableTrait;

    protected $fillable = ['name', 'slug', 'order_column'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}