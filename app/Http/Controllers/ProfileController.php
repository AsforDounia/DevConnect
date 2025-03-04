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

    public function update(Request $request)
    {
        // dd($request);

        $user = $request->user();

        if ($request->has('name') && $request->has('email')) {
            $user->fill($request->safe()->only(['name', 'email']));

        }
        // githubProfile
        if ($request->has('githubProfile')) {
            $user->githubProfile = $request->githubProfile;
        }
        // biography
        if ($request->has('biography')) {
            $user->biography = $request->biography;
        }



        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        if ($request->has('skills')) {
            $user->skills()->sync($request->skills);
        } else {
            $user->skills()->detach();
        }

        if ($request->has('addSkills')) {
            foreach ($request->addSkills as $skillName) {
                $skill = Skill::firstOrCreate(['name' => $skillName]);
                if (!$user->skills->contains($skill->id)) {
                    $user->skills()->attach($skill->id);
                }
            }
        }

        if ($request->has('programming_languages')) {
            $user->programmingLanguages()->sync($request->programming_languages);
        } else {
            $user->programmingLanguages()->detach();
        }

        if ($request->has('addProgramming_languages')) {
            foreach ($request->addProgramming_languages as $languageName) {
                $language = ProgrammingLanguage::firstOrCreate(['name' => $languageName]);
                if (!$user->programmingLanguages->contains($language->id)) {
                    $user->programmingLanguages()->attach($language->id);
                }
            }
        }

        if($request->has('projects')) {
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
        }else{
            $user->projects()->delete();
        }

        if ($request->has('certifications')) {
            $user->certifications()->delete();
            foreach ($request->certifications as $certData) {
                if (!empty($certData['name'])) {
                    $user->certifications()->create([
                        'name' => $certData['name'],
                        'url' => $certData['url'] ?? null,
                        'description' => $certData['description'] ?? null
                    ]);
                }
            }
        }else{
            $user->certifications()->delete();
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
