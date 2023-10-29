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
        $coordinates = [
            [35.691786495809346, 139.6967557074058],
            [35.691352701182204, 139.69689449407812],
            [35.69146374647899, 139.69716216795717],
            [35.691821005063105, 139.69691808693054],
            [35.69142235666152, 139.6966418193949],
            [35.692237868468176, 139.69743588503974],
        ];

        $coordinate = $coordinates[$this->index];
        $this->index = ($this->index + 1) % count($coordinates);

        $point = [
            'type' => 'Point',
            'coordinates' => [
                $coordinate[0],  // 緯度
                $coordinate[1],  // 経度
            ],
        ];

        return [
            'content' => $this->faker->realText(254),
            'coordinate' => $point,
        ];
    }
}
