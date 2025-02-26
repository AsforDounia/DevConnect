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
            'skills.*' => 'nullable|string|max:255',
            'programming_languages' => 'nullable|array',
            'programming_languages.*' => 'nullable|string|max:255',
            'addProgrammingLanguages' => 'nullable|array',
            'addProgrammingLanguages.*' => 'nullable|string|max:255',
            'projects' => 'nullable|array',
            'projects.*.name' => 'nullable|string|max:255',
            'projects.*.url' => 'nullable|url|max:255',
            'projects.*.description' => 'nullable|string|max:500',
            'certifications' => 'nullable|array',
            'certifications.*.name' => 'nullable|string|max:255',
            'certifications.*.url' => 'nullable|url|max:255',
            'certifications.*.description' => 'nullable|string|max:500',
        ]);
        dd($validator);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Hash the password
            'profile_picture' => $request->file('profile_picture') ? $request->file('profile_picture')->store('profile_pictures','public') : null,
        ]);

        if ($request->has('skills')) {
            $user->skills()->sync($request->input('skills'));
        }

        if ($request->has('addSkills')) {
            foreach ($request->input('addSkills') as $newSkill) {
                $skill = Skill::firstOrCreate(['name' => $newSkill]);
                $user->skills()->attach($skill->id);
            }
        }


        if ($request->has('programming_languages')) {
            $user->languages()->sync($request->input('programming_languages'));
        }

        if ($request->has('addProgramming_languages')) {
            foreach ($request->input('addProgrammingLanguages') as $newLanguage) {
                $language = ProgrammingLanguage::firstOrCreate(['name' => $newLanguage]);
                $user->languages()->attach($language->id);
            }
        }



        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
