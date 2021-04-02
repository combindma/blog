<?php

namespace Combindma\Blog\Tests;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Combindma\Blog\BlogServiceProvider;

class TestCase extends Orchestra
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        //$this->withoutExceptionHandling();
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\Blog\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            BlogServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);


        include_once __DIR__.'/../database/migrations/create_blog_table.php.stub';
        (new \CreateBlogTable())->up();

    }
}
