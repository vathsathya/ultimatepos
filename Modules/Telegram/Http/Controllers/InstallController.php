<?php

namespace Modules\Telegram\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use App\System;

class InstallController extends Controller
{
    /**
     * Module version
     */
    protected $module_version = '1.0';

    /**
     * Install the Telegram module:
     *  - Run migrations
     *  - Record module version in system table
     */
    public function index()
    {
        if (!auth()->user()->can('manage_modules')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Run module migrations and publish assets
            Artisan::call('module:migrate', ['module' => 'Telegram', '--force' => true]);
            Artisan::call('module:publish', ['module' => 'Telegram']);

            // Register module version so isModuleInstalled() returns true
            System::addProperty('telegram_version', $this->module_version);

            $output = ['success' => 1, 'msg' => 'Telegram module installed successfully!'];
        } catch (\Exception $e) {
            \Log::emergency('Telegram install error: ' . $e->getMessage());
            $output = ['success' => 0, 'msg' => $e->getMessage()];
        }

        return redirect()->action([\App\Http\Controllers\Install\ModulesController::class, 'index'])
            ->with('status', $output);
    }

    /**
     * Uninstall: remove version flag from system table.
     */
    public function uninstall()
    {
        if (!auth()->user()->can('manage_modules')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            System::removeProperty('telegram_version');
            $output = ['success' => 1, 'msg' => 'Telegram module uninstalled successfully.'];
        } catch (\Exception $e) {
            $output = ['success' => 0, 'msg' => $e->getMessage()];
        }

        return redirect()->action([\App\Http\Controllers\Install\ModulesController::class, 'index'])
            ->with('status', $output);
    }

    /**
     * Update: re-run migrations and bump version.
     */
    public function update()
    {
        if (!auth()->user()->can('manage_modules')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            Artisan::call('module:migrate', ['module' => 'Telegram', '--force' => true]);
            System::addProperty('telegram_version', $this->module_version);
            $output = ['success' => 1, 'msg' => 'Telegram module updated successfully!'];
        } catch (\Exception $e) {
            $output = ['success' => 0, 'msg' => $e->getMessage()];
        }

        return redirect()->action([\App\Http\Controllers\Install\ModulesController::class, 'index'])
            ->with('status', $output);
    }
}
