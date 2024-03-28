<?php

use Illuminate\Support\Facades\Route;


Route::group([], static function () {
    Route::prefix('email')->name('email.')->group(static function () {
        include __DIR__ . '/Email/email.php';
    });

    Route::prefix('telegram')->name('telegram.')->group(static function () {
        include __DIR__ . '/Telegram/telegram.php';
    });
});

