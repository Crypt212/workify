<?php

namespace App\Http\Controllers\Employer;

use App\Models\Post;
use App\Models\Message;
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
            ->with(['seeker.user', 'post.skills']);


        $applications = $query->paginate(5);

        return view('employer.applications', compact('applications'));
    }

    public function accept(Request $request): RedirectResponse
    {
        $application = Application::with(['post.employer.user', 'seeker.user'])
            ->findOrFail($request->application_id);

        Message::create([
            'title' => 'Accepted for ' . $application->post->title,
            'body' => 'You are accepted for the job ' . $application->post->title . ' with this discription:\n"' . $application->post->description . '"\n contact employer, username: [' . $application->post->employer->user->username,
            'sender_id' => $application->post->employer->user->id,
            'receiver_id' => $application->seeker->user->id,
        ]);

        $application->delete();

        return redirect()->back()->with('success', 'Application accepted.');
    }

    public function reject(Application $request): RedirectResponse
    {
        $application = Application::with(['post.employer.user', 'seeker.user'])
            ->findOrFail($request->application_id);

        Message::create([
            'title' => 'Rejected for ' . $application->post->title,
            'body' => 'You are rejected for the job ' . $application->post->title . ' with this discription:\n"' . $application->post->description . '"\n contact employer, username: [' . $application->post->employer->user->username,
            'sender_id' => $application->post->employer->user->id,
            'receiver_id' => $application->seeker->user->id,
        ]);

        $application->delete();

        return redirect()->back()->with('success', 'Application rejected.');
    }
}
