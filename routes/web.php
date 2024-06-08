<?php

use Illuminate\Support\Facades\Route;
// import 我們建立的 controller
use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, 'showCorrectHomepage']);


Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);