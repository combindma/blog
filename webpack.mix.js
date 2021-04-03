let mix = require('laravel-mix');

mix.scripts(['node_modules/ckeditor5-build-laravel-image/build/ckeditor.js'], 'resources/dist/ckeditor.js')
    .setPublicPath('resources/dist')
    .options({
        processCssUrls: false
    });
