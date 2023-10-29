<?php

namespace App\Http\Controllers;

use App\Http\Services\MemoService;
use App\Http\ValueObjects\Coordinate;
use App\Models\Memo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    private MemoService $memoService;

    public function __construct(MemoService $memoService)
    {
        $this->memoService = $memoService;
    }

    public function locateNearbyMemos(float $longitude, float $latitude): JsonResponse
    {
        $coordinate = new Coordinate($longitude, $latitude);
        $memos = $this->memoService->getNearbyMemos($coordinate);

        return response()->json($memos);
    }

    public function store(Request $request)
    {

        $point = [
            'type' => 'Point',
            'coordinates' => [
                $request->input('latitude'),
                $request->input('longitude'),
            ],
        ];

        Memo::create([
            'content' => $request->input('content'),
            'coordinate' => $point,
        ]);

        return response()->json(200);
    }
}
