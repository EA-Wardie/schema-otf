<?php

use Illuminate\Support\Facades\Route;

if (app()->isLocal()) {
    Route::get('/test', function () {
        dd('test');
    });
}
