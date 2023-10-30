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
        Memo::factory()->count(3)->create();
        $this->assertDatabaseCount('memos', 3);
        $response = $this->getJson('/api/memo/139.696982/35.691706');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
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
