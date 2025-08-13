<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Employer;
use App\Models\Post;
use App\Models\Seeker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id'       => Post::factory(),
            'seeker_id'     => Seeker::factory(),
        ];
    }

    public function forPost($post)
    {
        return $this->state(function (array $attributes) use ($post) {
            return [
                'post_id' => $post->id,
            ];
        });
    }

    public function forSeeker($seeker)
    {
        return $this->state(function (array $attributes) use ($seeker) {
            return [
                'seeker_id' => $seeker->id,
            ];
        });
    }
}
