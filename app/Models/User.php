<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // 表示這些名稱允許出現在傳入的陣列中
    protected $fillable = [
        'username',
        'email',
        'password',
    ];


    // laravel 中的【 accessor 】；注意函數的名稱重要，他會是資料表中的某個欄位名稱
    protected function avatar(): Attribute
    {
        // $value 參數是資料表中 avatar 欄位的值
        return Attribute::make(get: function ($value) {
            return $value ? '/storage/avatars/' . $value : '/fallback-avatar.jpg';
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        // hasMany 是 Laravel Eloquent 中的一個方法，用來定義一對多的關係
        return $this->hasMany(Post::class, 'user_id');
    }
}
