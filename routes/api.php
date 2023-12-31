<?php

use Azuriom\Plugin\BlockClicker\Controllers\APIController;
use Illuminate\Support\Facades\Route;

Route::middleware('web', 'auth')->group(function () {
    Route::post('/click', [APIController::class, 'click'])->name('click');
    Route::get('/random', [APIController::class, 'getRandom'])->name('random');
    Route::get('/mined', [APIController::class, 'getAllMinedBlocks'])->name('mined');
    Route::post('/send', [APIController::class, 'sendToServer'])->name('send');
    Route::post('/trash', [APIController::class, 'trash'])->name('trash');
});

?>