<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            // 返信IDを保存する列を追加（nullでもOKにする）
            $table->foreignId('comment_id')->nullable()->constrained()->onDelete('cascade')->after('post_id');
            
            // 既存の post_id を「空でもOK」に変更（返信へのいいねの時は post_id は空になるため）
            $table->foreignId('post_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['comment_id']);
            $table->dropColumn('comment_id');
        });
    }
};
