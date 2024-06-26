<?php

use App\Events\ChatMessage;
// import 我們建立的 controller
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\MustBeLoggedIn;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;


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
Route::get('/manage-avatar', [UserController::class, 'showAvatarForm'])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar', [UserController::class, 'storeAvatar'])->middleware('mustBeLoggedIn');

// Follow related routes
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow'])->middleware('mustBeLoggedIn');
Route::post('/remove-follow/{user:username}', [FollowController::class, 'removeFollow'])->middleware('mustBeLoggedIn');

// Blog post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('mustBeLoggedIn');
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
// 示範在 route 中使用自定義的 policy
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'update'])->middleware('can:update,post');
Route::get('/search/{term}', [PostController::class, 'search']);

// Profile related routes
// 參數的後面加上【 : 在資料表中作為查找依據的欄位名稱】
Route::get('/profile/{user:username}', [UserController::class, 'showProfile']);
Route::get('/profile/{user:username}/followers', [UserController::class, 'profileFollowers']);
Route::get('/profile/{user:username}/following', [UserController::class, 'profileFollowing']);

// chat route
Route::post('/send-chat-message', function (Request $request) {
    $formFields = $request->validate([
        'textvalue' => 'required'

    ]);

    // 如果為 true，代表使用者沒有輸入任何有效的內容
    if (!trim(strip_tags($formFields['textvalue']))) {
        // 對於請求，不回應任何東西的意思
        return response()->noContent();
    }

    // 使用內建【broadcast( )】，來廣播訊息；接受 event 的實體作為參數
    // 傳入需要的資料給 ChatMessage event
    broadcast(new ChatMessage(['username' => auth()->user()->username, 'textvalue' => strip_tags($request->textvalue), 'avatar' => auth()->user()->avatar]))->toOthers();
    // 對於請求，不回應任何東西的意思
    return response()->noContent();
})->middleware('mustBeLoggedIn');
