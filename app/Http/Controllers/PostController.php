<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function viewSinglePost(Post $id)
    {
        // 存取資料表中某筆紀錄的 title 欄位值
        // return $id->title;

        return view('single-post', ['post' => $id]);
    }
    //
    public function storeNewPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // 使用 php 的 strip_tags ( ) 對使用者提供的資料進行處理
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['content'] = strip_tags($incomingFields['content']);

        // 從 session 中得到登入使用者所擁有的 id，透過使用內建的【auth(  ) -> id ( )】
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'New post successfully created');
    }

    public function showCreateForm()
    {
        return view('create-post');
    }
}
