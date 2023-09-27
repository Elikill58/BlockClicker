<?php

use Azuriom\Plugin\BlockClicker\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::middleware('can:blockerclicker.admin')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::post('setting', [SettingController::class, 'save'])->name('setting.update');
});
