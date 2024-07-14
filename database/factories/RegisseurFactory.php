<?php

namespace Database\Factories;

use App\Models\CR;
use App\Models\CU;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\regisseur>
 */
class RegisseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cu_id' => CU::factory(),
            'cr_id' => CR::factory(),
            'name' => fake()->name(),
        ];
    }
}
