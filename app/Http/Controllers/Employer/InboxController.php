<?php

namespace App\Http\Controllers\Employer;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            if (isset($request->filter['sender_role'])) {
                $search_term = $request->filter['sender_role'];
                $query->whereHas('sender', function ($q) use ($search_term) {
                    $q->whereHas('seeker', function ($q) use ($search_term) {
                        $q->where('role', 'like', "%{$search_term}%");
                    });
                });
            }
            if (isset($request->filter['sender_skills'])) {
                $search_term = $request->filter['sender_skills'];
                $search_skills = array_map('trim', explode(',', $search_term));

                foreach ($search_skills as $search_skill) {
                    $query->whereHas('sender', function ($q) use ($search_skill) {
                        $q->whereHas('seeker', function ($q) use ($search_skill) {
                            $q->whereHas('skills', function ($q) use ($search_skill) {
                                $q->where('name', 'like', "%{$search_skill}%");
                            });
                        });
                    });
                }
            }
        }

        $messages = $query->latest()->paginate(5);

        foreach ($messages as $message) {
            $message->sender_username = User::query()->where('id', $message->sender->id)->first()->username;
            $message->receiver_username = User::query()->where('id', $message->receiver->id)->first()->username;
        }


        return view('employer.inbox', compact('messages'));
    }
}
