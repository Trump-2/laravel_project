<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return '<h1>Home page</h1><a href="/about">View the about page</a>';
});

Route::get('/about', function () {
    return '<h1>About page</h1><a href="/">Back to home</a>';
});
