<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>練習ブログ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    {{-- ナビゲーションバー --}}
    <nav class="bg-blue-50/80 shadow-sm border-b border-blue-100">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/posts" class="font-bold text-xl text-blue-600 tracking-tight">練習ブログ</a>
            
            <div class="flex items-center space-x-6">
                @auth
                    <span class="text-slate-600 text-sm font-medium">{{ Auth::user()->name }} さん</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-rose-500 hover:text-rose-700 text-sm font-semibold transition">
                            ログアウト
                        </button>
                    </form>
                @endauth
                @guest
                    <a href="/login" class="text-slate-600 hover:text-blue-600 text-sm font-medium">ログイン</a>
                    <a href="/register" class="text-slate-600 hover:text-blue-600 text-sm font-medium">新規登録</a>
                @endguest
            </div>
        </div>
    </nav>

    {{-- メインコンテンツ --}}
    <main class="max-w-5xl mx-auto px-4 py-10">
        {{-- ヘッダーエリア --}}
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">記事一覧</h1>
            <div class="flex gap-3">
                <a href="/dashboard" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition shadow-sm text-sm font-medium">
                    ダッシュボード
                </a>
                <a href="/posts/create" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-100 text-sm font-medium">
                    + 新規投稿
                </a>
            </div>
        </div>

        {{-- 記事グリッド --}}
        <div class="grid gap-6">
            @foreach($posts as $post)
                <div class="bg-blue-50/80 border border-blue-100 rounded-xl p-6 shadow-sm">
                    {{-- 投稿者情報 --}}
                    <div class="mb-4">
                        <h2 class="text-xl font-bold text-slate-800 mb-1">{{ $post->title }}</h2>
                        <div class="text-xs text-slate-400">
                            {{ $post->user->name }} | {{ $post->created_at->format('Y/m/d H:i') }}
                        </div>
                    </div>
                    
                    {{-- 記事本文 --}}
                    <p class="text-slate-600 leading-relaxed mb-6 break-all whitespace-pre-wrap">{{ $post->content }}</p>

                    {{-- --- 返信（コメント）セクション --- --}}
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 ml-6">Replies</h3>
                        
                        <div class="space-y-3 overflow-y-auto max-h-64 px-2 mb-4" style="scrollbar-width: thin;">
                            @forelse($post->comments as $comment)
                                <div class="bg-white/60 border border-blue-100 rounded-lg p-3 ml-6 shadow-sm">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-bold text-blue-600">{{ $comment->user->name }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $comment->created_at->format('m/d H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-slate-700 mb-3">{{ $comment->content }}</p>
                                    
                                    <div class="flex justify-between items-center">
                                        {{-- 返信用Good/Badボタン --}}
                                        <div class="flex gap-2">
                                            <form action="{{ route('comments.like', $comment) }}" method="POST">
                                                @csrf
                                                <button type="submit" name="is_good" value="1" class="text-[10px] flex items-center gap-1 px-2 py-1 rounded border bg-white hover:bg-blue-50 text-blue-600 transition">
                                                    👍 {{ $comment->likes()->where('is_good', true)->count() }}
                                                </button>
                                            </form>
                                            <form action="{{ route('comments.like', $comment) }}" method="POST">
                                                @csrf
                                                <button type="submit" name="is_good" value="0" class="text-[10px] flex items-center gap-1 px-2 py-1 rounded border bg-white hover:bg-rose-50 text-rose-500 transition">
                                                    👎 {{ $comment->likes()->where('is_good', false)->count() }}
                                                </button>
                                            </form>
                                        </div>

                                        {{-- 返信の削除ボタン --}}
                                        @auth
                                            @if($comment->user_id === Auth::id() || Auth::user()->isAdmin())
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('返信を削除しますか？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[10px] text-rose-400 hover:text-rose-600 transition">削除</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 ml-8 italic">返信はまだありません</p>
                            @endforelse
                        </div>

                        {{-- 返信投稿フォーム --}}
                        @auth
                            <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="ml-6 flex gap-2">
                                @csrf
                                <input type="text" name="content" placeholder="返信を書く..." class="flex-1 text-sm border-slate-200 rounded-lg p-2 outline-none focus:ring-2 focus:ring-blue-400" required>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded-lg text-sm font-bold hover:bg-blue-600 transition">送信</button>
                            </form>
                        @endauth
                    </div>

                    {{-- 記事本体のアクションエリア --}}
                    <div class="flex justify-between items-center border-t border-blue-100/50 pt-4">
                        {{-- 左側：記事へのリアクション --}}
                        <div class="flex gap-2">
                            <form action="{{ route('posts.like', $post) }}" method="POST">
                                @csrf
                                <input type="hidden" name="is_good" value="1">
                                <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-blue-100 bg-white text-blue-600 hover:bg-blue-50 transition text-sm shadow-sm">
                                    👍 {{ $post->likes()->where('comment_id', null)->where('is_good', true)->count() }}
                                </button>
                            </form>
                            <form action="{{ route('posts.like', $post) }}" method="POST">
                                @csrf
                                <input type="hidden" name="is_good" value="0">
                                <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-rose-100 bg-white text-rose-500 hover:bg-rose-50 transition text-sm shadow-sm">
                                    👎 {{ $post->likes()->where('comment_id', null)->where('is_good', false)->count() }}
                                </button>
                            </form>
                        </div>

                        {{-- 右側：管理ボタン（本人 or 管理者） --}}
                        @auth
                            @if($post->user_id === Auth::id() || Auth::user()->isAdmin())
                                <div class="flex gap-1">
                                    <a href="/posts/{{ $post->id }}/edit" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold px-3 py-1 rounded-md hover:bg-indigo-50 transition">編集</a>
                                    <form action="/posts/{{ $post->id }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" class="inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button class="text-rose-500 hover:text-rose-700 text-sm font-semibold px-3 py-1 rounded-md hover:bg-rose-50 transition">削除</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ページネーション --}}
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    </main>
</body>
</html>