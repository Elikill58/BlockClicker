<?php

use Azuriom\Plugin\BlockClicker\Controllers\APIController;
use Illuminate\Support\Facades\Route;

Route::get('/click', [APIController::class, 'click'])->name('click');
Route::get('/random', [APIController::class, 'getRandom'])->name('random');

?>