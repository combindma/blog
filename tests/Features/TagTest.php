<?php

namespace Combindma\Blog\Tests\Features;

use Combindma\Blog\Models\Tag;
use Combindma\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagTest extends TestCase
{
    use DatabaseTransactions;

    protected function setData($data = [])
    {
        return array_merge([
            'name' => strtolower($this->faker->name),
        ], $data);
    }

    /** @test */
    public function admin_can_create_a_tag()
    {
        $data = $this->setData();
        $response = $this->from(route('admin::tags.index'))->post(route('admin::tags.store'), $data);
        $response->assertRedirect(route('admin::tags.index'));
        $this->assertCount(1, $tags = Tag::all());
        $tag = $tags->first();
        $this->assertEquals($data['name'], $tag->name);
    }

    /** @test */
    public function admin_can_update_a_tag()
    {
        $tag = Tag::factory()->create();
        $data = $this->setData([
            'slug' => strtolower($this->faker->slug),
            'order_column' => $this->faker->numberBetween(1, 10)
        ]);
        $response = $this->from(route('admin::tags.edit', $tag))->put(route('admin::tags.update', $tag), $data);
        $response->assertRedirect(route('admin::tags.edit', $tag));
        $tag->refresh();
        $this->assertEquals($data['name'], $tag->name);
        $this->assertEquals($data['slug'], $tag->slug);
        $this->assertEquals($data['order_column'], $tag->order_column);
    }

    /** @test */
    public function admin_can_delete_a_tag()
    {
        $tag = Tag::factory()->create();
        $response = $this->from(route('admin::tags.index'))->delete(route('admin::tags.destroy', $tag));
        $response->assertRedirect(route('admin::tags.index'));
        $this->assertCount(0, Tag::all());
    }

    /** @test */
    public function admin_can_restore_a_tag()
    {
        $tag = Tag::factory()->create();
        $tag->delete();
        $this->assertCount(0, Tag::all());
        $response = $this->from(route('admin::tags.index'))->post(route('admin::tags.restore', $tag->id));
        $response->assertRedirect(route('admin::tags.index'));
        $this->assertCount(1, Tag::all());
    }

    /**
     * @test
     * @dataProvider postCategoryFormValidationProvider
     */
    public function admin_cannot_create_tag_with_invalid_data($formInput, $formInputValue)
    {
        $data = $this->setData([
            $formInput => $formInputValue
        ]);
        $response = $this->from(route('admin::tags.index'))->post(route('admin::tags.store'), $data);
        $response->assertRedirect(route('admin::tags.index'));
        $response->assertSessionHasErrors($formInput);
        $this->assertCount(0, Tag::all());
    }

    public function postCategoryFormValidationProvider()
    {
        return [
            'name_is_required' => ['name', ''],
        ];
    }
}