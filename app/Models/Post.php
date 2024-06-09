<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        // 使用內建的【belongsTo】函數，用來闡明關係；
        // 接受兩個參數：
        // 1. 和 Post Model class 關聯的 Model class
        // 2. foreign key 的欄位名稱
        return $this->belongsTo(User::class, 'user_id');
    }
}
