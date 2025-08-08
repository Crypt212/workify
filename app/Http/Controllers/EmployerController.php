<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EmployerController extends Controller
{
    // صفحة الفورم
    public function searchForm()
    {
        return view('employer.seekers-search');
    }

    // تنفيذ البحث
    public function search(Request $request)
    {
        $query = User::query()->where('type', 'seeker');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('skills')) {
            $query->where('skills', 'like', '%' . $request->skills . '%');
        }

        $seekers = $query->get();

        return view('employer.seekers-search', compact('seekers'));
    }
    public function show($id)
{
    $seeker = \App\Models\Seeker::with('user')->findOrFail($id);
    return view('employer.seeker-profile', compact('seeker'));
}

}
