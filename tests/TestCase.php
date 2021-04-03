<?php

namespace Combindma\Blog\Tests;

use Combindma\Blog\Http\Controllers\AuthorController;
use Combindma\Blog\Http\Controllers\PostCategoryController;
use Combindma\Blog\Http\Controllers\PostController;
use Combindma\Blog\Http\Controllers\TagController;
use Elegant\Sanitizer\Laravel\SanitizerServiceProvider;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Combindma\Blog\BlogServiceProvider;

class TestCase extends Orchestra
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Combindma\\Blog\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
        //$this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [
            BlogServiceProvider::class,
            SanitizerServiceProvider::class
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        //Schema::dropAllTables();

        include_once __DIR__.'/../database/migrations/create_blog_table.php.stub';
        (new \CreateBlogTable())->up();

        $app['config']->set('sluggable', [
            'source'             => null,
            'method'             => null,
            'onUpdate'           => false,
            'separator'          => '-',
            'unique'             => true,
            'uniqueSuffix'       => null,
            'firstUniqueSuffix'  => 2,
            'includeTrashed'     => false,
            'reserved'           => null,
            'maxLength'          => null,
            'maxLengthKeepWords' => true,
            'slugEngineOptions'  => [],
        ]);

    }

    protected function defineRoutes($router)
    {
        Route::group(['as' => 'blog::', 'middleware' => ['bindings']], function (){
            Route::resource('/posts/post_categories', PostCategoryController::class)->except(['show']);
            Route::post('/posts/post_categories/{id}/restore', [PostCategoryController::class, 'restore'])->name('post_categories.restore');

            Route::resource('/posts/tags', TagController::class)->except(['show']);
            Route::post('/posts/tags/{tag}/restore', [TagController::class, 'restore'])->name('tags.restore');

            Route::resource('/posts/authors', AuthorController::class)->except(['show']);
            Route::post('/posts/authors/{id}/restore', [AuthorController::class, 'restore'])->name('authors.restore');

            Route::resource('/posts', PostController::class)->except(['show']);
            Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
            Route::post('/posts/upload', [PostController::class, 'upload'])->name('posts.upload');
        });
    }
}
