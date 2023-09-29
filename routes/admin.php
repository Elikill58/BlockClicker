<?php

use Azuriom\Plugin\BlockClicker\Controllers\Admin\BlocksController;
use Azuriom\Plugin\BlockClicker\Controllers\Admin\PlayersController;
use Azuriom\Plugin\BlockClicker\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('can:blockerclicker.admin')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::post('setting', [SettingController::class, 'save'])->name('setting.update');
    Route::resource('blocks', BlocksController::class);
    Route::resource('players', PlayersController::class);
});
