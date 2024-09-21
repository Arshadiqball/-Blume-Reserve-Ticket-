<?php

namespace Database\Factories;

use App\Models\BRT;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BRTFactory extends Factory
{
    protected $model = BRT::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Assuming BRT belongs to a User
            'brt_code' => $this->faker->unique()->word, // Or use uniqid('BRT-')
            'reserved_amount' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['active', 'expired']),
        ];
    }
}
