<?php

namespace Combindma\Blog;

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
            ->hasTranslations()
            ->hasAssets()
            ->hasMigration('create_blog_table');
    }
}
