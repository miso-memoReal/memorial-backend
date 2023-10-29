<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Memo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLocateNearbyMemos(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Memo::factory()->create(
                [
                    'coordinate' => [
                        'type' => 'Point',
                        'coordinates' => [
                            139.6967557074058,  // 経度
                            35.69170679264842,  // 緯度
                        ],
                    ],
                ]
            );
        }
        $this->assertDatabaseCount('memos', 10);
        $response = $this->getJson('/api/memo/139.6969821303339/35.69170679264842');
        $response->assertStatus(200);
        $response->assertJsonCount(10);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'content',
                'distance',
            ],
        ]);
    }
}
