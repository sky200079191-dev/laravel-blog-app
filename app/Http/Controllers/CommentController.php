<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // 返信を保存する
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|max:200',
        ]);

        $post->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return back();
    }

    // 返信にGood/Badする
    public function like(Request $request, Comment $comment)
    {
        $userId = Auth::id();
        $isGood = $request->is_good;

        // すでに同じ返信にリアクションしているか確認
        $existingLike = Like::where('user_id', $userId)
                            ->where('comment_id', $comment->id)
                            ->first();

        if ($existingLike) {
            if ($existingLike->is_good == $isGood) {
                $existingLike->delete(); // 同じボタンなら取り消し
            } else {
                $existingLike->update(['is_good' => $isGood]); // 違うボタンなら上書き
            }
        } else {
            Like::create([
                'user_id' => $userId,
                'comment_id' => $comment->id,
                'is_good' => $isGood,
            ]);
        }

        return back();
    }

    // 管理者権限で返信文を削除する
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        $comment->delete();
        return back();
    }
}
