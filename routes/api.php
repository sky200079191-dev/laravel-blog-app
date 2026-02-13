<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// http://localhost/api/posts にアクセスが来たら PostController の index メソッドを実行する
Route::get('/posts', [PostController::class, 'index']);

Route::post('/posts', [PostController::class, 'store']);
// 更新：PUTメソッド（例：/api/posts/1）
Route::put('/posts/{post}', [PostController::class, 'update']);

// 削除：DELETEメソッド（例：/api/posts/1）
Route::delete('/posts/{post}', [PostController::class, 'destroy']);