<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    // 和 laravel 的 scout 有關；代表這個 Model 是可被搜尋的
    use Searchable;

    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function toSearchableArray()
    {
        return [
            "title" => $this->title,
            "content" => $this->content
        ];
    }

    public function user()
    {
        // 使用內建的【belongsTo】函數，用來闡明關係；
        // 接受兩個參數：
        // 1. 和 Post Model class 關聯的 Model class
        // 2. foreign key 的欄位名稱
        return $this->belongsTo(User::class, 'user_id');
    }
}
