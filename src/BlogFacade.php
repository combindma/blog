<?php

namespace Combindma\Blog;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Combindma\Blog\Blog
 */
class BlogFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'blog';
    }
}
