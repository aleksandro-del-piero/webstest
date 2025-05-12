<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('register', RegisterController::class);

Route::view('swagger', 'swagger');

Route::view('web-sockets', 'web-sockets');
