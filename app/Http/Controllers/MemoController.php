<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index(float $longitude, float $latitude)
    {
        $distance = \DB::table('memos')
            ->select(
                \DB::raw('"id", "content", ST_Distance(\'SRID=4326;POINT(' . $longitude . ' ' . $latitude . ')\', memos."coordinate")'),
                \DB::raw('ST_X(ST_AsText(memos."coordinate")) as longitude'),
                \DB::raw('ST_Y(ST_AsText(memos."coordinate")) as latitude'),
                \DB::raw('ST_Distance(ST_MakePoint(' . $latitude . ', ' . $longitude . ')::geography, memos."coordinate")')
            )
            ->whereRaw('ST_Distance(\'SRID=4326;POINT(' . $longitude . ' ' . $latitude . ')\', memos."coordinate") < 50')
            ->limit(10)->get();



        return response()->json($distance);
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
