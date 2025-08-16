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
    public function explore(Request $request): View
    {
        $employer = Auth::user()->employer;

        $query = Post::query()->where('employer_id', $employer->id);

        if ($request->has('filter')) {
            if (isset($request->filter['title'])) {
                $search_term = $request->filter['title'];
                $query->where('title', 'like', "%{$search_term}%");
            }
            if (isset($request->filter['tags'])) {
                $search_terms = array_map('trim', explode(',', $request->filter['tags']));

                foreach($search_terms as $search_term) {
                    $query->whereHas('tags', function ($query) use ($search_term) {
                        $query->where('name', 'like', "%{$search_term}%");
                    });
                }
            }
            if (isset($request->filter['skills'])) {
                $search_terms = array_map('trim', explode(',', $request->filter['skills']));

                foreach($search_terms as $search_term) {
                    $query->whereHas('skills', function ($query) use ($search_term) {
                        $query->where('name', 'like', "%{$search_term}%");
                    });
                }
            }
        }

        $posts = $query->paginate(5);

        foreach ($posts as $post) {
            $post->tags = array_map(fn($elm) => $elm['name'], $post->tags->toArray());
            $post->skills = array_map(fn($elm) => $elm['name'], $post->skills->toArray());
            $post->created_at = $post->created_at->format('Y-m-d H:i:s');
        }

        return view('employer.posts', compact('posts'));
    }

    public function showCreate(): View
    {
        return view('employer.post-create');
    }

    public function destroy(Post $post): RedirectResponse
    {
        Post::query()->where('id', $request->id)->forceDelete();

        return redirect()->route('employer.posts')->with('success', "Post was deleted successfully.");
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
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
