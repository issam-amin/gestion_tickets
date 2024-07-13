<?php

namespace Database\Factories;

use App\Models\regisseur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CU>
 */
class CUFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'regisseur_id' => regisseur::factory(),
            'user_id' =>User::factory(),
            'cu_name' => $this->faker->name(),
        ];
    }
}
