<?php

namespace Database\Factories;

use App\Models\DiagnosticRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiagnosticRequest>
 */
class DiagnosticRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->name(),
            'client_email' => $this->faker->unique()->safeEmail(),
            'client_phone' => $this->faker->phoneNumber(),
            'client_company' => $this->faker->company(),
            'client_address' => $this->faker->address(),
            'sector' => $this->faker->randomElement(['Santé', 'BTP', 'Industrie', 'Services', 'Agroalimentaire', 'Transport']),
            'company_size' => $this->faker->randomElement(['micro', 'small', 'medium', 'large']),
            'requested_standards' => $this->faker->randomElements(['ISO 9001', 'ISO 14001', 'ISO 45001'], $this->faker->numberBetween(1, 3)),
            'requested_date' => $this->faker->dateBetween('now', '+30 days'),
            'status' => $this->faker->randomElement(['requested', 'scheduled', 'completed']),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function requested(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'requested',
            'scheduled_date' => null,
            'completed_date' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'scheduled',
            'scheduled_date' => now()->addDays(rand(1, 14)),
            'completed_date' => null,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'scheduled_date' => now()->subDays(rand(1, 7)),
            'completed_date' => now()->subDays(rand(1, 3)),
            'overall_gap_level' => fake()->randomElement(['low', 'medium', 'high']),
            'gaps_identified' => fake()->paragraph(),
            'recommendations' => fake()->paragraphs(2, true),
        ]);
    }

    public function converted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'completed_date' => now()->subDays(rand(5, 10)),
            'converted_at' => now()->subDays(rand(1, 3)),
        ]);
    }
}
