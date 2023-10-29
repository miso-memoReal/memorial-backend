<?php

namespace Tests\Unit\Services;

use App\Http\Services\MemoService;
use App\Http\ValueObjects\Coordinate;
use App\Models\Memo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testGetNearbyMemos(): void
    {
        // Memo::factory()を10回呼び出して、10個の異なるメモを作成します。
        for ($i = 0; $i < 10; $i++) {
            Memo::factory()->create();
        }

        $memoService = app(MemoService::class);
        // MemoFactoryで使用されている座標の近くの座標を使用します。
        $coordinate = new Coordinate(35.691786495809346, 139.6967557074058);
        $memos = $memoService->getNearbyMemos($coordinate);

        // 期待するメモの数が10であることを確認します。
        $this->assertCount(10, $memos);
    }
}
