<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;

class Post extends Model
{
    use HasFactory;
    
    // DBに保存できるカラムの種類を記載
    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        // この記事は一人のユーザーに属している
        return $this->belongsTo(User::class);
    }

    // 記事にgoodボタンを追加
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 記事にコメント返信機能を追加
    public function comments() 
    { 
        return $this->hasMany(Comment::class);
    }
}
