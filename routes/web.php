<?php

use Illuminate\Support\Facades\Route;
// import 我們建立的 controller
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// User related routes
Route::get('/', [UserController::class, 'showCorrectHomepage']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

// Blog post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm']);
Route::post('/create-post', [PostController::class, 'storeNewPost']);