<?php

declare(strict_types=1);

namespace dacoto\LaravelWizardInstaller\Controllers;

use dacoto\EnvSet\EnvSetEditor;
use dacoto\EnvSet\Exceptions\KeyNotFoundException;
use dacoto\EnvSet\Exceptions\UnableReadFileException;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use JsonException;

class InstallFinishController extends Controller
{
    public function __construct(
        public readonly EnvSetEditor $envEditor,
    ) {}

    /**
     * @throws JsonException
     * @throws KeyNotFoundException
     * @throws UnableReadFileException
     */
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
            empty($this->envEditor->getValue('APP_KEY')) ||
            ! (new InstallServerController())->check() ||
            ! (new InstallFolderController())->check()
        ) {
            return redirect()->route('install.database');
        }
        $data = [
            'url' => config('app.url'),
            'date' => date('Y/m/d h:i:s'),
        ];
        file_put_contents(storage_path('installed'), json_encode($data, JSON_THROW_ON_ERROR), FILE_APPEND|LOCK_EX);

        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');

        return view('installer::steps.finish', ['base' => url('/'), 'login' => url(config('installer.login'))]);
    }
}
