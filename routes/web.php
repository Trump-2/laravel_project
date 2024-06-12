<?php

use Illuminate\Support\Facades\Route;
// import 我們建立的 controller
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\MustBeLoggedIn;


Route::get('/admins-only', function () {
    return "Only admins should be able to see this page.";
})->middleware('can:visitAdminPages');

// User related routes
Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');
// 只有訪客可以訪問 /register，所以使用 middleware('guest')
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
// 只有訪客可以訪問 /login，所以使用 middleware('guest')
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
// 只有登入者可以訪問 /logout，所以使用 middleware('guest')
Route::post('/logout', [UserController::class, 'logout'])->middleware('mustBeLoggedIn');

// Blog post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('mustBeLoggedIn');
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
// 示範在 route 中使用自定義的 policy
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'update'])->middleware('can:update,post');


// Profile related routes
// 參數的後面加上【 : 在資料表中作為查找依據的欄位名稱】
Route::get('/profile/{user:username}', [UserController::class, 'showProfile']);
