<?php

namespace Combindma\Blog\Tests\Features;

use Combindma\Blog\Models\PostCategory;
use Combindma\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class PostCategoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setData($data = [])
    {
        return array_merge([
            'name' => strtolower($this->faker->name),
        ], $data);
    }

    /** @test */
    public function admin_can_create_post_category()
    {
        $data =  $this->setData();
        $response = $this->from(route('admin::post_categories.index'))->post(route('admin::post_categories.store'), $data);
        $response->assertRedirect(route('admin::post_categories.index'));
        $this->assertCount(1, $categories = PostCategory::all());
        $category = $categories->first();
        $this->assertEquals($data['name'], $category->name);
    }

    /** @test */
    public function admin_can_update_post_category()
    {
        $category = PostCategory::factory()->create();
        $data =  $this->setData([
            'slug' => strtolower($this->faker->slug),
            'order_column' => $this->faker->numberBetween(1, 10)
        ]);
        $response = $this->from(route('admin::post_categories.edit', $category))->put(route('admin::post_categories.update', $category), $data);
        $response->assertRedirect(route('admin::post_categories.edit', $category));
        $category->refresh();
        $this->assertEquals($data['name'], $category->name);
        $this->assertEquals($data['slug'], $category->slug);
        $this->assertEquals($data['order_column'], $category->order_column);
    }

    /** @test */
    public function admin_can_delete_post_category()
    {
        $category = PostCategory::factory()->create();
        $response = $this->from(route('admin::post_categories.index'))->delete(route('admin::post_categories.destroy', $category));
        $response->assertRedirect(route('admin::post_categories.index'));
        $this->assertCount(0, $categories = PostCategory::all());
    }

    /** @test */
    public function admin_can_restore_a_post_category()
    {
        $category = PostCategory::factory()->create();
        $category->delete();
        $this->assertCount(0, PostCategory::all());
        $response = $this->from(route('admin::post_categories.index'))->post(route('admin::post_categories.restore', $category->id));
        $response->assertRedirect(route('admin::post_categories.index'));
        $this->assertCount(1, PostCategory::all());
    }

    /**
     * @test
     * @dataProvider postCategoryFormValidationProvider
     */
    public function admin_cannot_create_post_category_with_invalid_data($formInput, $formInputValue)
    {
        $data =  $this->setData([
            $formInput => $formInputValue
        ]);
        $response = $this->from(route('admin::post_categories.index'))->post(route('admin::post_categories.store'), $data);
        $response->assertRedirect(route('admin::post_categories.index'));
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
