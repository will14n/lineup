<?php

namespace Database\Factories;

use App\Enums\PlayerPosition;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;
use Illuminate\Support\Arr;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition()
    {
        $playerPosition = Arr::random(PlayerPosition::cases());

        return [
            'name' => $this->faker->name,
            'position' => $playerPosition->value,
        ];
    }
}
