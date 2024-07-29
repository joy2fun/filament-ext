<?php

namespace Joy2fun\FilamentExt;

use Joy2fun\FilamentExt\Commands\FilamentExtCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentExtServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-ext')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations([
                'create_sms_codes_table',
            ])
            ->hasCommand(FilamentExtCommand::class);
    }

}
