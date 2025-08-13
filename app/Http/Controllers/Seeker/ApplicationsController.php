<?php

namespace App\Http\Controllers\Seeker;

use App\Models\Post;
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


        $applications = $query->paginate(5);

        return view('seeker.applications', compact('applications'));
    }

    public function unapply(Request $request): RedirectResponse
    {
        $application = Application::query()->where('id', $request->application_id);
        $application->delete();

        return redirect()->back()->with('success', 'Unqapplied to job post.');
    }
}
