<?php

use Azuriom\Plugin\BlockClicker\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('index');
