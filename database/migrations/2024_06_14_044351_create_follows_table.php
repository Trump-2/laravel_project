<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            // 儲存著創造追蹤這件事情的使用者；foreignId() 會自動將某欄位設定為 foreign key
            // constrained() 會限制 user_id 欄位的值必須是在 user 資料表 id 欄位存在的
            $table->foreignId('user_id')->constrained();

            // 儲存著被追蹤的使用者
            $table->unsignedBigInteger('followeduser');
            // 手動將某欄位設定為 foreign key
            $table->foreign('followeduser')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
