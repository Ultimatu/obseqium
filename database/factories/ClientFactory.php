<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'job_title' => fake()->jobTitle(),
            'sector' => fake()->randomElement(['industrie', 'btp', 'sante', 'agroalimentaire', 'logistique', 'services']),
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement(['Abidjan', 'Bouaké', 'San-Pédro', 'Yamoussoukro']),
            'country' => 'CI',
            'notes' => null,
            'is_active' => true,
        ];
    }
}
