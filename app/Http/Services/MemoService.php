<?php

namespace App\Http\Services;

use App\Http\ValueObjects\Coordinate;
use Illuminate\Support\Collection;

class MemoService
{
    /**
     * @return Collection<int, \stdClass>
     */
    public function getNearbyMemos(Coordinate $coordinate): Collection
    {
        $point = $coordinate->toPoint();

        return \DB::table('memos')
            ->select(['id', 'content', \DB::raw("ST_Distance('{$point}', memos.\"coordinate\") as distance")])
            ->whereRaw('ST_Distance('.\DB::getPdo()->quote($point).', memos."coordinate") < 50')
            ->orderBy('distance', 'asc')
            ->limit(10)
            ->get();
    }
}
