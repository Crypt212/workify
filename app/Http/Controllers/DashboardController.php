<?php

namespace App\Http\Controllers;

use App\Models\Seeker;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    $validProficiencyLevels = ['beginner', 'intermediate', 'advanced', 'expert'];

    $rules = [
        'name' => 'required|string|max:255',
        'contact_info' => 'required|string|max:255',
    ];

    if ($user->identity == 'seeker') {
        $rules['role'] = 'required|string|max:255';
        $rules['skills'] = 'required|json'; // Only json validation needed
    } elseif ($user->identity == 'employer') {
        $rules['organization_name'] = 'required|string|max:255';
    }

    $validatedData = $request->validate($rules);

    try {
        \DB::beginTransaction();

        $user->name = $validatedData['name'];
        $user->contact_info = $validatedData['contact_info'];
        $user->save();

        if ($user->identity == 'seeker') {
            $seeker = $user->seeker()->firstOrNew();
            $seeker->role = $validatedData['role'];
            $seeker->save();

            // Decode skills JSON
            $skillsData = json_decode($validatedData['skills']);

            if (!is_array($skillsData)) {
                throw new \Exception('Invalid skills data format');
            }

            // Process skills with normalized proficiency
            $this->updateSeekerSkills($seeker, $skillsData, $validProficiencyLevels);
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
            ->with('error', 'Update failed: ' . $e->getMessage())
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

    protected function updateSeekerSkills(Seeker $seeker, array $skillsData, array $validProficiencyLevels)
    {
        $skillsToSync = [];

        foreach ($skillsData as $skillData) {
            // Skip invalid entries
            if (!isset($skillData->name) || !isset($skillData->proficiency)) {
                continue;
            }

            // Normalize proficiency to lowercase
            $proficiency = strtolower($skillData->proficiency);

            // Validate proficiency level
            if (!in_array($proficiency, $validProficiencyLevels)) {
                continue;
            }

            // Find or create the skill
            $skill = Skill::firstOrCreate(['name' => trim($skillData->name)]);

            // Add to sync array with normalized proficiency
            $skillsToSync[$skill->id] = ['proficiency' => $proficiency];
        }

        $seeker->skills()->sync($skillsToSync);
    }
}
