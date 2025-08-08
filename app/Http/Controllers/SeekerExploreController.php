<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seeker;

class SeekerExploreController extends Controller
{
    // عرض صفحة الاستكشاف مع البحث
    public function index(Request $request)
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
