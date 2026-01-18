<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg border border-blue-200">
                <div class="p-10 text-center"> <div class="mb-8">
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Status</span>
                        <h3 class="mt-4 text-2xl font-bold text-blue-900">ログインしました！</h3>
                        <p class="mt-2 text-slate-500">今日も素晴らしい記事を投稿しましょう。</p>
                    </div>
                    
                    <div class="flex justify-center">
                        <a href="/posts" class="inline-flex items-center px-10 py-4 bg-indigo-600 border border-transparent rounded-xl font-bold text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none transition ease-in-out duration-150 shadow-xl shadow-indigo-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3v4a1 1 0 001 1h4"></path>
                            </svg>
                            ブログ一覧を見る
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>