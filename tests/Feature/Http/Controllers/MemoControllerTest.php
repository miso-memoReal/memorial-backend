<?php

namespace Tests\Feature;

use App\Models\Memo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Memo::factory()->create();
        }
        $response = $this->getJson('/api/memo/35.691786495809346/139.6967557074058');
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
