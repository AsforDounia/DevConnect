<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ProgrammingLanguage;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $skills = Skill::all();
        $languages = ProgrammingLanguage::all();
        $projects = $user->projects;
        $certifications = $user->certifications;
        return view('profile.edit', [
            'user' => $user,
            'skills' => $skills,
            'languages' => $languages,
            'projects' => $projects,
            'certifications' => $certifications,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        dd("cc");
        $user = $request->user();

        // Handle basic profile information
        if ($request->has('name') && $request->has('email')) {
            // Handle basic profile information
            $user->fill($request->safe()->only(['name', 'email']));

        }


        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }


        // Handle skills
        if ($request->has('skills')) {
            $user->skills()->sync($request->skills);
        } else {
            $user->skills()->detach();
        }

        // Handle custom skills
        if ($request->has('addSkills')) {
            foreach ($request->addSkills as $skillName) {
                $skill = Skill::firstOrCreate(['name' => $skillName]);
                if (!$user->skills->contains($skill->id)) {
                    $user->skills()->attach($skill->id);
                }
            }
        }

        // Handle programming languages
        if ($request->has('programming_languages')) {
            $user->programmingLanguages()->sync($request->programming_languages);
        } else {
            $user->programmingLanguages()->detach();
        }

        // Handle custom programming languages
        if ($request->has('addProgramming_languages')) {
            foreach ($request->addProgramming_languages as $languageName) {
                $language = ProgrammingLanguage::firstOrCreate(['name' => $languageName]);
                if (!$user->programmingLanguages->contains($language->id)) {
                    $user->programmingLanguages()->attach($language->id);
                }
            }
        }

        // Handle projects
        if ($request->has('projects')) {
            $user->projects()->delete();
            foreach ($request->projects as $projectData) {
                if (!empty($projectData['name'])) {
                    $user->projects()->create([
                        'name' => $projectData['name'],
                        'url' => $projectData['url'] ?? null,
                        'description' => $projectData['description'] ?? null
                    ]);
                }
            }
        }
        // Handle certifications
        if ($request->has('certification')) {
            // Delete existing certifications
            $user->certifications()->delete();

            // Create new certifications
            foreach ($request->certification as $certData) {
                if (!empty($certData['name'])) {
                    $user->certifications()->create([
                        'name' => $certData['name'],
                        'url' => $certData['url'] ?? null,
                        'description' => $certData['description'] ?? null
                    ]);
                }
            }
        }
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
