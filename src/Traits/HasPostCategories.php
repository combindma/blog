<?php


namespace Combindma\Blog\Traits;


use Combindma\Blog\Models\PostCategory;

trait HasPostCategories
{

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'category_post_relationship');
    }

    public function categoriesIds()
    {
        return $this->categories()->pluck('id')->toArray();
    }
}
