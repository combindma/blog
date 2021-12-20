<?php

use Combindma\Blog\Http\Controllers\AuthorController;
use Combindma\Blog\Models\Author;
use function Pest\Faker\faker;
use function Pest\Laravel\from;
use function PHPUnit\Framework\assertCount;

function setData($data = [])
{
    return array_merge([
        'name' => strtolower(faker()->name),
        'job' => strtolower(faker()->name),
        'description' => strtolower(faker()->text),
        'meta' => [
            'facebook' => 'link',
        ],
    ], $data);
}

test('user can create an author', function () {
    $data = setData();
    from(action([AuthorController::class, 'index']))->post(action([AuthorController::class, 'store']), $data)
        ->assertRedirect(action([AuthorController::class, 'index']))
        ->assertSessionHasNoErrors();
    assertCount(1, $authors = Author::all());
    $author = $authors->first();
    expect($author->name)->toBe($data['name']);
    expect($author->description)->toBe($data['description']);
    expect($author->job)->toBe($data['job']);
    expect($author->meta['facebook'])->toBe($data['meta']['facebook']);
});


test('user can update an author', function () {
    $author = Author::factory()->create();
    $data = setData([
        'slug' => strtolower(faker()->slug),
        'order_column' => faker()->numberBetween(1, 10),
        'meta' => [
            'facebook' => 'new-link',
        ],
    ]);
    from(action([AuthorController::class, 'edit'], ['author' => $author]))
        ->put(action([AuthorController::class, 'update'], ['author' => $author]), $data)
        ->assertRedirect(action([AuthorController::class, 'edit'], ['author' => $author]))
        ->assertSessionHasNoErrors();
    $author->refresh();
    expect($author->name)->toBe($data['name']);
    expect($author->description)->toBe($data['description']);
    expect($author->job)->toBe($data['job']);
    expect($author->slug)->toBe($data['slug']);
    expect($author->order_column)->toBe($data['order_column']);
    expect($author->meta['facebook'])->toBe($data['meta']['facebook']);
});

test('user can delete an author', function () {
    $author = Author::factory()->create();
    from(action([AuthorController::class, 'index']))
        ->delete(action([AuthorController::class, 'destroy'], ['author' => $author]))
        ->assertRedirect(action([AuthorController::class, 'index']));
    assertCount(0, Author::all());
});

test('user can restore a deleted author', function () {
    $author = Author::factory()->create();
    $author->delete();
    $this->assertCount(0, Author::all());
    $response = $this->from(action([AuthorController::class, 'index']))->post(route('blog::authors.restore', $author->id));
    $response->assertRedirect(action([AuthorController::class, 'index']));
    $this->assertCount(1, Author::all());
});
