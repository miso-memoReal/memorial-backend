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

    private int $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        ++$this->index;

        $point = [
            'type' => 'Point',
            'coordinates' => [
                139.696755 + $this->index * 0.0001,  // 経度
                35.691706 + $this->index * 0.0001,  // 緯度
            ],
        ];

        return [
            'content' => $this->faker->realText(254),
            'coordinate' => $point,
        ];
    }
}
