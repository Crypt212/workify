<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $employer = Auth::user()->employer;
        $posts = Post::where('employer_id', $employer->id)->get();
        return view('employer.posts', compact('posts'));
    }

    public function create(): View
    {
        return view('employer.create-post');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        $employer = Auth::user()->employer;

        $post = Post::create([
            'employer_id' => $employer->id,
            'title' => $request->title,
            'description' => $request->description,
            'tags' => $request->tags,
        ]);

        if (!empty($request->tags)) {
            $tags = array_map('trim', explode(',', $request->tags));
            $post->tags()->createMany(
                array_map(fn($tag) => ['name' => $tag], $tags)
            );
        }

        return redirect()->route('employer.posts')->with('success', 'Post created successfully.');
    }
}