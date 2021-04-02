<?php

namespace Combindma\Blog\Tests\Features;

use Combindma\Blog\Enums\Languages;
use Combindma\Blog\Models\Author;
use Combindma\Blog\Models\Post;
use Combindma\Blog\Models\PostCategory;
use Combindma\Blog\Models\Tag;
use Combindma\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class PostTest extends TestCase
{
    //use DatabaseTransactions;
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

    public function setStorage()
    {
        Storage::fake('images');
        config()->set('filesystems.disks.images', [
            'driver' => 'local',
            'root' => Storage::disk('images')->getAdapter()->getPathPrefix(),
        ]);
    }

    /** @test */
    public function admin_can_create_a_post()
    {
        $this->setStorage();
        $data =  $this->setData([
            'post_image' => UploadedFile::fake()->image('image.jpg', 1000, 1000)
        ]);
        $response = $this->from(route('posts.create'))->post(route('posts.store'), $data);
        $response->assertSessionHasNoErrors();
        $this->assertCount(1, $posts = Post::all());
        $post = $posts->first();
        $response->assertRedirect(route('posts.edit', $post));
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
        $this->assertFileExists($post->getFirstMedia('images')->getPath());
    }

    /** @test */
    public function admin_can_update_a_post()
    {
        $this->setStorage();
        $post = Post::factory()->create();
        $data =  $this->setData([
            'post_image' => UploadedFile::fake()->image('image.jpg', 1000, 1000)
        ]);
        $response = $this->from(route('posts.edit', $post))->put(route('posts.update', $post), $data);
        $response->assertRedirect(route('posts.edit', $post));
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
        $this->assertFileExists($post->getFirstMedia('images')->getPath());
    }

    /** @test */
    public function admin_can_delete_a_post()
    {
        $post = Post::factory()->create();
        $response = $this->from(route('posts.index'))->delete(route('posts.destroy', $post));
        $response->assertRedirect(route('posts.index'));
        $this->assertCount(0, Post::all());
    }

    /** @test */
    public function admin_can_restore_a_post()
    {
        $post = Post::factory()->create();
        $post->delete();
        $this->assertCount(0, Post::all());
        $response = $this->from(route('posts.index'))->post(route('posts.restore', $post->id));
        $response->assertRedirect(route('posts.index'));
        $this->assertCount(1, Post::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function admin_cannot_create_post_with_invalid_data($formInput, $formInputValue)
    {
        $data =  $this->setData([
            $formInput => $formInputValue
        ]);
        $response = $response = $this->from(route('posts.create'))->post(route('posts.store'), $data);
        $response->assertRedirect(route('posts.create'));
        $response->assertSessionHasErrors($formInput);
        $this->assertCount(0, Post::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function admin_cannot_update_post_with_invalid_data($formInput, $formInputValue)
    {
        $post = Post::factory()->create();
        $data =  $this->setData([
            $formInput => $formInputValue
        ]);
        $response = $this->from(route('posts.edit', $post))->put(route('posts.update', $post), $data);
        $response->assertRedirect(route('posts.edit', $post));
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
