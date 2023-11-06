<?php

declare(strict_types=1);

namespace dacoto\LaravelWizardInstaller\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstallerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->alreadyInstalled() || explode('/', $request->route() ? $request->route()->uri() : '')[0] !== 'install') {
            abort(404);
        }

        return $next($request);
    }

    /**
     * If application is already installed.
     */
    public function alreadyInstalled(): bool
    {
        return file_exists(storage_path('installed'));
    }
}
