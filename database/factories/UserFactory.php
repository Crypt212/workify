<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Nette\Utils\Random;

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
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'contact_info' => fake()->unique()->phoneNumber(),
            'identity' => fake()->boolean() ? 'employer' : 'seeker',
        ];
    }

    public function employer()
    {
        return $this->state(function (array $attributes) {
            return [
                'identity' => 'employer',
            ];
        });
    }

    public function seeker()
    {
        return $this->state(function (array $attributes) {
            return [
                'identity' => 'seeker',
            ];
        });
    }
}
