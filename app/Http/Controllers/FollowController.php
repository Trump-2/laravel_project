<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function createFollow(User $user)
    {
        // 不能追隨自己的邏輯
        if (auth()->user()->id == $user->id) {
            return back()->with('failure', 'You cannot follow yourself.');
        }

        // 不能追隨已經追隨過的人的邏輯
        // where() 等同於 sql 語法中的 where 子句；整行的意思是說資料表中有幾筆紀錄的 user_id 欄位和 followeduser 欄位的值等於指定的值；如果大於 0 則代表登入的使用者已經追蹤某個使用者了
        $existCheck = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();


        if ($existCheck) {
            return back()->with('failure', 'You are already following that user.');
        }

        // 這是另一種在資料表創造紀錄的方式
        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        // 之前的方式；但必須進入對應的 Model 中，創造 $fillable
        // Follow::create([]);

        return back()->with('success', 'User successfully followed.');
    }

    public function removeFollow()
    {
    }
}
