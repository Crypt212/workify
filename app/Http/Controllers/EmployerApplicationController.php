<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmployerApplicationController extends Controller
{
    public function index(Post $post): View
    {
        if (Auth::user()->employer->id !== $post->employer_id) {
            abort(403, 'Unauthorized');
        }

        $applications = $post->applications()
            ->with('seeker.user')
            ->where('status', 'pending')
            ->paginate(10);

        return view('employer.applications.index', compact('post', 'applications'));
    }

    public function accept(Application $application): RedirectResponse
    {
        if (Auth::user()->employer->id !== $application->employer_id) {
            abort(403, 'Unauthorized');
        }

        $application->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Application accepted.');
    }

    public function reject(Application $application): RedirectResponse
    {
        if (Auth::user()->employer->id !== $application->employer_id) {
            abort(403, 'Unauthorized');
        }

        $application->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Application rejected.');
    }
}
