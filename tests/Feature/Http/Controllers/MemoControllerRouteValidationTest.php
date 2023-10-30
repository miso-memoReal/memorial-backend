<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoControllerRouteValidationTest extends TestCase
{
    use RefreshDatabase;

    public function testValidCoordinates(): void
    {
        // 正しい座標値を使用してリクエストを送信
        $response = $this->getJson('/api/memo/139.6917/35.6895');

        // 200 OKのレスポンスを期待
        $response->assertStatus(200);
    }

    public function testInvalidLongitude(): void
    {
        // 無効な経度値を使用してリクエストを送信
        $response = $this->getJson('/api/memo/invalid/35.6895');

        // 404 Not Foundのレスポンスを期待
        $response->assertStatus(400);
    }

    public function testInvalidLatitude(): void
    {
        // 無効な緯度値を使用してリクエストを送信
        $response = $this->getJson('/api/memo/139.6917/invalid');

        // 404 Not Foundのレスポンスを期待
        $response->assertStatus(400);
    }
}
