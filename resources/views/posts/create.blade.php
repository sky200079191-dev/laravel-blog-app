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
    <div class="max-w-2xl mx-auto bg-blue-50/80 p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">新規記事投稿</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/posts" method="POST">
            @csrf <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">タイトル</label>
                <input type="text" name="title" class="w-full p-2 border rounded" value="{{ old('title') }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">本文</label>
                <textarea name="content" class="w-full p-2 border rounded" rows="5">{{ old('content') }}</textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                投稿する
            </button>
        </form>
    </div>
</body>
</html>