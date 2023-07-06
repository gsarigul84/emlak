<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Emlakdetay>
 */
class EmlakdetayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'sef' => $this->faker->slug(),
          'baslik' => $this->faker->text(200),
          'aciklama' => $this->faker->text(200),
          'detay' => $this->faker->realText(500),
        ];
    }
}
