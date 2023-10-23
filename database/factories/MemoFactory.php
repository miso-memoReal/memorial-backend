<?php

namespace Database\Factories;

use App\Models\Memo;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $point = [
            'type' => 'Point',
            'coordinates' => [
                $latitude, // 経度
                $longitude, // 緯度
            ],
        ];

        return [
            'memoContent' => fake()->realText(254),
            'memoCoordinate' => $point,
        ];
    }
}
