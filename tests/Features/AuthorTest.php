<?php

namespace Combindma\Blog\Tests\Features;


use Combindma\Blog\Models\Author;
use Combindma\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    protected function setData($data = [])
    {
        return array_merge([
            'name' => strtolower($this->faker->name),
            'job' => strtolower($this->faker->name),
            'description' => strtolower($this->faker->text),
            'meta' => [
                'facebook' => 'link',
                'twitter' => 'link',
                'instagram' => 'link',
                'linkedin' => 'link',
            ],
        ], $data);
    }

    /** @test */
    public function user_can_create_an_author()
    {
        $data =  $this->setData();
        $response = $this->from(route('blog::authors.index'))->post(route('blog::authors.store'), $data);
        $response->assertRedirect(route('blog::authors.index'));
        $response->assertSessionHasNoErrors();
        $this->assertCount(1, $authors = Author::all());
        $author = $authors->first();
        $this->assertEquals($data['name'], $author->name);
        $this->assertEquals($data['job'], $author->job);
        $this->assertEquals($data['description'], $author->description);
        $this->assertEquals($data['meta']['facebook'], $author->meta['facebook']);
        $this->assertEquals($data['meta']['twitter'], $author->meta['twitter']);
        $this->assertEquals($data['meta']['instagram'], $author->meta['instagram']);
        $this->assertEquals($data['meta']['linkedin'], $author->meta['linkedin']);
    }

    /** @test */
    public function user_can_update_an_author()
    {
        $author = Author::factory()->create();
        $data =  $this->setData([
            'slug' => strtolower($this->faker->slug),
            'order_column' => $this->faker->numberBetween(1, 10),
        ]);
        $response = $this->from(route('blog::authors.edit', $author))->put(route('blog::authors.update', $author), $data);
        $response->assertRedirect(route('blog::authors.edit', $author));
        $response->assertSessionHasNoErrors();
        $author->refresh();
        $this->assertEquals($data['name'], $author->name);
        $this->assertEquals($data['job'], $author->job);
        $this->assertEquals($data['slug'], $author->slug);
        $this->assertEquals($data['order_column'], $author->order_column);
        $this->assertEquals($data['description'], $author->description);
        $this->assertEquals($data['meta']['facebook'], $author->meta['facebook']);
        $this->assertEquals($data['meta']['twitter'], $author->meta['twitter']);
        $this->assertEquals($data['meta']['instagram'], $author->meta['instagram']);
        $this->assertEquals($data['meta']['linkedin'], $author->meta['linkedin']);
    }

    /** @test */
    public function user_can_delete_an_author()
    {
        $author = Author::factory()->create();
        $response = $this->from(route('blog::authors.index'))->delete(route('blog::authors.destroy', $author));
        $response->assertRedirect(route('blog::authors.index'));
        $this->assertCount(0, Author::all());
    }

    /** @test */
    public function user_can_restore_an_author()
    {
        $author = Author::factory()->create();
        $author->delete();
        $this->assertCount(0, Author::all());
        $response = $this->from(route('blog::authors.index'))->post(route('blog::authors.restore', $author->id));
        $response->assertRedirect(route('blog::authors.index'));
        $this->assertCount(1, Author::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function user_cannot_create_an_author_with_invalid_data($formInput, $formInputValue)
    {
        $data =  $this->setData([
            $formInput => $formInputValue,
        ]);
        $response = $response = $this->from(route('blog::authors.index'))->post(route('blog::authors.store'), $data);
        $response->assertRedirect(route('blog::authors.index'));
        $response->assertSessionHasErrors($formInput);
        $this->assertCount(0, Author::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function user_cannot_update_an_author_with_invalid_data($formInput, $formInputValue)
    {
        $author = Author::factory()->create();
        $data =  $this->setData([
            $formInput => $formInputValue
        ]);
        $response = $this->from(route('blog::authors.edit' , $author))->put(route('blog::authors.update', $author), $data);
        $response->assertRedirect(route('blog::authors.edit' , $author));
        $response->assertSessionHasErrors($formInput);
    }

    public function postFormValidationProvider()
    {
        return[
            'name_is_required' => ['name', ''],
        ];
    }
}
