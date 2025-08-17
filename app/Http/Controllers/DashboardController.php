<?php

namespace App\Http\Controllers;

use App\Models\Seeker;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DashboardController
{
    function view(): View
    {
        return view("dashboard");
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Define valid proficiency levels
        $validProficiencyLevels = ['Beginner', 'Intermediate', 'Advanced', 'Expert'];

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
        ];

        if ($user->identity == 'seeker') {
            $rules['role'] = 'required|string|max:255';
            $rules['skills'] = 'array';
            $rules['skills'] = 'required|json';
        } elseif ($user->identity == 'employer') {
            $rules['organization_name'] = 'required|string|max:255';
        }

        $validatedData = $request->validate($rules);

        try {
            \DB::beginTransaction();

            // Update user data
            $user->name = $validatedData['name'];
            $user->contact_info = $validatedData['contact_info'];
            $user->save();

            if ($user->identity == 'seeker') {
                $seeker = $user->seeker()->firstOrNew();
                $seeker->role = $validatedData['role'];
                $seeker->save();

                // Decode and process the JSON skills
                $skillsData = json_decode($validatedData['skills'], true);

                // Additional validation for decoded JSON
                if (!is_array($skillsData)) {
                    throw new \Exception('Invalid skills data format');
                }

                $this->updateSeekerSkillsFromJson($seeker, $skillsData, $validProficiencyLevels);
            }
            elseif ($user->identity == 'employer') {
                $employer = $user->employer()->firstOrNew();
                $employer->organization_name = $validatedData['organization_name'];
                $employer->save();
            }

            \DB::commit();

            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update profile: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Update password method
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => [
                'required',
                'string',
                'confirmed',
            ],
        ]);

        $user = Auth::user();

        try {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update password. Please try again.');
        }
    }

    protected function updateSeekerSkillsFromJson(Seeker $seeker, array $skillsData, array $validProficiencyLevels)
    {
        $skillsToSync = [];

        foreach ($skillsData as $skillData) {
            // Validate each skill item structure
            if (!isset($skillData['name']) || !isset($skillData['proficiency'])) {
                continue; // or throw exception if you want strict validation
            }

            // Find or create the skill
            $skill = Skill::firstOrCreate(['name' => $skillData['name']]);

            // Add to sync array with proficiency
            $skillsToSync[$skill->id] = ['proficiency' => $skillData['proficiency']];
        }

        // Sync the skills with proficiency
        $seeker->skills()->sync($skillsToSync);
    }
}
