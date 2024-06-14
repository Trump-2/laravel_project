<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    public function storeAvatar(Request $request)
    {

        $request->validate([
            // 代表此表單欄位的值必須是圖片類型且大小不能超過 3000 kilobytes
            'avatar' => 'required|image|max:3000'
        ]);

        // $request->file('avatar')->store('public/avatars');

        $user = auth()->user();

        // 產生一個獨一無二的檔案名稱
        $filename = $user->id . '-' . uniqid() . '.jpg';

        // 使用透過 composer 安裝的套件
        $manager = new ImageManager(new Driver());
        // 取得傳入的檔案
        $image = $manager->read($request->file('avatar'));
        // 調整檔案的大小並將其轉成 jpep 格式
        $imgData = $image->cover(120, 120)->toJpeg();
        // 使用 laravel 內建的【Storage】class，其裡面的 put ()
        // 此函數接受兩個參數：1. 路徑：儲存上傳檔案的資料夾和新的檔案名稱，2. 原始檔案
        Storage::put("public/avatars/$filename", $imgData);

        $oldAvatar = $user->avatar;


        // 更新某個 user 的 avatar 欄位值
        $user->avatar = $filename;

        // 將更新後的資料寫入資料庫中
        $user->save();

        // 代表在資料庫中 avatar 欄位原本是有值的
        if ($oldAvatar != '/fallback-avatar.jpg') {
            // $oldAvatar = /storage/avatars/xxx；而檔案存在的位置在 public/avatars/xxx
            // 所以使用 php 的 str_replace() 來替換部分字串，使路徑正確
            Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
        }

        return back()->with('success', 'Congrats on the new avatar');
    }
    public function showAvatarForm()
    {
        return view('avatar-form');
    }

    public function showProfile(User $user)
    {
        // 未登入時
        $currentlyFollowing = 0;

        // 使用者登入時
        if (auth()->check()) {
            $currentlyFollowing = Follow::where(['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id])->count();
        }

        return view('profile-posts', ['currentlyFollowing' => $currentlyFollowing, 'avatar' => $user->avatar, 'username' => $user->username, 'posts' => $user->posts()->latest()->get(), 'postCount' => $user->posts()->count()]);
    }
    // public function showProfile($user)
    // {
    //     return view('profile-posts');
    // }

    public function logout()
    {
        // auth()->logout() 用來登出使用者
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out.');
    }

    public function showCorrectHomepage()
    {
        // auth()->check() 用來檢查使用者是否已經登入，如果是則回傳 true、反之則為 false
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
            return redirect('/')->with('success', 'You have successfully logged in.');
        } else {
            return redirect('/')->with('failure', 'Invalid login.');
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
                // confirmed 是 Laravel 內建的驗證規則。其作用是確保兩個欄位的值一致。這個規則常用於確認密碼的輸入，但也可以用於其他欄位。當你在某個欄位上使用 confirmed 規則時，Laravel 會期待在請求中有另一個相同名稱並加上 _confirmation 後綴的欄位。

                //例如，如果你有一個名為 password 的欄位，並且你在它上面使用了 confirmed 規則，Laravel 會檢查請求中是否有一個名為 password_confirmation 的欄位。這兩個欄位的值必須匹配，驗證才會通過。
                'password' => ['required', 'min:8', 'confirmed']
            ]
        );

        // dd($incomingFields);

        // 將使用者輸入的密碼進行 hashing 處理
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // 使用 User Model 將表單送來的資料存入資料庫中
        $user = User::create($incomingFields);
        // dd($incomingFields);

        // 使用 auth()->login() 來登入使用者
        auth()->login($user);

        return redirect('/')->with('success', 'Thank you for creating an account');
    }
}
