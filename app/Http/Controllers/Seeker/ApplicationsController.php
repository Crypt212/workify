<?php

namespace App\Http\Controllers\Seeker;

use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ApplicationsController
{
    public function explore(Request $request): View
    {
        $query = Application::query()
            ->with(['seeker.user', 'post.skills'])->whereHas('seeker', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('id', Auth::user()->id);
                });
            });

        if ($request->has('filter')) {
            if (isset($request->filter['employer_name'])) {
                $search_term = $request->filter['employer_name'];
                $query->whereHas('post', function ($q) use ($search_term) {
                    $q->whereHas('employer', function ($q) use ($search_term) {
                        $q->whereHas('user', function ($q) use ($search_term) {
                            $q->where('name', 'like', "%{$search_term}%");
                        });
                    });
                });
            }

            if (isset($request->filter['employer_username'])) {
                $search_term = $request->filter['employer_username'];
                $query->whereHas('post', function ($q) use ($search_term) {
                    $q->whereHas('employer', function ($q) use ($search_term) {
                        $q->whereHas('user', function ($q) use ($search_term) {
                            $q->where('username', 'like', "%{$search_term}%");
                        });
                    });
                });
            }
            if (isset($request->filter['employer_organization'])) {
                $search_term = $request->filter['employer_organization'];
                $query->whereHas('post', function ($q) use ($search_term) {
                    $q->whereHas('employer', function ($q) use ($search_term) {
                        $q->where('organization_name', 'like', "%{$search_term}%");
                    });
                });
            }
            if (isset($request->filter['title'])) {
                $search_term = $request->filter['title'];
                $query->whereHas('post', function ($q) use ($search_term) {
                    $q->where('title', 'like', "%{$search_term}%");
                });
            }
            if (isset($request->filter['tags'])) {
                $search_term = $request->filter['tags'];
                $search_tags = array_map('trim', explode(',', $search_term));

                foreach ($search_tags as $search_tag) {
                    $query->whereHas('post', function ($q) use ($search_tag) {
                        $q->whereHas('tags', function ($q) use ($search_tag) {
                            $q->where('name', 'like', "%{$search_tag}%");
                        });
                    });
                }
            }
            if (isset($request->filter['skills'])) {
                $search_term = $request->filter['skills'];
                $search_skills = array_map('trim', explode(',', $search_term));

                foreach ($search_skills as $search_skill) {
                    $query->whereHas('post', function ($q) use ($search_skill) {
                        $q->whereHas('skills', function ($q) use ($search_skill) {
                            $q->where('name', 'like', "%{$search_skill}%");
                        });
                    });
                }
            }
            if (isset($request->filter['description'])) {
                $search_term = $request->filter['description'];
                $query->whereHas('post', function ($q) use ($search_term) {
                    $q->where('description', 'like', "%{$search_term}%");
                });
            }
        }



        $applications = $query->paginate(5);

        return view('seeker.applications', compact('applications'));
    }

    public function unapply(Application $application): RedirectResponse
    {
        $application->delete();

        return redirect()->back()->with('success', 'Unqapplied to job post.');
    }
}
