<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function showCorrectHomepage()
    {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        // laravel 內建的全域函數【auth ( )】中的【attempt ( )】會將資料庫中資料表中某筆紀錄的指定欄位值和使用者輸入的值進行比較，如果相同回傳 true、反之則為 false； 
        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return 'Congrats';
        } else {
            return 'Sorry...';
        }
    }

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
