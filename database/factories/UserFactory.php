<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

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
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['user', 'user', 'user', 'editor']), // Más users que editors
            'avatar' => null, // Se puede generar con https://ui-avatars.com/api/?name=
            'bio' => fake()->optional(0.7)->sentence(20),
            'website' => fake()->optional(0.3)->url(),
            'twitter' => fake()->optional(0.4)->userName(),
            'facebook' => fake()->optional(0.3)->userName(),
            'instagram' => fake()->optional(0.4)->userName(),
            'is_active' => true,
            'last_login_at' => fake()->optional(0.8)->dateTimeBetween('-30 days', 'now'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
