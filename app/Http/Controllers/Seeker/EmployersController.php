<?php

namespace App\Http\Controllers\Seeker;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Employer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployersController
{
    public function profile(string $username): View
    {
        $employer = Employer::query()->with('user')->whereHas('user', function ($query) use ($username) {
            $query->where('username', $username);
        })->first();

        return view('seeker.employer-profile', compact('employer'));
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Message::query()->create([
            'title' => $request->title,
            'body' => $request->body,
            'receiver_id' => $request->receiver_id,
            'sender_id' => $request->sender_id,
        ]);

        $receiver_username = Employer::query()->whereHas('user', function ($query) use ($request) {
            $query->where('id', $request->receiver_id);
        })->first()->user->username;

        return redirect()->route("seeker.employer-profile", $receiver_username);
    }

    public function explore(Request $request): View
    {
        $query = Employer::with('user');

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

            if (isset($request->filter['organization_name'])) {
                $search_term = $request->filter['organization_name'];
                $query->where('organization_name', 'like', "%{$search_term}%");
            }

            if (isset($request->filter['phone'])) {
                $search_term = $request->filter['phone'];
                $query->whereHas('user', function ($q) use ($search_term) {
                    $q->where('contact_info', 'like', "%{$search_term}%");
                });
            }
        }

        $employers = $query->paginate(5);

        return view('seeker.employers', compact('employers'));
    }
}
