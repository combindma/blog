<?php

namespace Combindma\Blog\Tests\Features;

use Combindma\Blog\Enums\Languages;
use Combindma\Blog\Models\Author;
use Combindma\Blog\Models\Post;
use Combindma\Blog\Models\PostCategory;
use Combindma\Blog\Models\Tag;
use Combindma\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setData($data = [])
    {
        $author = Author::factory()->create();
        $tags = Arr::pluck(Tag::factory()->count(3)->create(), 'id');
        $categories = Arr::pluck(PostCategory::factory()->count(3)->create(), 'id');

        return array_merge([
            'categories' => $categories,
            'tags' => $tags,
            'author_id' => $author->id,
            'title' => strtolower($this->faker->sentence(10)),
            'language' => Languages::French,
            'content' => strtolower($this->faker->text),
            'description' => strtolower($this->faker->sentence(20)),
            'reading_time' => '5 min',
            'published_at' => date('Y-m-d'),
            'modified_at' => date('Y-m-d'),
            'is_published' => 1,
            'is_featured' => 1,
            'meta_title' => strtolower($this->faker->sentence(10)),
            'meta_description' => strtolower($this->faker->sentence(20)),
        ], $data);
    }

    /** @test */
    public function user_can_create_a_post()
    {
        $data = $this->setData();
        $response = $this->from(route('blog::posts.create'))->post(route('blog::posts.store'), $data);
        $response->assertSessionHasNoErrors();
        $this->assertCount(1, $posts = Post::all());
        $post = $posts->first();
        $response->assertRedirect(route('blog::posts.edit', $post));
        $this->assertEquals($data['author_id'], $post->author_id);
        $this->assertEquals($data['title'], $post->title);
        $this->assertEquals($data['language'], $post->language);
        $this->assertEquals($data['content'], $post->content);
        $this->assertEquals($data['description'], $post->description);
        $this->assertEquals($data['reading_time'], $post->reading_time);
        $this->assertEquals($data['published_at'], $post->published_at->format('Y-m-d'));
        $this->assertEquals($data['is_published'], $post->is_published);
        $this->assertEquals($data['is_featured'], $post->is_featured);
        $this->assertEquals($data['meta_title'], $post->meta_title);
        $this->assertEquals($data['meta_description'], $post->meta_description);
    }

    /** @test */
    public function user_can_update_a_post()
    {
        $post = Post::factory()->create();
        $data = $this->setData();
        $response = $this->from(route('blog::posts.edit', $post))->put(route('blog::posts.update', $post), $data);
        $response->assertRedirect(route('blog::posts.edit', $post));
        $response->assertSessionHasNoErrors();
        $post->refresh();
        $this->assertEquals($data['author_id'], $post->author_id);
        $this->assertEquals($data['title'], $post->title);
        $this->assertEquals($data['language'], $post->language);
        $this->assertEquals($data['content'], $post->content);
        $this->assertEquals($data['description'], $post->description);
        $this->assertEquals($data['reading_time'], $post->reading_time);
        $this->assertEquals($data['published_at'], $post->published_at->format('Y-m-d'));
        $this->assertEquals($data['modified_at'], $post->modified_at->format('Y-m-d'));
        $this->assertEquals($data['is_published'], $post->is_published);
        $this->assertEquals($data['is_featured'], $post->is_featured);
        $this->assertEquals($data['meta_title'], $post->meta_title);
        $this->assertEquals($data['meta_description'], $post->meta_description);
    }

    /** @test */
    public function user_can_delete_a_post()
    {
        $post = Post::factory()->create();
        $response = $this->from(route('blog::posts.index'))->delete(route('blog::posts.destroy', $post));
        $response->assertRedirect(route('blog::posts.index'));
        $this->assertCount(0, Post::all());
    }

    /** @test */
    public function user_can_restore_a_post()
    {
        $post = Post::factory()->create();
        $post->delete();
        $this->assertCount(0, Post::all());
        $response = $this->from(route('blog::posts.index'))->post(route('blog::posts.restore', $post->id));
        $response->assertRedirect(route('blog::posts.index'));
        $this->assertCount(1, Post::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function user_cannot_create_post_with_invalid_data($formInput, $formInputValue)
    {
        $data = $this->setData([
            $formInput => $formInputValue,
        ]);
        $response = $response = $this->from(route('blog::posts.create'))->post(route('blog::posts.store'), $data);
        $response->assertRedirect(route('blog::posts.create'));
        $response->assertSessionHasErrors($formInput);
        $this->assertCount(0, Post::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function user_cannot_update_post_with_invalid_data($formInput, $formInputValue)
    {
        $post = Post::factory()->create();
        $data = $this->setData([
            $formInput => $formInputValue,
        ]);
        $response = $this->from(route('blog::posts.edit', $post))->put(route('blog::posts.update', $post), $data);
        $response->assertRedirect(route('blog::posts.edit', $post));
        $response->assertSessionHasErrors($formInput);
    }

    public function postFormValidationProvider()
    {
        return[
            'title_is_required' => ['title', ''],
            'language_is_required' => ['language', ''],
            'content_is_required' => ['content', ''],
            'description_is_required' => ['description', ''],
            'publish_date_is_required' => ['published_at', ''],
        ];
    }
}
