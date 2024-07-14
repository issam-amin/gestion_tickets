<?php

namespace Database\Factories;

use App\Models\CR;
use App\Models\CU;
use App\Models\regisseur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CR>
 */
class CRFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'user_id' =>User::factory(),
            'cr_name' => $this->faker->name(),
        ];
    }
}
