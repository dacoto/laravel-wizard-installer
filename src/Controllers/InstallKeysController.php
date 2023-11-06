<?php

declare(strict_types=1);

namespace dacoto\LaravelWizardInstaller\Controllers;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class InstallKeysController extends Controller
{
    public function __invoke(): View|Factory|Application|RedirectResponse
    {
        $connectedToDb = false;

        try {
            DB::connection()->getPdo();
            $connectedToDb = true;
        } catch (Exception) {
        }

        if (
            ! $connectedToDb ||
            ! (new InstallServerController())->check() ||
            ! (new InstallFolderController())->check()
        ) {
            return redirect()->route('install.database');
        }

        return view('installer::steps.keys');
    }
}
