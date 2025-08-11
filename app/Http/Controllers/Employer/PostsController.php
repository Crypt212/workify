<?php

namespace App\Http\Controllers\Employer;

use App\Models\Post;
use App\Models\Skill;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostsController
{
    public function explore()
    {
        $employer = Auth::user()->employer;

        $posts = [];

        foreach (Post::query()->where('employer_id', $employer->id)->get() as $post) {

            $posts[] = [
                'title' => $post->title,
                'description' => $post->description,
                'tags' => array_map(fn($elm) => $elm['name'], $post->tags->toArray()),
                'skills' => array_map(fn($elm) => $elm['name'], $post->skills->toArray()),
                'created_at' => $post->created_at->format('M d, Y'),
            ];
        }

        return view('employer.posts', compact('posts'));
    }

    public function showCreate(): View
    {
        return view('employer.post-create');
    }

    public function store(Request $request) //: RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'tags' => 'required|json',
            'skills' => 'required|json',
        ]);

        $employer = Auth::user()->employer;

        $post = Post::query()->create([
            'employer_id' => $employer->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if (!empty($request->tags)) {
            $tags = json_decode($request->tags);
            foreach ($tags as $tag) {
                if ($tag->name == "") continue;
                $post_tag = Tag::query()->firstOrCreate(['name' => $tag->name,]);
                $post->tags()->attach($post_tag->id);
            }
        }

        if (!empty($request->skills)) {
            $skills = json_decode($request->skills);
            foreach ($skills as $skill) {
                if ($skill->name == "") continue;
                $post_skill = Skill::query()->firstOrCreate(['name' => $skill->name,]);
                $post->skills()->attach($post_skill->id);
            }
        }

        return redirect()->route('employer.posts')->with('success', 'Post created successfully.');
    }
}
