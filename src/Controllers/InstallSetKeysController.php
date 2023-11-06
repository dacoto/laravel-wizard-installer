<?php

declare(strict_types=1);

namespace dacoto\LaravelWizardInstaller\Controllers;

use dacoto\EnvSet\EnvSetEditor;
use dacoto\LaravelWizardInstaller\Exceptions\CantGenerateKeyException;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class InstallSetKeysController extends Controller
{
    public function __construct(
        public readonly EnvSetEditor $envEditor,
    ) {}

    public function __invoke(Request $request): RedirectResponse
    {
        try {
            $this->envEditor->setKey('APP_URL', $request->input('app_url'));
            Artisan::call('key:generate', ['--force' => true, '--show' => true]);
            if (empty($this->envEditor->getValue('APP_KEY'))) {
                $this->envEditor->setKey('APP_KEY', trim(str_replace('"', '', Artisan::output())));
            }
            $this->envEditor->save();
            if (empty($this->envEditor->getValue('APP_KEY'))) {
                throw new CantGenerateKeyException();
            }
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        Artisan::call('storage:link', ['--force' => true]);

        try {
            foreach (config('installer.commands', []) as $command) {
                Artisan::call($command);
            }
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('install.finish');
    }
}
