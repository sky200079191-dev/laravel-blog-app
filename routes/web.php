<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CommentController;

// --- 誰でも見れるページ ---
Route::get('/posts', [PostController::class, 'indexView']);

// --- ログインしないと見れないページ（グループ化） ---
Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'createView']);
    Route::post('/posts', [PostController::class, 'storeView']);
    Route::get('/posts/{post}/edit', [PostController::class, 'editView']);
    Route::put('/posts/{post}', [PostController::class, 'updateView']);
    Route::delete('/posts/{post}', [PostController::class, 'destroyView']);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breezeが作ったダッシュボード等のルート
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// good機能用のルート
Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');

require __DIR__.'/auth.php';

// 返信の保存
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store')->middleware('auth');

// 返信へのGood/Bad
Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like')->middleware('auth');

// // ローカル環境だけで使う緊急用ルート
// Route::get('/migrate-debug', function () {
//     try {
//         Artisan::call('migrate', ['--force' => true]);
//         return "マイグレーション成功！テーブルが作成されました。";
//     } catch (\Exception $e) {
//         return "エラー発生: " . $e->getMessage();
//     }
// });