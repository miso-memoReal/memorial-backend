<?php

namespace App\Http\Services;

use App\Http\ValueObjects\Coordinate;
use App\Models\Memo;
use DB;
use Illuminate\Support\Collection;

// 距離閾値
const DISTANCE_THRESHOLD = 50;
// 件数上限
const LIMIT = 10;

class MemoService
{
    /**
     * @return Collection<int, \stdClass>
     */
    public function getNearbyMemos(Coordinate $coordinate): Collection
    {
        $point = $coordinate->toPoint();

        return DB::table('memos')
            ->select([
                'id', 'content', DB::raw("ST_Distance('{$point}', memos.\"coordinate\") as distance"), DB::raw('ST_X(ST_AsText(memos."coordinate")) as longitude'),
                DB::raw('ST_Y(ST_AsText(memos."coordinate")) as latitude'),
            ])
            ->whereRaw('ST_Distance(' . DB::escape($point) . ', memos."coordinate") < ' . DISTANCE_THRESHOLD)
            ->orderBy('distance')
            ->limit(LIMIT)
            ->get();
    }

    public function registrationMemo(array $point, string $content)
    {

        return Memo::create([
            'content' => $content,
            'coordinate' => $point,
        ]);
    }
}
