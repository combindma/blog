<?php

use Illuminate\Support\Str;
use League\CommonMark\GithubFlavoredMarkdownConverter;

Str::macro('markdown', function ($content) {
    $converter = new GithubFlavoredMarkdownConverter([
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
    ]);

    return $converter->convertToHtml($content);
});
