<?php

namespace App\Http\Controllers;

class MemoController extends Controller
{
    public function index($x, $y)
    {
        // $x = $x;
        // $y = $y;
        // $point1 = \DB::select('select ST_GeomFromText(\'POINT(139.76 35.27)\', 4326)');
        // $point2 = \DB::select('select ST_GeomFromText(\'POINT(139.75 35.69)\', 4326)');

        // // point1 ... ユーザの座標　　point2 ... メモの座標
        // $distance = \DB::select('select ST_DistanceSphere(:point1、:point2) from memos');
        // $raw = 'select * from memos where $distance <= 50';
        // return view('memo', ['distance' => $distance]);

        $distance = \DB::select('select * from memos');

        // where ST_Distance(ST_GeomFromText(\'POINT(139.1235 69.3521)\',4326), ST_GeomFromText(\'POINT(139.1235 35.3521)\',4326)) <= 50
        return response()->json($distance);
    }
}
