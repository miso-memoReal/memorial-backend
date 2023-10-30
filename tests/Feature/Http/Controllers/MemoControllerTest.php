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
        Memo::factory()->count(10)->create();
        $this->assertDatabaseCount('memos', 10);
        $response = $this->getJson('/api/memo/139.696982/35.691706');
        $response->assertStatus(200);
        $response->assertJsonCount(10);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'content',
                'distance',
                'longitude',
                'latitude'
            ],
        ]);
    }
}
