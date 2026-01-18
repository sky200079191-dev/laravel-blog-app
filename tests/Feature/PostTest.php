<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class PostTest extends TestCase
{
    use RefreshDatabase; //テストごとにデータをリセットする設定

    /** @test */
    public function test_can_save_post_to_database()
    {
        // 1.準備：保存したいデータを作る
        $data =[
            'title' => '初めてのテスト記事',
            'content' => 'テスト本文です。',
        ];

        // 2.実行：モデルを使って保存する
        Post::create($data);

        // 3.検証：データベースにそのデータが存在するか確認する
        $this->assertDatabaseHas('posts', $data);
        
    }
}
