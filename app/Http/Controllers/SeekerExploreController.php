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
        $seeker = Seeker::with('user')->findOrFail($id);
        return view('employer.seeker-profile', compact('seeker'));
    }

    // عرض صفحة الاستكشاف مع البحث
    public function exploreSeekers(Request $request): View
    {
        $query = Seeker::with('user'); // نجلب الـ seekers مع بيانات الـ user المرتبطة

        // فلترة بالاسم
        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        // فلترة بالمهارات
        if ($request->filled('skills')) {
            $query->where('skills', 'like', '%' . $request->skills . '%');
        }

        // فلترة بالدور/المسمى الوظيفي
        if ($request->filled('role')) {
            $query->where('role', 'like', '%' . $request->role . '%');
        }

        $seekers = $query->get();

        return view('employer.seekers-explore', compact('seekers'));
    }
}
