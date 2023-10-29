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

    public function index(float $x, float $y): JsonResponse
    {
        $coordinate = new Coordinate($x, $y);
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
