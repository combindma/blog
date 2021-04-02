<?php

namespace Combindma\Blog\Tests\Features;


use Combindma\Blog\Models\Author;
use Combindma\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AuthorTest extends TestCase
{
    use DatabaseTransactions;

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

    public function setStorage(){
        Storage::fake('images');
        config()->set('filesystems.disks.images', [
            'driver' => 'local',
            'root' => Storage::disk('images')->getAdapter()->getPathPrefix(),
        ]);
    }

    /** @test */
    public function admin_can_create_an_author()
    {
        $this->setStorage();

        $data =  $this->setData([
            'avatar' => UploadedFile::fake()->image('image.jpg', 1000, 1000),
        ]);
        $response = $this->from(route('admin::authors.index'))->post(route('admin::authors.store'), $data);
        $response->assertRedirect(route('admin::authors.index'));
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
        $this->assertFileExists($author->getFirstMedia('images')->getPath());
    }

    /** @test */
    public function admin_can_update_an_author()
    {
        $this->setStorage();
        $author = Author::factory()->create();
        $data =  $this->setData([
            'slug' => strtolower($this->faker->slug),
            'order_column' => $this->faker->numberBetween(1, 10),
            'avatar' => UploadedFile::fake()->image('image.jpg', 1000, 1000),
        ]);
        $response = $this->from(route('admin::authors.edit', $author))->put(route('admin::authors.update', $author), $data);
        $response->assertRedirect(route('admin::authors.edit', $author));
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
        $this->assertFileExists($author->getFirstMedia('images')->getPath());
    }

    /** @test */
    public function admin_can_delete_an_author()
    {
        $author = Author::factory()->create();
        $response = $this->from(route('admin::authors.index'))->delete(route('admin::authors.destroy', $author));
        $response->assertRedirect(route('admin::authors.index'));
        $this->assertCount(0, Author::all());
    }

    /** @test */
    public function admin_can_restore_an_author()
    {
        $author = Author::factory()->create();
        $author->delete();
        $this->assertCount(0, Author::all());
        $response = $this->from(route('admin::authors.index'))->post(route('admin::authors.restore', $author->id));
        $response->assertRedirect(route('admin::authors.index'));
        $this->assertCount(1, Author::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function admin_cannot_create_an_author_with_invalid_data($formInput, $formInputValue)
    {
        $data =  $this->setData([
            $formInput => $formInputValue,
        ]);
        $response = $response = $this->from(route('admin::authors.index'))->post(route('admin::authors.store'), $data);
        $response->assertRedirect(route('admin::authors.index'));
        $response->assertSessionHasErrors($formInput);
        $this->assertCount(0, Author::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function admin_cannot_update_an_author_with_invalid_data($formInput, $formInputValue)
    {
        $author = Author::factory()->create();
        $data =  $this->setData([
            $formInput => $formInputValue
        ]);
        $response = $this->from(route('admin::authors.edit' , $author))->put(route('admin::authors.update', $author), $data);
        $response->assertRedirect(route('admin::authors.edit' , $author));
        $response->assertSessionHasErrors($formInput);
    }

    public function postFormValidationProvider()
    {
        return[
            'name_is_required' => ['name', ''],
        ];
    }
}
