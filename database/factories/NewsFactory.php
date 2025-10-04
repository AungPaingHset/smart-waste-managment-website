<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\YourModel>
 */
class YourModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'        => $this->faker->sentence(),
            'content'      => $this->faker->paragraphs(3, true),
            'image'        => $this->faker->optional()->imageUrl(640, 480, 'posts', true),
            'is_published' => $this->faker->boolean(80), // 80% chance of being true
        ];
    }
}
