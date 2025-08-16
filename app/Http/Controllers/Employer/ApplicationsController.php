<?php

namespace App\Http\Controllers\Employer;

use App\Models\Message;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
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

    public function accept(Application $application): RedirectResponse
    {
        $message_body =<<<EOF
        Your application have been accepted for the job {$application->post->title} with this discription:
            "{$application->post->description}".
        contact employer with  username: [ {$application->post->employer->user->username} ] at email {$application->post->employer->user->email}.
        EOF;

        Message::create([
            'title' => 'Accepted for ' . $application->post->title,
            'body' => $message_body,
            'sender_id' => $application->post->employer->user->id,
            'receiver_id' => $application->seeker->user->id,
        ]);

        $application->delete();

        return redirect()->back()->with('success', 'Application accepted.');
    }

    public function reject(Application $application): RedirectResponse
    {
        $message_body =<<<EOF
        We are sorry to inform you that your application have been rejected for the job {$application->post->title} with this discription:
            "{$application->post->description}".
        EOF;

        Message::create([
            'title' => 'Rejected for ' . $application->post->title,
            'body' => $message_body,
            'sender_id' => $application->post->employer->user->id,
            'receiver_id' => $application->seeker->user->id,
        ]);

        $application->delete();

        return redirect()->back()->with('success', 'Application rejected.');
    }
}
