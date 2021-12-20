<?php

namespace Combindma\Blog\Traits;

trait HasImage
{
    public function addImage($file)
    {
        $this->addMedia($file)->toMediaCollection('images', 'images');

        return $this;
    }

    public function image_url()
    {
        return $this->getFirstMediaUrl('images');
    }

    public function thumb_url()
    {
        return $this->getFirstMediaUrl('images', 'thumb');
    }
}
