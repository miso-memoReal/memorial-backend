<?php

namespace Database\Factories;

use App\Models\Memo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Memo>
 */
class MemoFactory extends Factory
{
    protected $model = Memo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $latitude = fake()->latitude;
        $longitude = fake()->longitude;

        return [
            'memoContent' => fake()->realText(254),
            'memoCoordinate' => DB::raw("ST_GeomFromText('POINT($latitude $longitude)')"),
        ];
    }
}
