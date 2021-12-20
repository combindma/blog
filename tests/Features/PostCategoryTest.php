<?php


use Combindma\Blog\Http\Controllers\PostCategoryController;
use Combindma\Blog\Models\PostCategory;
use function Pest\Faker\faker;
use function Pest\Laravel\from;
use function PHPUnit\Framework\assertCount;

function setData($data = [])
{
    return array_merge([
        'name' => strtolower(faker()->name),
        'description' => strtolower(faker()->sentence(10)),
    ], $data);
}

test('user can create a post catgeory', function () {
    $data = setData();
    from(action([PostCategoryController::class, 'index']))
        ->post(action([PostCategoryController::class, 'store']), $data)
        ->assertRedirect(action([PostCategoryController::class, 'index']))
        ->assertSessionHasNoErrors();

    assertCount(1, $categories = PostCategory::all());
    $post_category = $categories->first();
    expect($post_category->name)->toBe($data['name']);
    expect($post_category->description)->toBe($data['description']);
});

test('user can update a post category', function () {
    $post_category = PostCategory::factory()->create();
    $data = setData([
        'slug' => strtolower(faker()->slug),
        'order_column' => faker()->numberBetween(1, 10),
    ]);
    from(action([PostCategoryController::class, 'edit'], ['post_category' => $post_category]))
        ->put(action([PostCategoryController::class, 'update'], ['post_category' => $post_category]), $data)
        ->assertRedirect(action([PostCategoryController::class, 'edit'], ['post_category' => $post_category]))
        ->assertSessionHasNoErrors();
    $post_category->refresh();
    expect($post_category->name)->toBe($data['name']);
    expect($post_category->description)->toBe($data['description']);
    expect($post_category->slug)->toBe($data['slug']);
    expect($post_category->order_column)->toBe($data['order_column']);
});

test('user can delete a post category', function () {
    $post_category = PostCategory::factory()->create();
    from(action([PostCategoryController::class, 'index']))
        ->delete(action([PostCategoryController::class, 'destroy'], ['post_category' => $post_category]))
        ->assertRedirect(action([PostCategoryController::class, 'index']));
    assertCount(0, PostCategory::all());
});

test('user can restore a deleted post category', function () {
    $post_category = PostCategory::factory()->create();
    $post_category->delete();
    assertCount(0, PostCategory::all());
    from(action([PostCategoryController::class, 'index']))
        ->post(action([PostCategoryController::class, 'restore'], ['id' => $post_category->id]))
        ->assertRedirect(action([PostCategoryController::class, 'index']));
    assertCount(1, PostCategory::all());
});
