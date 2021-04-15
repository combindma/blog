# Blog

[![Latest Version on Packagist](https://img.shields.io/packagist/v/combindma/blog.svg?style=flat-square)](https://packagist.org/packages/combindma/blog)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/combindma/blog/run-tests?label=tests)](https://github.com/combindma/blog/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/combindma/blog/Check%20&%20fix%20styling?label=code%20style)](https://github.com/combindma/blog/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/combindma/blog.svg?style=flat-square)](https://packagist.org/packages/combindma/blog)

## Installation

You can install the package via composer:

```bash
composer require combindma/blog
```

(Important)You must publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Combindma\Blog\BlogServiceProvider" --tag="blog-migrations"
php artisan migrate
```

(Important)You must publish assets with:

```bash
php artisan vendor:publish --provider="Combindma\Blog\BlogServiceProvider" --tag="blog-assets"
```

(Important)You must add this to your filesystems config

```php
        'images' => [
            'driver' => 'local',
            'root' => storage_path('app/public/images'),
            'url' => env('APP_URL').'/storage/images',
            'visibility' => 'public',
        ],

        'uploads' => [
            'driver' => 'local',
            'root' => storage_path('app/public/uploads'),
            'url' => env('APP_URL').'/storage/uploads',
            'visibility' => 'public',
        ],
```

You can publish views with:

```bash
php artisan vendor:publish --provider="Combindma\Blog\BlogServiceProvider" --tag="blog-views"
```

You can publish translations with:

```bash
php artisan vendor:publish --provider="Combindma\Blog\BlogServiceProvider" --tag="blog-translations"
```


## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Combind](https://github.com/combindma)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
