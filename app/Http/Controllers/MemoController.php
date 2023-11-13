<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocateNearbyMemosRequest;
use App\Http\Requests\RegistrationMemoRequest;
use App\Http\Services\MemoService;
use App\Http\ValueObjects\Coordinate;
use Illuminate\Http\JsonResponse;

class MemoController extends Controller
{
    private MemoService $memoService;

    public function __construct(MemoService $memoService)
    {
        $this->memoService = $memoService;
    }

    public function locateNearbyMemos(
        // HACK: パスパラメータのバリデーションのため
        LocateNearbyMemosRequest $_,
        float $longitude,
        float $latitude
    ): JsonResponse {
        $coordinate = new Coordinate(longitude: $longitude, latitude: $latitude);
        $memos = $this->memoService->getNearbyMemos($coordinate);

        return response()->json($memos);
    }

    public function store(RegistrationMemoRequest $request)
    {

        $validated = $request->validated();
        $validated = $request->safe()->only(['longitude', 'latitude', 'content']);

        $point = [
            'type' => 'Point',
            'coordinates' => [
                $validated['longitude'],
                $validated['latitude'],
            ],
        ];

        $content = $validated['content'];

        $this->memoService->registrationMemo($point, $content);

        return response()->json(200);
    }
}
