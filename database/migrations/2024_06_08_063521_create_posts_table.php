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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // longText( ) 用於在資料表中建立大型文字欄位。與 string() 相比，longText() 可以儲存更多的文字
            $table->longText('content');

            // 使用到 【foreignId ( )】 這個資料類型，它的參數【 user_id 】代表名為「User」的 model、代表名為 「id」的欄位
            // constrained () 用來確保 foreign key 的值一定存在於參考的資料表中
            // 【onDelete ( )】：如此參考的資料表內的某筆資料被刪除時，和該筆資料相關聯的資料也會跟著一起被刪除
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
