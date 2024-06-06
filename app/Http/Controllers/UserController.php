<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 在函數中添加 Request $request，來取得 form 表單提交後傳送的所有資料
    public function register(Request $request)
    {
        // $request->validate() 用來制定表單欄位的各種規則
        $incomingFields = $request->validate(
            [
                'username' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]
        );
        // 使用 User Model 將表單送來的資料存入資料庫中
        User::create($incomingFields);
        // dd($incomingFields);
        return 'Hello from register function';
    }
}
