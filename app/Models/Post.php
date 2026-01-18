<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
