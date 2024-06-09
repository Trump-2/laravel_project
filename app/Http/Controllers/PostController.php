<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function viewSinglePost(Post $id)
    {
        // 存取資料表中某筆紀錄的 title 欄位值
        // return $id->title;

        // 使用內建的【Str :: markdown ( )】讓 laravel 支援「markdown」語法；該方法接受一參數，該參數會被解讀為 markdown，然後方法會回傳 html code
        // strip_tags( ) 的第二個參數用來指定允許的 html tags
        $outHtml = strip_tags(Str::markdown($id->content), '<strong><ol><ul><li><h1><h2><h3><p><br>');
        $id->content = $outHtml;
        return view('single-post', ['post' => $id]);
    }
    //
    public function storeNewPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // 使用 php 的 strip_tags ( ) 來刪除使用者提供的資料中包含的 html 標籤
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
