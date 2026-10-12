<?php

namespace Database\Factories;

use App\Models\LibraryEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LibraryEvent>
 */
class LibraryEventFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startsAt = now()->addDays(fake()->numberBetween(1, 30))->setTime(9, 0);

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(2, true),
            'location' => fake()->randomElement(['Ruang Baca Lt. 2', 'Aula Perpustakaan', 'Ruang Diskusi A']),
            'starts_at' => $startsAt,
            'ends_at' => $startsAt->copy()->addHours(2),
        ];
    }

    public function past(): static
    {
        return $this->state(function (): array {
            $startsAt = now()->subDays(10)->setTime(9, 0);

            return [
                'starts_at' => $startsAt,
                'ends_at' => $startsAt->copy()->addHours(2),
            ];
        });
    }
}
