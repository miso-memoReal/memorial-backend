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
        // Memo::factory()を10回呼び出して、3個の異なるメモを作成します。
        Memo::factory()->count(3)->create();
        $this->assertDatabaseCount('memos', 3);

        $memoService = app(MemoService::class);
        // MemoFactoryで使用されている座標の近くの座標を使用します。
        $coordinate = new Coordinate(longitude: 139.696982, latitude: 35.691706);
        $memos = $memoService->getNearbyMemos($coordinate);

        // 期待するメモの数が3であることを確認します。
        $this->assertCount(3, $memos);
    }
}
