<?php

declare(strict_types=1);

namespace dacoto\LaravelWizardInstaller\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class InstallDatabaseController extends Controller
{
    public function __invoke(): View|Factory|Application|RedirectResponse
    {
        if (
            ! (new InstallServerController())->check() ||
            ! (new InstallFolderController())->check()
        ) {
            return redirect()->route('install.folders');
        }

        return view('installer::steps.database');
    }
}
