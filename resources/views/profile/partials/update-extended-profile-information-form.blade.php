
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Extended Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your skills, programming languages, projects, and certifications.") }}
        </p>
    </header>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form  id="profile-form" method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Skills Selection -->
        <div class="mt-4" x-data="{ selectedSkills: {{ json_encode(old('skills', $user->skills->pluck('id')->toArray())) }}, customSkills: [], newSkill: '' }">
            <x-input-label :value="__('Skills')" />
            <select
                name="skills[]"
                class="block w-full"
                multiple
                x-on:change="selectedSkills = Array.from($event.target.selectedOptions).map(option => ({ id: option.value, name: option.text }))">
                @foreach ($skills as $skill)
                    <option value="{{ $skill->id }}" {{ in_array($skill->id, old('skills', $user->skills->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $skill->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">Hold Ctrl (or Cmd on Mac) to select multiple skills</p>

            <!-- Add New Skill Input -->
            <div class="mt-2 flex">
                <x-text-input type="text" class="block w-full" x-model="newSkill" placeholder="Enter a new skill" />
                <button type="button" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded"
                        @click="if(newSkill.trim() !== '') {
                            customSkills.push(newSkill);
                            selectedSkills.push({ id: 'custom-'+newSkill, name: newSkill });
                            newSkill = '';
                        }">
                    Add
                </button>
            </div>

            <!-- Hidden inputs for custom skills -->
            <template x-for="skill in customSkills" :key="skill">
                <input type="hidden" name="addSkills[]" :value="skill" />
            </template>

            <x-input-error :messages="$errors->get('skills')" class="mt-2" />

            <!-- Display Selected Skills -->
            <div class="mt-2">
                <h3 class="font-semibold text-lg">Selected Skills:</h3>
                <div class="mt-2 flex flex-wrap">
                    <template x-if="selectedSkills.length === 0">
                        <span class="inline-block px-4 py-1 bg-gray-100 text-gray-500 rounded-full mr-2 mt-2">
                            No skills selected
                        </span>
                    </template>
                    <template x-for="(skill, index) in selectedSkills" :key="skill.id">
                        <div class="inline-flex items-center px-4 py-1 bg-blue-100 text-blue-800 rounded-full mr-2 mt-2">
                            <span x-text="skill.name"></span>
                            <button type="button" class="ml-2 text-red-500" @click="
                                selectedSkills.splice(index, 1);
                                if(skill.id.toString().startsWith('custom-')) {
                                    const skillName = skill.id.substring(7);
                                    const skillIndex = customSkills.indexOf(skillName);
                                    if(skillIndex !== -1) {
                                        customSkills.splice(skillIndex, 1);
                                    }
                                }
                            ">×</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Programming Languages -->
        <div class="mt-4"
            x-data="{
                selectedLanguages: {{ json_encode(old('programming_languages', $user->programmingLanguages->pluck('id')->toArray())) }},
                customLanguages: [],
                newLanguage: ''
            }">

            <x-input-label :value="__('Programming Languages')" />

            <!-- Multiple Select Dropdown -->
            <select name="programming_languages[]" class="block w-full" multiple
                x-on:change="selectedLanguages = Array.from($event.target.selectedOptions).map(option => ({ id: option.value, name: option.text }))">
                @foreach ($languages as $language)
                    <option value="{{ $language->id }}"
                        {{ in_array($language->id, old('programming_languages', $user->programmingLanguages->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $language->name }}
                    </option>
                @endforeach
            </select>

            <p class="text-sm text-gray-500 mt-1">Hold Ctrl (or Cmd on Mac) to select multiple languages</p>
            <div class="mt-2 flex">
                <x-text-input type="text" class="block w-full" x-model="newLanguage" placeholder="Enter a new language" />
                <button type="button" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded"
                        @click="if(newLanguage.trim() !== '') {
                            customLanguages.push(newLanguage);
                            selectedLanguages.push({ id: 'custom-'+newLanguage, name: newLanguage });
                            newLanguage = '';
                        }">
                    Add
                </button>
            </div>

            <!-- Hidden inputs for custom languages -->
            <template x-for="language in customLanguages" :key="language">
                <input type="hidden" name="addProgramming_languages[]" :value="language" />
            </template>

            <x-input-error :messages="$errors->get('programming_languages')" class="mt-2" />

            <!-- Display Selected Languages -->
            <div class="mt-2">
                <h3 class="font-semibold text-lg">Selected Programming Languages:</h3>
                <div class="mt-2 flex flex-wrap">
                    <template x-if="selectedLanguages.length === 0">
                        <span class="inline-block px-4 py-1 bg-gray-100 text-gray-500 rounded-full mr-2 mt-2">
                            No languages selected
                        </span>
                    </template>
                    <template x-for="(language, index) in selectedLanguages" :key="language.id">
                        <div class="inline-flex items-center px-4 py-1 bg-green-100 text-green-800 rounded-full mr-2 mt-2">
                            <span x-text="language.name"></span>
                            <button type="button" class="ml-2 text-red-500" @click="
                                selectedLanguages.splice(index, 1);
                                if(language.id.toString().startsWith('custom-')) {
                                    const langName = language.id.substring(7);
                                    const langIndex = customLanguages.indexOf(langName);
                                    if(langIndex !== -1) {
                                        customLanguages.splice(langIndex, 1);
                                    }
                                }
                            ">×</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>


        <!-- Projects -->
        <div class="mt-4" id="projects-container" x-data="{ projects: {{ json_encode(old('projects', $user->projects ?? [])) }} }">
            <x-input-label :value="__('Projects')" />

            <template x-if="projects.length === 0">
                <p>No projects available</p>
            </template>

            <template x-for="(project, index) in projects" :key="index">
                <div class="mt-2">
                    <x-text-input class="block w-full" type="text" x-model="projects[index].name" name="projects[][name]" placeholder="Project Name" />
                    <x-text-input class="block mt-1 w-full" type="text" x-model="projects[index].url" name="projects[][url]" placeholder="Project URL" />
                    <textarea class="block mt-1 w-full" x-model="projects[index].description" name="projects[][description]" placeholder="Project Description"></textarea>
                    <button type="button" class="mt-2 px-2 bg-red-500 text-white" @click="projects.splice(index, 1)">Remove</button>
                </div>
            </template>

            <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white" @click="projects.push({name: '', url: '', description: ''})">Add Another Project</button>

        </div>

        <!-- Certifications -->
        <div class="mt-4" id="certification-container" x-data="{ certifications: {{ json_encode(old('certification', $user->certifications ?? [])) }} }">
            <x-input-label :value="__('Certifications')" />

            <template x-if="certifications.length === 0">
                <p>No certifications available</p>
            </template>

            <template x-for="(certification, index) in certifications" :key="index">
                <div class="mt-2">
                    <x-text-input class="block w-full" type="text" x-model="certifications[index].name" name="certification[][name]" placeholder="Certification Name" />
                    <x-text-input class="block mt-1 w-full" x-model="certifications[index].url" name="certification[][url]" placeholder="Certification URL" />
                    <textarea class="block mt-1 w-full" x-model="certifications[index].description" name="certification[][description]" placeholder="Certification Description"></textarea>
                    <button type="button" class="mt-2 px-2 bg-red-500 text-white" @click="certifications.splice(index, 1)">Remove</button>
                </div>
            </template>

            <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white" @click="certifications.push({name: '', url: '', description: ''})">Add Another Certification</button>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button onclick="prepareAndSubmit(event)">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>




