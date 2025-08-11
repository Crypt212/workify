<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeekerInboxController 
{
    public function index(Request $request)
    {
        $query = Message::with(['employer.user'])
            ->where('seeker_id', Auth::id());

        // فلترة بالاسم
        if ($request->filled('employer_name')) {
            $query->whereHas('employer.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employer_name . '%');
            });
        }

         // فلترة بالإيميل
    if ($request->filled('email')) {
        $query->whereHas('employer.user', function ($q) use ($request) {
            $q->where('email', 'like', '%' . $request->email . '%');
        });
    }

    
        // فلترة بالتاريخ
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $messages = $query->latest()->paginate(5);

        return view('seeker.inbox', compact('messages'));
    }
}
