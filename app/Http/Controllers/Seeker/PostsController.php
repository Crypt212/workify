<?php

namespace App\Http\Controllers\Seeker;

use App\Models\Post;
use App\Models\Skill;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostsController
{
    public function explore(Request $request): View
    {
        $employer = Auth::user()->employer;

        $query = Post::query()->with('employer.user');

        if ($request->has('filter')) {

            if (isset($request->filter['employer_name'])) {
                $search_term = $request->filter['employer_name'];
                $query->whereHas('employer', function ($q) use ($search_term) {
                    $q->whereHas('user', function ($q) use ($search_term) {

                        $q->where('name', 'like', "%{$search_term}%");
                    });
                });
            }
            if (isset($request->filter['employer_username'])) {
                $search_term = $request->filter['employer_username'];
                $query->whereHas('employer', function ($q) use ($search_term) {
                    $q->whereHas('user', function ($q) use ($search_term) {

                        $q->where('username', 'like', "%{$search_term}%");
                    });
                });
            }
            if (isset($request->filter['employer_organization'])) {
                $search_term = $request->filter['employer_organization'];
                $query->whereHas('employer', function ($q) use ($search_term) {
                    $q->where('organization_name', 'like', "%{$search_term}%");
                });
            }
            if (isset($request->filter['title'])) {
                $search_term = $request->filter['title'];
                $query->where('title', 'like', "%{$search_term}%");
            }
            if (isset($request->filter['tags'])) {
                $search_term = $request->filter['tags'];
                $search_tags = array_map('trim', explode(',', $search_term));

                foreach ($search_tags as $search_tag) {
                    $query->whereHas('skills', function ($query) use ($search_tag) {
                        $query->where('name', 'like', "%{$search_tag}%");
                    });
                }
            }
            if (isset($request->filter['skills'])) {
                $search_term = $request->filter['skills'];
                $search_skills = array_map('trim', explode(',', $search_term));

                foreach ($search_skills as $search_skill) {
                    $query->whereHas('skills', function ($query) use ($search_skill) {
                        $query->where('name', 'like', "%{$search_skill}%");
                    });
                }
            }
            if (isset($request->filter['description'])) {
                $search_term = $request->filter['description'];
                $query->where('description', 'like', "%{$search_term}%");
            }
        }

        $posts = $query->paginate(5);

        foreach ($posts as $post) {
            $post->tags = array_map(fn($elm) => $elm['name'], $post->tags->toArray());
            $post->skills = array_map(fn($elm) => $elm['name'], $post->skills->toArray());
            $post->created_at = $post->created_at->format('Y-m-d H:i:s');
        }

        return view('seeker.posts', compact('posts'));
    }

    public function showCreate(): View
    {
        return view('employer.post-create');
    }

    public function store(Request $request): RedirectResponse
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
