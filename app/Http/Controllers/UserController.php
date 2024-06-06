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
                // confirmed 是 Laravel 內建的驗證規則。其作用是確保兩個欄位的值一致。這個規則常用於確認密碼的輸入，但也可以用於其他欄位。當你在某個欄位上使用 confirmed 規則時，Laravel 會期待在請求中有另一個相同名稱並加上 _confirmation 後綴的欄位。

                //例如，如果你有一個名為 password 的欄位，並且你在它上面使用了 confirmed 規則，Laravel 會檢查請求中是否有一個名為 password_confirmation 的欄位。這兩個欄位的值必須匹配，驗證才會通過。
                'password' => ['required', 'min:8', 'confirmed']
            ]
        );

        // dd($incomingFields);

        // 將使用者輸入的密碼進行 hashing 處理
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // 使用 User Model 將表單送來的資料存入資料庫中
        User::create($incomingFields);
        // dd($incomingFields);
        return 'Hello from register function';
    }
}
