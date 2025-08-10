<?php

namespace Database\Factories;

use App\Models\Employer;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employer_id' => Employer::factory(),
            'title' => fake()->streetName(),
            'description' => fake()->paragraph(),
        ];
    }

    public function forEmployer($employer)
    {
        return $this->state(function (array $attributes) use ($employer) {
            return [
                'employer_id' => $employer->id,
            ];
        });
    }
}
