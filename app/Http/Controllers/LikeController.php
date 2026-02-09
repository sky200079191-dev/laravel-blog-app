<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // ログインチェック（未ログインならリダイレクト）
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // すでに同じ評価をしていれば削除、なければ作成
        $like = $post->likes()->where('user_id', Auth::id())
                              ->where('is_good', $request->is_good)
                              ->first();

        if ($like) {
            $like->delete();
        } else {
            $post->likes()->create([
                'user_id' => Auth::id(),
                'is_good' => $request->is_good
            ]);
        }

        return back();
    }
}