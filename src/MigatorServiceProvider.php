<?php

declare(strict_types=1);

namespace Synetic\Migator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Synetic\Migator\Commands\AboutCommand;

class MigatorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('Migator')
            ->hasCommands(
                AboutCommand::class
            );
    }
}
