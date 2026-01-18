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
<form action="/posts/{{ $post->id }}" method="POST">
    @csrf
    @method('PUT') <div class="mb-4">
        <label>タイトル</label>
        <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full p-2 border">
    </div>
    <div class="flex items-center justify-between mt-6">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            {{ isset($post) ? '更新する' : '投稿する' }}
        </button>
        <a href="/posts" class="text-gray-500 hover:underline text-sm">
            一覧に戻る
        </a>
    </div>
    <div class="mb-4">
        <label>本文</label>
        <textarea name="content" class="w-full p-2 border">{{ old('content', $post->content) }}</textarea>
    </div>
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新する</button>
</form>
</body>
</html>