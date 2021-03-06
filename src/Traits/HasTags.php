<?php

namespace Combindma\Blog\Traits;

use Combindma\Blog\Models\Tag;

trait HasTags
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function tagsIds()
    {
        return $this->tags()->pluck('id')->toArray();
    }
}
