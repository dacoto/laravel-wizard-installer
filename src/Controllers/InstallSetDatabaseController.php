<?php

declare(strict_types=1);

namespace dacoto\LaravelWizardInstaller\Controllers;

use dacoto\EnvSet\EnvSetEditor;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PDO;

class InstallSetDatabaseController extends Controller
{
    public function __construct(
        public readonly EnvSetEditor $envEditor,
    ) {}

    public function __invoke(Request $request): RedirectResponse
    {
        if (
            ! (new InstallServerController())->check() ||
            ! (new InstallFolderController())->check()
        ) {
            return redirect()->route('install.folders');
        }

        try {
            $connection = new PDO(
                sprintf('mysql:host=%s:%s;dbname=%s', $request->input('database_hostname'), $request->input('database_port'), $request->input('database_name')),
                $request->input('database_username'),
                $request->input('database_password', '')
            );
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        try {
            $this->envEditor->setKey('DB_HOST', $request->input('database_hostname'));
            $this->envEditor->setKey('DB_PORT', $request->input('database_port', 3306));
            $this->envEditor->setKey('DB_DATABASE', $request->input('database_name'));
            $this->envEditor->setKey('DB_USERNAME', $request->input('database_username'));
            $this->envEditor->setKey('DB_PASSWORD', $request->input('database_password'));
            if ($request->input('database_prefix')) {
                $this->envEditor->setKey('DB_PREFIX', $request->input('database_prefix'));
            }
            $this->envEditor->save();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('install.migrations');
    }
}
