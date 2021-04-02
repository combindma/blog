<?php


namespace Combindma\Blog;

use Combindma\Blog\Http\Controllers\AuthorController;
use Combindma\Blog\Http\Controllers\PostCategoryController;
use Combindma\Blog\Http\Controllers\PostController;
use Combindma\Blog\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

class Blog
{
    public static function routes()
    {
        Route::resource('/posts/post_categories', PostCategoryController::class)->except(['show']);
        Route::post('/posts/post_categories/{id}/restore', [PostCategoryController::class, 'restore'])->name('post_categories.restore');

        Route::resource('/posts/tags', TagController::class)->except(['show']);
        Route::post('/posts/tags/{tag}/restore', [TagController::class, 'restore'])->name('tags.restore');

        Route::resource('/posts/authors', AuthorController::class)->except(['show']);
        Route::post('/posts/authors/{id}/restore', [AuthorController::class, 'restore'])->name('authors.restore');

        Route::resource('/posts', PostController::class)->except(['show']);
        Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
        Route::post('/posts/upload', [PostController::class, 'upload'])->name('posts.upload');
    }
}
