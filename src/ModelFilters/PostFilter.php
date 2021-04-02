<?php

namespace Combindma\Blog\ModelFilters;

use EloquentFilter\ModelFilter;

class PostFilter extends ModelFilter
{
    public $relations = [];

    public function status($value)
    {
        if ($value === 'published') {
            return $this->published();
        }

        if ($value === 'featured') {
            return $this->featured();
        }

        if ($value === 'deleted') {
            return $this->onlyTrashed();
        }

        return $this;
    }
}
