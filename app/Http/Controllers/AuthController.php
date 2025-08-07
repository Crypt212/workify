<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'contact_info' => 'required|string|max:255',
            'identity' => 'required|in:employer,seeker',
            'password' => 'required|confirmed|min:8',
            'organization_name' => 'required_if:identity,employer',
            'role' => 'required_if:identity,seeker',
            'skills' => 'nullable|string'
        ], [
            'name.required' => 'The full name field is required.',
            'email.required' => 'Please provide your email.',
            'email.unique' => 'Email already exists.',
            'username.required' => 'Please choose a username.',
            'username.unique' => 'This username is already taken.',
            'password.required' => 'You must set a password.',
            'identity.required' => 'Please select whether you are an employer or seeker.',
            'organization_name.required_if' => 'Organization name is required for employers.',
            'role.required_if' => 'Please specify your professional role.'
        ]);

        $user = User::query()->create([
            'username' => $request['username'],
            'email' => $request['email'],
            'name' => $request['name'],
            'contact_info' => $request['contact_info'],
            'identity' => $request['identity'],
            'password' => Hash::make($request['password']),
        ]);

        if ($request['identity'] === 'employer') {
            $user->employer()->create([
                'organization_name' => $request['organization_name'] ?? ''
            ]);
        } elseif ($request['identity'] === 'seeker') {
            $seeker = $user->seeker()->create([
                'role' => $request['role'] ?? ''
            ]);
            if (!empty($request['skills'])) {
                $skills = array_map('trim', explode(',', $request['skills']));

                $seeker->skills()->createMany(
                    array_map(fn($skill) => ['name' => $skill], $skills)
                );
            }
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function login()
    {
        return "yay";
    }
}
