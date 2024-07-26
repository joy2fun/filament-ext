<?php

namespace Joy2fun\FilamentExt\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Joy2fun\FilamentExt\FilamentExtServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Joy2fun\\FilamentExt\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentExtServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-ext_table.php.stub';
        $migration->up();
        */
    }
}
