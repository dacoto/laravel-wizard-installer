<?php

declare(strict_types=1);

namespace dacoto\LaravelWizardInstaller\Tests;

use dacoto\LaravelWizardInstaller\LaravelWizardInstallerServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelWizardInstallerServiceProvider::class,
        ];
    }
}
