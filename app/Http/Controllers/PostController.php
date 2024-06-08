<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function storeNewPost()
    {
    }

    public function showCreateForm()
    {
        return view('create-post');
    }
}