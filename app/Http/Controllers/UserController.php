<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // 在函數中添加 Request $request，來取得 form 表單提交後傳送的所有資料
    public function register(Request $request)
    {
        // $request->validate() 用來制定表單欄位的各種驗證規則
        $incomingFields = $request->validate(
            [
                // 這裡使用內建的 Rule class 的 unique method；第一個參數是資料庫中的某資料表名稱，第二個參數是該資料表中的某一個欄位名稱
                'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => ['required', 'min:8', 'confirmed']
            ]
        );
        // 使用 User Model 將表單送來的資料存入資料庫中
        User::create($incomingFields);
        // dd($incomingFields);
        return 'Hello from register function';
    }
}
