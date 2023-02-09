<?php

namespace Gamevault\Pensopay;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Gamevault\Pensopay\Commands\PensopayCommand;

class PensopayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lunar-pensopay')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_lunar-pensopay_table')
            ->hasCommand(PensopayCommand::class);
    }
}
