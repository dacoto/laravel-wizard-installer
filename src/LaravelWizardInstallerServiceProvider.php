<?php

declare(strict_types=1);

namespace dacoto\LaravelWizardInstaller;

use dacoto\LaravelWizardInstaller\Middleware\InstallerMiddleware;
use dacoto\LaravelWizardInstaller\Middleware\ToInstallMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LaravelWizardInstallerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/installer.php',
            'installer'
        );
    }

    public function boot(Router $router, Kernel $kernel): void
    {
        $kernel->prependMiddlewareToGroup('web', ToInstallMiddleware::class);
        $router->pushMiddlewareToGroup('installer', InstallerMiddleware::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'installer');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/installer'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../config/installer.php' => config_path('installer.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/installer'),
        ], 'laravel-assets');
    }
}
