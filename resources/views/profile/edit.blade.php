@extends('layouts.baseTemplate')

@section('title', 'Edit Profile - DevConnect')

@section('styles')
<style>
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid black;
        border-radius: 0.375rem;
        background-color: white;
        transition-property: all;
        transition-duration: 200ms;
    }
    .form-input:focus {
        border-color: #3b82f6;
        --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
        --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) #bfdbfe;
        box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
    }
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        letter-spacing: 0.025em;
    }
    .form-error {
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #ef4444;
    }
    .form-section {
        background-color: white;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        border: 1px solid #f3f4f6;
    }
</style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <header class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Profile Information
                </h2>
                <p class="text-gray-600">
                    Update your account's profile information and details.
                </p>
            </header>

            <!-- Profile Overview Card -->
            <div class="form-section mb-8">
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <div class="flex-shrink-0">
                        <img src=" {{Storage::url($user->image)}} " 
                             alt="Profile Image" 
                             class="w-32 h-32 rounded-full object-cover ring-4 ring-gray-100">
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $user->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $user->email }}</p>
                        <p class="text-gray-700 mb-4">{{ $user->bio ?? 'No bio yet.' }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', auth()-> user()->skills ?? 'PHP,Laravel,JavaScript') as $skill)
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="text-xl font-semibold mb-6">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                class="form-input" required>
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-input" required>
                            @error('email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Profile Image -->
                <div class="form-section">
                    <h3 class="text-xl font-semibold mb-6">Profile Image</h3>
                    <div class="flex items-center gap-6">
                        <img id="profile-preview" src="{{Storage::url($user->image)}}" 
                            alt="Profile Image" class="h-24 w-24 rounded-full object-cover ring-4 ring-gray-100">
                        <div class="flex-grow">
                            <label for="image" class="form-label">Update Profile Picture</label>
                            <input type="file" 
                                id="image"
                                value="{{Storage::url($user->image)}}"
                                name="profile_image"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept="image/*" 
                                onchange="previewImage(event)">
                            @error('image')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Bio & Skills -->
                <div class="form-section">
                    <h3 class="text-xl font-semibold mb-6">Bio & Skills</h3>
                    <div class="space-y-6">
                        <div>
                            <label for="bio" class="form-label">Professional Bio</label>
                            <textarea id="bio" name="bio" rows="4" class="form-input">{{  $user->bio }}</textarea>
                            @error('bio')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="skills" class="form-label">Skills</label>
                            <input type="text" id="skills" name="skills" value="{{ old('skills', $user->skills) }}"
                                class="form-input" placeholder="e.g. PHP, Laravel, JavaScript, React">
                            <p class="mt-2 text-sm text-gray-500">Separate skills with commas</p>
                            @error('skills')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="languages" class="form-label">languages</label>
                            <input type="text" id="languages" name="languages" value="{{ old('languages', $user->languages) }}"
                                class="form-input" placeholder="e.g. PHP, Laravel, JavaScript, React">
                            <p class="mt-2 text-sm text-gray-500">Separate languages with commas</p>
                            @error('languages')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="form-section">
                    <h3 class="text-xl font-semibold mb-6">Social Links</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="portfolio" class="form-label">GitHub Profile</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                                    </svg>
                                </div>
                                <input type="url" id="portfolio" name="portfolio" value="{{ old('portfolio', $user->portfolio) }}"
                                    class="form-input pl-10" placeholder="https://github.com/username">
                            </div>
                            @error('portfolio')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                       
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200">
                        Save Changes
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" 
                           x-show="show" 
                           x-transition 
                           x-init="setTimeout(() => show = false, 2000)"
                           class="text-sm text-green-600 bg-green-50 px-4 py-2 rounded-lg">
                            Changes saved successfully!
                        </p>
                    @endif
                </div>
            </form>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('profile-preview');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    @endsection