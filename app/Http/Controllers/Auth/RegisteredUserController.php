<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Skill;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Models\ProgrammingLanguage;
use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $skills = Skill::all();
        $languages = ProgrammingLanguage::all();
        return view('auth.register', compact('skills', 'languages'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|exists:skills,id',
            'programming_languages' => 'nullable|array',
            'programming_languages.*' => 'nullable|exists:programming_languages,id',
            'addSkills' => 'nullable|array',
            'addSkills.*' => 'nullable|string|max:255',
            'addProgramming_languages' => 'nullable|array',
            'addProgramming_languages.*' => 'nullable|string|max:255',
            'projects' => 'nullable|array',
            'projects.*.name' => 'nullable|string|max:255',
            'projects.*.url' => 'nullable|string|max:255',
            'projects.*.description' => 'nullable|string',
            'certifications' => 'nullable|array',
            'certifications.*.name' => 'nullable|string|max:255',
            'certifications.*.url' => 'nullable|string|max:255',
            'certifications.*.description' => 'nullable|string',
        ]);
// dd($validator);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $request->file('profile_picture') ? $request->file('profile_picture')->store('profile_pictures','public') : null,
        ]);

        if ($request->has('skills')) {
            $user->skills()->sync($request->input('skills'));
        }

        if ($request->has('addSkills')) {
            foreach ($request->input('addSkills') as $newSkill) {
                if (!empty($newSkill)) {
                    $skill = Skill::firstOrCreate(['name' => $newSkill]);
                    $user->skills()->attach($skill->id);
                }
            }
        }

        if ($request->has('programming_languages')) {
            $user->programmingLanguages()->sync($request->input('programming_languages'));
        }

        if ($request->has('addProgramming_languages')) {
            foreach ($request->input('addProgramming_languages') as $newLanguage) {
                if (!empty($newLanguage)) {
                    $language = ProgrammingLanguage::firstOrCreate(['name' => $newLanguage]);
                    $user->programmingLanguages()->attach($language->id);
                }
            }
        }

        if ($request->has('projects')) {
            foreach ($request->input('projects') as $project) {
                if (!empty($project['name']) || !empty($project['url']) || !empty($project['description'])) {
                    $user->projects()->create([
                        'name' => $project['name'] ?? '',
                        'url' => $project['url'] ?? '',
                        'description' => $project['description'] ?? '',
                        'user_id' => $user->id,
                    ]);
                }
            }
        }

        if ($request->has('certifications')) {
            foreach ($request->input('certifications') as $cert) {
                if (!empty($cert['name']) || !empty($cert['url']) || !empty($cert['description'])) {
                    $user->certifications()->create([
                        'name' => $cert['name'] ?? '',
                        'url' => $cert['url'] ?? '',
                        'description' => $cert['description'] ?? '',
                        'user_id' => $user->id,
                    ]);
                }
            }
        }




        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
