<?php

namespace Database\Factories;

use App\Models\Memo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Memo>
 */
class MemoFactory extends Factory
{
    protected $model = Memo::class;

//    private int $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
//        $coordinates = [
//            ['latitude' => 35.691786, 'longitude' => 139.696755],
//            ['latitude' => 35.691352, 'longitude' => 139.696894],
//            ['latitude' => 35.691463, 'longitude' => 139.697162],
//            ['latitude' => 35.691821, 'longitude' => 139.696918],
//            ['latitude' => 35.691422, 'longitude' => 139.696641],
//            ['latitude' => 35.692237, 'longitude' => 139.697435],
//        ];
//
//        $coordinate = $coordinates[$this->index];
//        $this->index = ($this->index + 1) % count($coordinates);

        $point = [
            'type' => 'Point',
            'coordinates' => [
                139.696755,  // 経度
                35.691706,  // 緯度
            ],
        ];

        return [
            'content' => $this->faker->realText(254),
            'coordinate' => $point,
        ];
    }
}
