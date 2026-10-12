<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),
            'excerpt' => fake()->sentence(18),
            'body' => fake()->paragraphs(4, true),
            'published_at' => now()->subDays(fake()->numberBetween(0, 30)),
        ];
    }

    public function scheduled(): static
    {
        return $this->state(fn (): array => [
            'published_at' => now()->addDays(3),
        ]);
    }
}
