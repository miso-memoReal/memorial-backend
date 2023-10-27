<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index(float $x, float $y)
    {

        $distance = \DB::table('memos')
            ->select(\DB::raw('"id", "content", ST_Distance(\'SRID=4326;POINT(' . $x . ' ' . $y . ')\', memos."coordinate")'))
            ->whereRaw('ST_Distance(\'SRID=4326;POINT(' . $x . ' ' . $y . ')\', memos."coordinate") < 50')
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
