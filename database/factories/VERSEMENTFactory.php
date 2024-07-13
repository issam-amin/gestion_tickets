<?php

namespace Database\Factories;

use App\Models\regisseur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VERSEMENT>
 */
class VERSEMENTFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            '0.5' => $this->faker->randomDigit(),
            '1' => $this->faker->randomDigit(),
            '2' => $this->faker->randomDigit(),
            '5' => $this->faker->randomDigit(),
            '50' => $this->faker->randomDigit(),
            'somme' => $this->faker->randomDigit(),
            'regisseur_id' =>regisseur::factory(),
        ];
    }
}
