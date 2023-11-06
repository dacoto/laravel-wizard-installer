<?php

declare(strict_types=1);

namespace dacoto\LaravelWizardInstaller\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class InstallServerController extends Controller
{
    public function __invoke(): Factory|View|Application
    {
        return view('installer::steps.server', [
            'result' => $this->check(),
        ]);
    }

    public function check(): bool
    {
        foreach (config('installer.server') as $check) {
            if (($check['check']['type'] === 'php' && PHP_VERSION_ID < $check['check']['value']) || ($check['check']['type'] === 'extension' && ! extension_loaded($check['check']['value']))) {
                return false;
            }
        }

        return true;
    }
}
