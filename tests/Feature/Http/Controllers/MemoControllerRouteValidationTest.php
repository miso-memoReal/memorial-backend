<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoControllerRouteValidationTest extends TestCase
{
    use RefreshDatabase;

    public function testValidCoordinates(): void
    {
        // 正しい座標値（小数点以下7桁）を使用してリクエストを送信
        $response = $this->getJson('/api/memo/139.6917000/35.6895000');

        // 200 OKのレスポンスを期待
        $response->assertStatus(200);
    }

    public function testInvalidLongitude(): void
    {
        // 無効な経度値を使用してリクエストを送信
        $response = $this->getJson('/api/memo/invalid/35.6895000');

        // 400 Bad Requestのレスポンスを期待
        $response->assertStatus(400);
    }

    public function testInvalidLatitude(): void
    {
        // 無効な緯度値を使用してリクエストを送信
        $response = $this->getJson('/api/memo/139.6917000/invalid');

        // 400 Bad Requestのレスポンスを期待
        $response->assertStatus(400);
    }

    public function testInvalidDigitsLongitude(): void
    {
        // 無効な経度値（小数点以下の桁数が7桁以上）を使用してリクエストを送信
        $response = $this->getJson('/api/memo/139.12345678/35.689500');

        // 400 Bad Requestのレスポンスを期待
        $response->assertStatus(400);
    }

    public function testInvalidDigitsLatitude(): void
    {
        // 無効な緯度値（小数点以下の桁数が7桁以上）を使用してリクエストを送信
        $response = $this->getJson('/api/memo/139.691700/35.12345678');

        // 400 Bad Requestのレスポンスを期待
        $response->assertStatus(400);
    }
}
