<?php

namespace App\Http\Controllers\Employer;

use Illuminate\Http\Request;
use App\Models\Seeker;
use Illuminate\View\View;

class SeekersController
{
    public function profile(string $username): View
    {
        $seeker = Seeker::query()->with('skills')->with('user')->whereHas('user', function ($query) use ($username) {
            $query->where('username', $username);
        })->first();

        $skills = [];
        foreach ($seeker->skills as $skill) {
            $skills[] = [
                'name' => $skill->name,
                'proficiency' => $skill->pivot->proficiency,
            ];
        }

        return view('employer.seeker-profile', compact('seeker'));
    }

    public function explore(Request $request): View
    {
        $query = Seeker::with(['user', 'skills']);

        if ($request->has('filter')) {
            if (isset($request->filter['name'])) {
                $search_term = $request->filter['name'];
                $query->whereHas('user', function ($q) use ($search_term) {
                    $q->where('name', 'like', "%{$search_term}%");
                });
            }

            if (isset($request->filter['email'])) {
                $search_term = $request->filter['email'];
                $query->whereHas('user', function ($q) use ($search_term) {
                    $q->where('email', 'like', "%{$search_term}%");
                });
            }

            if (isset($request->filter['role'])) {
                $search_term = $request->filter['role'];
                $query->where('role', 'like', "%{$search_term}%");
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

            if (isset($request->filter['phone'])) {
                $search_term = $request->filter['phone'];
                $query->whereHas('user', function ($q) use ($search_term) {
                    $q->where('contact_info', 'like', "%{$search_term}%");
                });
            }
        }

        $seekers = $query->paginate(5);

        return view('employer.seekers', compact('seekers'));
    }
}
