<?php


use Combindma\Blog\Enums\Languages;
use Combindma\Blog\Http\Controllers\PostController;
use Combindma\Blog\Models\Author;
use Combindma\Blog\Models\Post;
use Combindma\Blog\Models\PostCategory;
use Combindma\Blog\Models\Tag;
use Illuminate\Support\Arr;
use function Pest\Faker\faker;
use function Pest\Laravel\from;
use function PHPUnit\Framework\assertCount;

function setData($data = [])
{
    $author = Author::factory()->create();
    $tags = Arr::pluck(Tag::factory()->count(3)->create(), 'id');
    $categories = Arr::pluck(PostCategory::factory()->count(3)->create(), 'id');

    return array_merge([
        'categories' => $categories,
        'tags' => $tags,
        'author_id' => $author->id,
        'title' => strtolower(faker()->sentence(10)),
        'language' => Languages::French,
        'content' => strtolower(faker()->text),
        'markdown' => strtolower(faker()->text),
        'description' => strtolower(faker()->sentence(20)),
        'reading_time' => '5 min',
        'published_at' => date('Y-m-d'),
        'modified_at' => date('Y-m-d'),
        'is_published' => 1,
        'is_featured' => 1,
        'meta_title' => strtolower(faker()->sentence(10)),
        'meta_description' => strtolower(faker()->sentence(20)),
    ], $data);
}

test('user can creat a post', function () {
    $data = setData();
    from(action([PostController::class, 'create']))
        ->post(action([PostController::class, 'store']), $data)
        ->assertSessionHasNoErrors();
    assertCount(1, $posts = Post::all());
    $post = $posts->first();
    expect($post->author_id)->toBe($data['author_id']);
    expect($post->title)->toBe($data['title']);
    expect($post->language->value)->toBe($data['language']);
    expect($post->content)->toBe($data['content']);
    expect($post->markdown)->toBe($data['markdown']);
    expect($post->description)->toBe($data['description']);
    expect($post->reading_time)->toBe($data['reading_time']);
    expect($post->published_at->format('Y-m-d'))->toBe($data['published_at']);
    expect($post->modified_at->format('Y-m-d'))->toBe($data['modified_at']);
    expect($post->is_published)->toBe($data['is_published']);
    expect($post->is_featured)->toBe($data['is_featured']);
    expect($post->meta_title)->toBe($data['meta_title']);
    expect($post->meta_description)->toBe($data['meta_description']);
});

test('user can update a post', function () {
    $post = Post::factory()->create();
    $data = setData();
    from(action([PostController::class, 'edit'], ['post' => $post]))
        ->put(action([PostController::class, 'update'], ['post' => $post]), $data)
        ->assertRedirect(action([PostController::class, 'edit'], ['post' => $post]))
        ->assertSessionHasNoErrors();
    $post->refresh();
    expect($post->author_id)->toBe($data['author_id']);
    expect($post->title)->toBe($data['title']);
    expect($post->language->value)->toBe($data['language']);
    expect($post->content)->toBe($data['content']);
    expect($post->markdown)->toBe($data['markdown']);
    expect($post->description)->toBe($data['description']);
    expect($post->reading_time)->toBe($data['reading_time']);
    expect($post->published_at->format('Y-m-d'))->toBe($data['published_at']);
    expect($post->modified_at->format('Y-m-d'))->toBe($data['modified_at']);
    expect($post->is_published)->toBe($data['is_published']);
    expect($post->is_featured)->toBe($data['is_featured']);
    expect($post->meta_title)->toBe($data['meta_title']);
    expect($post->meta_description)->toBe($data['meta_description']);
});

test('user can delete a post', function () {
    $post = Post::factory()->create();
    from(action([PostController::class, 'index']))
        ->delete(action([PostController::class, 'destroy'], ['post' => $post]))
        ->assertRedirect(action([PostController::class, 'index']));
    $this->assertCount(0, Post::all());
});

test('user can restore a deleted post', function () {
    $post = Post::factory()->create();
    $post->delete();
    assertCount(0, Post::all());
    from(action([PostController::class, 'index']))
        ->post(action([PostController::class, 'restore'], ['id' => $post->id]))
        ->assertRedirect(action([PostController::class, 'index']));
    assertCount(1, Post::all());
});
