<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homepage()
    {
        return '<h1>Home page</h1><a href="/about">View the about page</a>';
    }

    public function aboutpage()
    {
        return '<h1>About page</h1><a href="/">Back to home</a>';
    }
}
