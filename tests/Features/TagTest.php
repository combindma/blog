<?php


use Combindma\Blog\Http\Controllers\TagController;
use Combindma\Blog\Models\Tag;
use function Pest\Faker\faker;
use function Pest\Laravel\from;
use function PHPUnit\Framework\assertCount;

function setData($data = [])
{
    return array_merge([
        'name' => strtolower(faker()->name),
    ], $data);
}

test('user can create a tag post', function () {
    $data = setData();
    from(action([TagController::class, 'index']))
        ->post(action([TagController::class, 'store']), $data)
        ->assertRedirect(action([TagController::class, 'index']))
        ->assertSessionHasNoErrors();
    assertCount(1, $tags = Tag::all());
    $tag = $tags->first();
    expect($tag->name)->toBe($data['name']);
});

test('user can update a tag post', function () {
    $tag = Tag::factory()->create();
    $data = setData([
        'slug' => strtolower(faker()->slug),
        'order_column' => faker()->numberBetween(1, 10),
    ]);
    from(action([TagController::class, 'edit'], ['tag' => $tag]))
        ->put(action([TagController::class, 'update'], ['tag' => $tag]), $data)
        ->assertRedirect(action([TagController::class, 'edit'], ['tag' => $tag]));
    $tag->refresh();
    expect($tag->name)->toBe($data['name']);
    expect($tag->slug)->toBe($data['slug']);
    expect($tag->order_column)->toBe($data['order_column']);
});

test('user can delete a tag post', function () {
    $tag = Tag::factory()->create();
    from(action([TagController::class, 'index']))->delete(action([TagController::class, 'destroy'], ['tag' => $tag]))->assertRedirect(action([TagController::class, 'index']));
    assertCount(0, Tag::all());
});

test('user can restore a deleted tag post', function () {
    $tag = Tag::factory()->create();
    $tag->delete();
    assertCount(0, Tag::all());
    from(action([TagController::class, 'index']))->post(action([TagController::class, 'restore'], ['id' => $tag->id]))->assertRedirect(action([TagController::class, 'index']));
    assertCount(1, Tag::all());
});
