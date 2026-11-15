<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'judul' => $this->faker->sentence(3),
        'penulis' => $this->faker->name(),
        'penerbit' => $this->faker->company(),
        'tahun_terbit' => $this->faker->year(),
        'stok' => $this->faker->numberBetween(1, 20),
    ];
}
}
