<?php

namespace Combindma\Blog;

use Combindma\Blog\Http\Controllers\AuthorController;
use Combindma\Blog\Http\Controllers\PostCategoryController;
use Combindma\Blog\Http\Controllers\PostController;
use Combindma\Blog\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BlogServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('blog')
            ->hasViews()
            ->hasTranslations()
            ->hasAssets()
            ->hasMigration('create_blog_table');
    }

    public function packageRegistered()
    {
        Route::macro('blog', function (string $baseUrl = 'admin') {
            Route::group(['prefix' => $baseUrl, 'as' => 'blog::'], function () {
                Route::resource('/posts/post_categories', PostCategoryController::class)->except(['show']);
                Route::post('/posts/post_categories/{id}/restore', [PostCategoryController::class, 'restore'])->name('post_categories.restore');

                Route::resource('/posts/tags', TagController::class)->except(['show']);
                Route::post('/posts/tags/{id}/restore', [TagController::class, 'restore'])->name('tags.restore');

                Route::resource('/posts/authors', AuthorController::class)->except(['show']);
                Route::post('/posts/authors/{id}/restore', [AuthorController::class, 'restore'])->name('authors.restore');

                Route::resource('/posts', PostController::class)->except(['show']);
                Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
                Route::post('/posts/upload', [PostController::class, 'upload'])->name('posts.upload');
            });
        });
    }
}
