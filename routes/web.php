<?php

use Illuminate\Support\Facades\Route;
// import 我們建立的 controller
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExampleController;

Route::get('/', [ExampleController::class, 'homepage']);

Route::get(
    '/about',
    // return '<h1>About page</h1><a href="/">Back to home</a>';
    [ExampleController::class, 'aboutpage']
);

Route::post('/register', [UserController::class, 'register']);
