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
                    $query->whereHas('tags', function ($q) use ($search_tag) {
                        $q->where('name', 'like', "%{$search_tag}%");
                    });
                }
            }
            if (isset($request->filter['skills'])) {
                $search_term = $request->filter['skills'];
                $search_skills = array_map('trim', explode(',', $search_term));

                foreach ($search_skills as $search_skill) {
                    $query->whereHas('skills', function ($q) use ($search_skill) {
                        $q->where('name', 'like', "%{$search_skill}%");
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
            $post->applied = $post->applications()->whereHas('seeker', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('id', Auth::user()->id);
                });
            })->first();
        }

        return view('seeker.posts', compact('posts'));
    }

    public function apply(Post $post): RedirectResponse
    {
        $post->applications()->create([
            'seeker_id' => Auth::user()->seeker->id,
            'post_id' => $post->id,
        ]);

        return redirect()->back()->with('success', 'Applied to job post.');
    }

    public function unapply(Post $post): RedirectResponse
    {
        $application = $post->applications()->where('seeker_id', Auth::user()->seeker->id)->first();
        $application->delete();

        return redirect()->back()->with('success', 'Unqapplied to job post.');
    }
}
