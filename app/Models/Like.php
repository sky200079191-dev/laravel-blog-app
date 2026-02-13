<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // DBに保存を許可する項目
    protected $fillable = ['user_id', 'post_id', 'comment_id', 'is_good'];

    // どの記事へのいいねか
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // 誰がしたいいねか
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // コメント返信機能
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}