<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Memo extends Model
{
    use HasFactory;

    protected $primaryKey = 'memoID';

    protected $guarded = [
        'memoID',
    ];

    public function memoCoordinate(): Attribute
    {
        return Attribute::make(
            set: function ($point) {
                return DB::raw("ST_GeomFromGeoJSON('".json_encode($point)."')");
            }
        );
    }
}
