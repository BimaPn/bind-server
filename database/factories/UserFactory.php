<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;

    public function definition()
    {
        return [
            'id' => fake()->unique()->uuid(),
            'name' => fake()->name(),
            'username' => fake()->unique()->username(),
            'phone' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'address' => fake()->address(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'profile_picture' => fake()->imageUrl(),
            'cover_photo' => fake()->imageUrl(),
            'bio' => fake()->paragraph(2),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $userRole = Role::findByName('User', 'web');
            $user->assignRole($userRole);
        });
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
