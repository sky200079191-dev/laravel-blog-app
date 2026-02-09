<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->boolean('is_good')->default(true);
            $table->timestamps();
            
            // 同じ人が同じ記事に同じ評価を重複してできないようにする
            $table->unique(['user_id', 'post_id', 'is_good']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
};