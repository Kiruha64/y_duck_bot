<?php

use Illuminate\Support\Facades\Route;


Route::group([], static function () {
    Route::post('/trello/webhook', [\App\Http\Controllers\TrelloController::class, 'handleWebhook']);


});

