<?php

namespace Combindma\Blog\Tests\Features;

use Combindma\Blog\Models\PostCategory;
use Combindma\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class PostCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setData($data = [])
    {
        return array_merge([
            'name' => strtolower($this->faker->name),
        ], $data);
    }

    /** @test */
    public function user_can_create_post_category()
    {
        $data =  $this->setData();
        $response = $this->from(route('blog::post_categories.index'))->post(route('blog::post_categories.store'), $data);
        $response->assertRedirect(route('blog::post_categories.index'));
        $this->assertCount(1, $categories = PostCategory::all());
        $category = $categories->first();
        $this->assertEquals($data['name'], $category->name);
    }

    /** @test */
    public function user_can_update_post_category()
    {
        $post_category = PostCategory::factory()->create();
        $data =  $this->setData([
            'slug' => strtolower($this->faker->slug),
            'order_column' => $this->faker->numberBetween(1, 10)
        ]);
        $response = $this->from(route('blog::post_categories.edit', $post_category))->put(route('blog::post_categories.update', $post_category), $data);
        $response->assertRedirect(route('blog::post_categories.edit', $post_category));
        $post_category->refresh();
        $this->assertEquals($data['name'], $post_category->name);
        $this->assertEquals($data['slug'], $post_category->slug);
        $this->assertEquals($data['order_column'], $post_category->order_column);
    }

    /** @test */
    public function user_can_delete_post_category()
    {
        $category = PostCategory::factory()->create();
        $response = $this->from(route('blog::post_categories.index'))->delete(route('blog::post_categories.destroy', $category));
        $response->assertRedirect(route('blog::post_categories.index'));
        $this->assertCount(0, $categories = PostCategory::all());
    }

    /** @test */
    public function user_can_restore_a_post_category()
    {
        $category = PostCategory::factory()->create();
        $category->delete();
        $this->assertCount(0, PostCategory::all());
        $response = $this->from(route('blog::post_categories.index'))->post(route('blog::post_categories.restore', $category->id));
        $response->assertRedirect(route('blog::post_categories.index'));
        $this->assertCount(1, PostCategory::all());
    }

    /**
     * @test
     * @dataProvider postCategoryFormValidationProvider
     */
    public function user_cannot_create_post_category_with_invalid_data($formInput, $formInputValue)
    {
        $data =  $this->setData([
            $formInput => $formInputValue
        ]);
        $response = $this->from(route('blog::post_categories.index'))->post(route('blog::post_categories.store'), $data);
        $response->assertRedirect(route('blog::post_categories.index'));
        $response->assertSessionHasErrors($formInput);
        $this->assertCount(0, PostCategory::all());
    }

    public function postCategoryFormValidationProvider()
    {
        return[
            'name_is_required' => ['name', ''],
        ];
    }
}
