<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Employer;
use App\Models\Post;
use App\Models\Seeker;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        Skill::factory()->count(20)->create();

        Seeker::factory()->count(50)->create();
        Seeker::query()->get()->each(function ($seeker) {
            foreach(Skill::query()->inRandomOrder()->limit(4)->get() as $skill) {
                $seeker->skills()->attach($skill->id, [
                    'proficiency' => fake()->randomElement(['beginner', 'intermidiate', 'expert']),
                ]);
            }
        });

        $seeker = Seeker::query()->create([
            'role' => 'Tester',
            'user_id' => User::query()->create([
                'username' => 'seeker.tester',
                'name' => 'The Man Who Tests',
                'email' => 'seeker@testing.com',
                'password' => 'password',
            ])->id,
        ]);

        $skills = Skill::query()->inRandomOrder()->limit(4)->get();
        foreach ($skills as $skill) {
            $seeker->skills()->attach($skill->id, [
                'proficiency' => fake()->randomElement(['beginner', 'intermidiate', 'expert']),
            ]);
        }

        Employer::query()->create([
            'organization_name' => 'Testing Realm',
            'user_id' => User::query()->create([
                'username' => 'employer.tester',
                'name' => 'Also The Man Who Tests',
                'email' => 'employer@testing.com',
                'password' => 'password',
            ])->id,
        ]);

        Tag::factory()->count(30)->create();

        Employer::factory()->count(10)->has(
            Post::factory()->count(10)->hasAttached(
                Tag::query()->inRandomOrder()->limit(4)->get()
            )->hasAttached(
                Skill::query()->inRandomOrder()->limit(3)->get()
            )
        )->create();

        $seekers = Seeker::query()->inRandomOrder()->limit(5)->get();
        $posts = Post::query()->inRandomOrder()->limit(49)->get();

        $seekers->each(function ($seeker) use ($posts) {
            Application::factory()
                ->count(rand(5, 10))
                ->create([
                    'seeker_id' => $seeker->id,
                    'post_id' => fn() => $posts->random()->id,
                ]);
        });
    }
}
