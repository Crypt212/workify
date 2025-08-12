<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Employer;
use App\Models\Seeker;
use App\Models\Post;
use App\Models\Application;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'username' => 'employer1',
            'email' => 'employer@example.com',
            'password' => bcrypt('password'),
            'name' => 'Employer Name',
            'identity' => 'employer',
        ]);

        $employer = Employer::create([
            'user_id' => $user->id,
            'organization_name' => 'Test Corp',
        ]);

        $seekerUser = User::create([
            'username' => 'seeker1',
            'email' => 'seeker@example.com',
            'password' => bcrypt('password'),
            'name' => 'Seeker Name',
            'identity' => 'seeker',
        ]);

        $seeker = Seeker::create([
            'user_id' => $seekerUser->id,
            'role' => 'Developer',
            'skills' => 'PHP, Laravel',
        ]);

        $post = Post::create([
            'employer_id' => $employer->id,
            'title' => 'Software Engineer',
            'description' => 'Job description',
        ]);

        Application::create([
            'post_id' => $post->id,
            'seeker_id' => $seeker->id,
            'employer_id' => $employer->id,
            'status' => 'pending',
        ]);
    }
}