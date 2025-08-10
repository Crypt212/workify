<?php

namespace App\Http\Controllers\Employer;

use Illuminate\Http\Request;
use App\Models\Seeker;
use Illuminate\View\View;

class SeekersController
{
    public function profile($id): View
    {
        $seeker_obj = Seeker::with('user')->with("skills")->findOrFail($id);

        $skills = [];
        foreach($seeker_obj->skills as $skill) {
            $skills[] = [
                'name' => $skill->name,
                'proficiency' => $skill->pivot->proficiency,
            ];
        }

        $seeker = [
            "name" => $seeker_obj->user->name,
            "email" => $seeker_obj->user->email,
            "role" => $seeker_obj->role,
            "skills" => $skills
        ];
        return view('employer.seeker-profile', compact('seeker'));
    }

    public function explore(Request $request): View
    {
        $query = Seeker::with(['user', 'skills']);

        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('skills')) {
            $skills_search = $request->skills;
            $skills_search = explode(',', $skills_search);

            foreach ($skills_search as $searchTerm) {
                $query->whereHas('skills', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                });
            }
        }

        if ($request->filled('role')) {
            $query->where('role', 'like', '%' . $request->role . '%');
        }

        $seekers = [];
        foreach ($query->get() as $seeker_obj) {
            $seekers[] = [
                "id" => $seeker_obj->id,
                "name" => $seeker_obj->user->name,
                "email" => $seeker_obj->user->email,
                "role" => $seeker_obj->role,
                "skills" => $seeker_obj->skills()->pluck('name'),
            ];
        }

        return view('employer.seekers-explore', compact('seekers'));
    }
}
