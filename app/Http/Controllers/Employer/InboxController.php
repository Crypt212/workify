<?php

namespace App\Http\Controllers\Employer;

use App\Models\User;
use App\Models\Message;
use App\Models\Seeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class InboxController
{
    public function index(Request $request)
    {
        $query = Message::with('receiver')->where('receiver_id', Auth::id());

        if ($request->has('filter')) {

            if (isset($request->filter['title'])) {
                $search_term = $request->filter['title'];
                $query->where('title', 'like', "%{$search_term}%");
            }
            if (isset($request->filter['body'])) {
                $search_term = $request->filter['body'];
                $query->where('body', 'like', "%{$search_term}%");
            }
            if (isset($request->filter['sender_name'])) {
                $search_term = $request->filter['sender_name'];
                $query->whereHas('sender', function ($q) use ($search_term) {
                    $q->where('name', 'like', "%{$search_term}%");
                });
            }
            if (isset($request->filter['sender_email'])) {
                $search_term = $request->filter['sender_email'];
                $query->whereHas('sender', function ($q) use ($search_term) {
                    $q->where('email', 'like', "%{$search_term}%");
                });
            }
            if (isset($request->filter['sender_username'])) {
                $search_term = $request->filter['sender_username'];
                $query->whereHas('sender', function ($q) use ($search_term) {
                    $q->where('username', 'like', "%{$search_term}%");
                });
            }
            if (isset($request->filter['sender_phone'])) {
                $search_term = $request->filter['sender_phone'];
                $query->whereHas('sender', function ($q) use ($search_term) {
                    $q->where('contact_info', 'like', "%{$search_term}%");
                });
            }
            if (isset($request->filter['sender_organization_name'])) {
                $search_term = $request->filter['sender_organization_name'];
                $query->whereHas('sender', function ($q) use ($search_term) {
                    $q->whereHas('employer', function ($q) use ($search_term) {
                        $q->where('organization_name', 'like', "%{$search_term}%");
                    });
                });
            }
        }

        $messages = $query->latest()->paginate(5);


        return view('employer.inbox', compact('messages'));
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Message::query()->create([
            'title' => $request->title,
            'body' => $request->body,
            'receiver_id' => $request->receiver_id,
            'sender_id' => $request->sender_id,
        ]);

        $receiver_username = Seeker::query()->whereHas('user', function ($query) use ($request) {
            $query->where('id', $request->receiver_id);
        })->first()->user->username;

        return redirect()->route("employer.seeker-profile", $receiver_username);
    }

}
