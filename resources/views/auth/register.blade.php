<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="w-[60rem]">
        <div class="flex gap-10">
            @csrf
            <!-- Left Section -->
            <div class="w-1/2 p-8 pt-4 border-2  border-black m-2 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg" >
                <h1 class="text-2xl font-semibold text-red-600 text-center mb-6 py-4 px-6 bg-red-100 rounded-lg shadow-md max-w-3xl mx-auto">
                    This section is required
                </h1>

                <!-- Profile Picture -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mr-4" id="preview-container">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <x-input-label for="profile_picture" :value="__('Profile Picture')" class="font-medium text-gray-700" />
                            <x-text-input id="profile_picture" class="mt-1 w-full py-2 px-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="file" name="profile_picture" :value="old('profile_picture')"  autofocus autocomplete="profile_picture" onchange="previewImage(this)" />
                            <p class="text-xs text-gray-500 mt-1">JPG or PNG recommended</p>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                </div>

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <!-- Right Section -->
            <div class="w-1/2 overflow-auto p-8 pt-4 border-2  border-black m-2 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg" style="height: calc(80vh - 11px);">
                <h1 class="text-2xl font-semibold text-gray-800 text-center mb-6 py-4 px-6 bg-gray-100 rounded-lg shadow-md max-w-3xl mx-auto">
                    You can fill out this section now or later
                </h1>

                <!-- Skills Selection -->
                <div class="mt-4" x-data="{ selectedSkills: {{ json_encode(old('skills', [])) }}, newSkill: '' }">
                    <x-input-label :value="__('Skills')" />
                    <select
                        name="skills[]"
                        class="block w-full"
                        multiple
                        x-on:change="selectedSkills = Array.from($event.target.selectedOptions).map(option => ({ id: option.value, name: option.text }))">
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}" {{ in_array($skill->id, old('skills', [])) ? 'selected' : '' }}>
                                {{ $skill->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Hold Ctrl (or Cmd on Mac) to select multiple skills</p>

                    <!-- Add New Skill Input -->
                    <div class="mt-2 flex">
                        <x-text-input name="addSkills[]" type="text" class="block w-full" x-model="newSkill" placeholder="Enter a new skill" />
                        <button type="button" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded"
                                @click="if(newSkill.trim() !== '') {
                                    selectedSkills.push({ id: newSkill, name: newSkill }); // Add the new skill to the selectedSkills array
                                    $refs.skillInput.value = newSkill; // Ensure the input value gets transferred to the hidden input field
                                    newSkill = ''; // Clear the input field
                                }">
                            Add
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('skills')" class="mt-2" />

                    <!-- Hidden input for addSkills -->
                    <input type="hidden" x-ref="skillInput" name="addSkills[]" :value="newSkill" />

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
                                    <button type="button" class="ml-2 text-red-500" @click="selectedSkills.splice(index, 1)">×</button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>


                <!-- Programming Languages -->
                <div class="mt-4"
                    x-data="{
                        selectedLanguages: {{ json_encode(old('programming_languages', [])) }},
                        availableLanguages: {{ json_encode($languages) }},
                        newLanguage: ''
                    }">

                    <x-input-label :value="__('Programming Languages')" />

                    <!-- Multiple Select Dropdown -->
                    <select name="programming_languages[]" class="block w-full" multiple
                        x-on:change="selectedLanguages = Array.from($event.target.selectedOptions).map(option => ({ id: option.value, name: option.text }))">
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}"
                                {{ in_array($language->id, old('programming_languages', [])) ? 'selected' : '' }}>
                                {{ $language->name }}
                            </option>
                        @endforeach
                    </select>

                    <p class="text-sm text-gray-500 mt-1">Hold Ctrl (or Cmd on Mac) to select multiple languages</p>
                    <div class="mt-2 flex">
                        <x-text-input name="" type="text" class="block w-full" x-model="newLanguage" placeholder="Enter a new language" />
                        <button type="button" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded"
                                @click="if(newLanguage.trim() !== '') {
                                    // Add the new language to the selected languages list
                                    selectedLanguages.push({ id: newLanguage, name: newLanguage });
                                    // Push the new language to the addProgramming_languages array
                                    $refs.languageInput.push(newLanguage);
                                    newLanguage = ''; // Clear the input field
                                }">
                            Add
                        </button>
                    </div>

                    <!-- Hidden input for addProgramming_languages -->
                    <input type="hidden" x-ref="languageInput" name="addProgramming_languages[]" :value="newLanguage" />


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
                                    <button type="button" class="ml-2 text-red-500" @click="selectedLanguages.splice(index, 1)">×</button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Projects -->
                <div class="mt-4" id="projects-container" x-data="{ projects: {{ json_encode(old('projects', [])) }} }">
                    <x-input-label :value="__('Projects')" />
                    <template x-for="(project, index) in projects" :key="index">
                        <div class="mt-2">
                            <x-text-input class="block w-full" type="text" x-model="projects[index].name" name="projects[][name]" placeholder="Project Name" />
                            <x-text-input class="block mt-1 w-full" type="text" x-model="projects[index].url" name="projects[][url]" placeholder="Project URL" />
                            <textarea class="block mt-1 w-full" x-model="projects[index].description" name="projects[][description]" placeholder="Project Description"></textarea>
                            <button type="button" class="mt-2 px-2 bg-red-500 text-white" @click="projects.splice(index, 1)">Remove</button>
                        </div>
                    </template>
                    <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white" @click="projects.push({})">Add Another Project</button>
                </div>


                <!-- Certifications -->
                <div class="mt-4" id="certification-container" x-data="{ certifications: {{ json_encode(old('certification', [])) }} }">
                    <x-input-label :value="__('Certifications')" />
                    <template x-for="(certification, index) in certifications" :key="index">
                        <div class="mt-2">
                            <x-text-input class="block w-full" type="text" x-model="certifications[index].name" name="certification[][name]" placeholder="Certification Name" />
                            <x-text-input class="block mt-1 w-full" x-model="certifications[index].url" name="certification[][url]" placeholder="Certification URL" />
                            <textarea class="block mt-1 w-full" x-model="certifications[index].description" name="certification[][description]" placeholder="Certification Description"></textarea>
                            <button type="button" class="mt-2 px-2 bg-red-500 text-white" @click="certifications.splice(index, 1)">Remove</button>
                        </div>
                    </template>
                    <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white" @click="certifications.push({})">Add Another Certification</button>
                </div>


            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.getElementById('preview-container');
                previewContainer.innerHTML = `<img src="${e.target.result}" class="w-16 h-16 rounded-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
