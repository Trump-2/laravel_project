<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homepage()
    {
        $ourName = 'yihong';
        $animals = ['Meowsalot', 'Barkalot', 'Purrsloud'];

        // return '<h1>Home page</h1><a href="/about">View the about page</a>';

        // 傳遞參數給指定的 view 檔案
        return view('homepage', ['allAnimals' => $animals, 'name' => $ourName, 'catename' => 'Meowalot']);
    }

    public function aboutpage()
    {
        return '<h1>About page</h1><a href="/">Back to home</a>';
    }
}
