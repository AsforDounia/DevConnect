<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    // public function rules(): array
    // {
    //     return [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
    //     ];
    // }

    public function rules(): array
{
    return [
        'name' => ['nullable', 'string', 'max:255'],
        'email' => ['nullable', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        'profile_picture' => ['nullable', 'image', 'max:1024'], // 1MB max
        'skills' => ['nullable', 'array'],
        'skills.*' => ['exists:skills,id'],
        'addSkills' => ['nullable', 'array'],
        'addSkills.*' => ['string', 'max:255'],
        'programming_languages' => ['nullable', 'array'],
        'programming_languages.*' => ['exists:programming_languages,id'],
        'addProgramming_languages' => ['nullable', 'array'],
        'addProgramming_languages.*' => ['string', 'max:255'],
        'projects' => ['nullable', 'array'],
        'projects.*.name' => ['nullable', 'string', 'max:255'],
        'projects.*.url' => ['nullable', 'url', 'max:255'],
        'projects.*.description' => ['nullable', 'string'],
        'certification' => ['nullable', 'array'],
        'certification.*.name' => ['nullable', 'string', 'max:255'],
        'certification.*.url' => ['nullable', 'url', 'max:255'],
        'certification.*.description' => ['nullable', 'string'],
    ];
}
}
