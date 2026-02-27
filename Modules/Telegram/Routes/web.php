<?php

use Illuminate\Support\Facades\Route;
use Modules\Telegram\Http\Controllers\TelegramSettingsController;
use Modules\Telegram\Http\Controllers\InstallController;

Route::group([
    'middleware' => ['web', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu', 'CheckUserLogin'],
], function () {
    // Main settings page
    Route::get('/telegram-settings', [TelegramSettingsController::class, 'index'])->name('telegram-settings');
    Route::post('/telegram-settings', [TelegramSettingsController::class, 'store'])->name('telegram-settings.store');

    // Self-service connect flow
    Route::post('/telegram-settings/generate-token', [TelegramSettingsController::class, 'generateToken'])->name('telegram-settings.generate-token');
    Route::post('/telegram-settings/verify', [TelegramSettingsController::class, 'verifyConnection'])->name('telegram-settings.verify');
    Route::post('/telegram-settings/disconnect', [TelegramSettingsController::class, 'disconnect'])->name('telegram-settings.disconnect');

    // Module lifecycle — resolved by ModulesController via action() helper
    Route::get('/modules/telegram/install', [InstallController::class, 'index']);
    Route::get('/modules/telegram/update', [InstallController::class, 'update']);
    Route::get('/modules/telegram/uninstall', [InstallController::class, 'uninstall']);
});