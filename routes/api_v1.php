<?php

use Illuminate\Support\Facades\Route;

// auth:sanctum
Route::name('api.')->group(static function () {
    include __DIR__ . '/api/v1/Index.php';
});
