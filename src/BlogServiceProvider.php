<?php

namespace Combindma\Blog;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BlogServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('blog')
            ->hasViews()
            ->hasMigration('create_blog_table');
    }

    public function packageBooted()
    {
        Route::macro('blog', function (string $prefix = 'dash'){
            Route::group(['prefix' => $prefix, 'as' => 'admin::'], function (){
                Blog::routes();
            });
        });
    }
}
