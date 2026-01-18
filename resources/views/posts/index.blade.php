<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>konchanブログ</title>
    <script src="https://cdn.tailwindcss.com"></script> 
</head>
<body class="bg-gray-100 p-10">
    <nav class="bg-blue-50/80 shadow mb-8">
        <div class="max-w-4xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/posts" class="font-bold text-lg text-blue-600">konchanブログ</a>
            
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-gray-600 text-sm">{{ Auth::user()->name }} さん</span>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                            ログアウト
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="/login" class="text-gray-600 hover:text-blue-600 text-sm">ログイン</a>
                    <a href="/register" class="text-gray-600 hover:text-blue-600 text-sm">新規登録</a>
                @endguest
            </div>
        </div>
    </nav>
    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">記事一覧</h1>
            <div class="flex gap-3">
                <a href="/dashboard" class="px-5 py-2.5 bg-blue-50/80 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition shadow-sm text-sm font-medium">ダッシュボード</a>
                <a href="/posts/create" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-100 text-sm font-medium">+ 新規投稿</a>
            </div>
        </div>

        <div class="grid gap-6">
            @foreach($posts as $post)
                <div class="bg-blue-50/80 border border-blue-100 rounded-xl p-6 shadow-sm shadow-blue-900/5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">{{ $post->title }}</h2>
                            <div class="flex items-center gap-4 text-xs text-slate-400">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $post->user->name }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $post->created_at->format('Y/m/d H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-slate-600 leading-relaxed mb-6 break-all whitespace-pre-wrap">{{ $post->content }}</p>

                    @if($post->user_id === Auth::id())
                        <div class="flex justify-end gap-3 border-t border-slate-50 pt-4">
                            <a href="/posts/{{ $post->id }}/edit" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold px-3 py-1 rounded-md hover:bg-indigo-50 transition">編集</a>
                            <form action="/posts/{{ $post->id }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf @method('DELETE')
                                <button class="text-rose-500 hover:text-rose-700 text-sm font-semibold px-3 py-1 rounded-md hover:bg-rose-50 transition">削除</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
            <div class='mt-8 px-4'>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</body>
</html>