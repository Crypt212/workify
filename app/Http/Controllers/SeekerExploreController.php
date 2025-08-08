<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seeker;
use Illuminate\View\View;

class SeekerExploreController extends Controller
{
    /* // صفحة الفورم */
    /* public function searchForm(): View */
    /* { */
    /*     return view('employer.seekers-search'); */
    /* } */
    /**/
    /* // تنفيذ البحث */
    /* public function search(Request $request): View */
    /* { */
    /*     $query = User::query()->where('type', 'seeker'); */
    /**/
    /*     if ($request->filled('name')) { */
    /*         $query->where('name', 'like', '%' . $request->name . '%'); */
    /*     } */
    /**/
    /*     if ($request->filled('skills')) { */
    /*         $query->where('skills', 'like', '%' . $request->skills . '%'); */
    /*     } */
    /**/
    /*     $seekers = $query->get(); */
    /**/
    /*     return view('employer.seekers-search', compact('seekers')); */
    /* } */

    public function showProfile($id): View
    {
        $seeker_obj = Seeker::with('user')->with("skills")->findOrFail($id);
        $seeker = [
            "name" => $seeker_obj->user->name,
            "email" => $seeker_obj->user->email,
            "role" => $seeker_obj->role,
            "skills" => $seeker_obj->skills()->pluck('name')->implode(", "),
        ];
        return view('employer.seeker-profile', compact('seeker'));
    }

    // عرض صفحة الاستكشاف مع البحث
    public function exploreSeekers(Request $request): View
    {
        $query = Seeker::with(['user', 'skills']); // نجلب الـ seekers مع بيانات الـ user المرتبطة

        // فلترة بالاسم
        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        // فلترة بالمهارات
        if ($request->filled('skills')) {
            $skills_search = $request->skills;
            $skills_search = explode(',', $skills_search);

            foreach ($skills_search as $searchTerm) {
                $query->whereHas('skills', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                });
            }
        }

        // فلترة بالدور/المسمى الوظيفي
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
                "skills" => $seeker_obj->skills()->pluck('name')->implode(", "),
            ];
        }

        return view('employer.seekers-explore', compact('seekers'));
    }
}
