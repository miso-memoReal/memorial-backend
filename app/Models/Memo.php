<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Memo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
    ];

    /**
     * @return Attribute<mixed, mixed>
     */
    public function coordinate(): Attribute
    {
        return Attribute::make(
            set: static function ($point) {
                return DB::raw("ST_GeomFromGeoJSON('".json_encode($point, JSON_THROW_ON_ERROR)."')");
            }
        );
    }
}
