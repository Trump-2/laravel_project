<?php

use Illuminate\Support\Facades\Route;
// import 我們建立的 controller
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\MustBeLoggedIn;

// User related routes
Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');
// 只有訪客可以訪問 /register，所以使用 middleware('guest')
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
// 只有訪客可以訪問 /login，所以使用 middleware('guest')
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
// 只有登入者可以訪問 /logout，所以使用 middleware('guest')
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Blog post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{id}', [PostController::class, 'viewSinglePost']);
