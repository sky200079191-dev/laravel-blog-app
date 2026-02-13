<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // データベースにあるpost(記事)をすべて取得して、JSON形式で返す
        return Post::all();
    }

    public function store(Request $request)
    {
        // 1.バリデーション（受け入れ基準の設定）
        $validated = $request->validate([
            'title'   => 'required|max:255', // 必須かつ255文字以内
            'content' => 'required'          // 必須
        ]);

        // 2.データの保存
        // validatedにはチェックを通った安全なデータだけが入っている
        $post = Post::create($validated);

        // 3.レスポンス（201 Createdを返すのがAPIの作法）
        return response()->json($post,211);
    }

    // 特定の記事を更新する
    public function update(Request $request, Post $post)
    {
        // 1. バリデーション（新規作成時と同じ基準）
        $validated = $request->validate([
            'title'   => 'required|max:255',
            'content' => 'required',
        ]);

        // 2. データを上書き保存
         $post->update($validated);

        // 3. 更新後のデータを返す
        return response()->json($post);
    }

    // 特定の記事を削除する
    public function destroy(Post $post)
    {
        // データベースから削除
        $post->delete();

        // 「中身はないけど成功したよ（204 No Content）」と返却
        return response()->json(null, 204);
    }

    // APIではなくて画面でも表示する用
    public function indexView()
    {
        // 'posts' という名前のBladeファイルに、取得したデータを渡して表示する
        $posts = Post::with('user')
                    ->orderBy('updated_at', 'desc')
                    ->paginate(5);
        return view('posts.index', ['posts' => $posts]);
    }

    // 入力画面を表示
    public function createView()
    {
        return view('posts.create');
    }

    // 画面からの入力を保存
    public function storeView(Request $request)
    {
        // APIと同じバリデーションを適用
        $validated = $request->validate([
            'title'   => 'required|max:255',
            'content' => 'required',
        ]);

        // ログイン中のユーザーのIDをセット
        $validated['user_id'] = Auth::id();

        Post::create($validated);

        // 保存が終わったら一覧画面に戻る
        return redirect('/posts');
    }

    // 編集画面を表示
    public function editView(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    // データを更新
    public function updateView(Request $request, Post $post)
    {
        // 本人確認：記事の所有者とログイン中のユーザーが一致するか
        if ($post->user_id !== Auth::id()) {
            abort(403, '自分の記事以外は編集できません。');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        $post->update($validated);
        return redirect('/posts');
    }

    // データを削除
    public function destroyView(Post $post)
    {
        // 本人確認
        if ($post->user_id !== Auth::id()) {
            abort(403, '自分の記事以外は削除できません。');
        }

        $post->delete();
        return redirect('/posts');
    }
}
