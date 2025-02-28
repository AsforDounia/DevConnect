<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-400">
            &lt;{{ __('DevConnect/') }}&gt;
        </h2>
    </x-slot>
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto pt-24 px-4 bg-gray-50 min-h-screen">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Profile Card -->
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="relative">
                        <div class="h-32 bg-gradient-to-br from-blue-500 to-purple-600"></div>
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 w-24 h-24 rounded-2xl border-4 border-white shadow-lg"/>

                    </div>
                    <div class="pt-12 p-6">
                        <div class="flex items-center justify-center">
                            <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                            @isset($github)
                                <a href="{{ $github }}" target="_blank" class="ml-3 text-gray-600 hover:text-black transition-colors">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </a>
                            @else
                                <a href="/profile" target="_blank" class="ml-3 text-gray-600 hover:text-black transition-colors group">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                    <p class="hidden text-red-600 absolute z-50 top-[19rem] left-86 group-hover:block">
                                        Add your GitHub link
                                    </p>
                                </a>
                                {{-- <p class="group-hover:bg-red-600">add your github link</p> --}}
                            @endisset


                        </div>

                        <div class="text-gray-600 text-sm mt-2 text-center">
                            @isset($biography)
                                {{ $biography }}
                            @else
                                This user has not set a biography.
                            @endisset
                        </div>


                        <div class="mt-6 flex flex-wrap gap-2 justify-center">
                            <h1 class="w-full">Skills :</h1>
                            @forelse ($skills as $skill)
                                <span class="px-3 py-1.5 bg-green-50 text-green-600 rounded-lg text-xs font-medium">{{ $skill->name }}</span>
                            @empty
                                <p class="text-gray-500 text-sm mt-2 text-center">No skills added yet</p>
                            @endforelse
                        </div>
                        <div class="mt-6 flex flex-wrap gap-2 justify-center">
                            <h1 class="w-full">Programming Languages :</h1>
                            @isset($languages)
                                @forelse ($languages as $language)
                                    <span class="px-3 py-1.5 bg-green-50 text-green-600 rounded-lg text-xs font-medium">{{ $language->name }}</span>
                                @empty
                                    <p class="text-gray-500 text-sm mt-2 text-center">No Programming Languages added yet</p>
                                @endforelse
                            @else
                                <p class="text-gray-500 text-sm mt-2 text-center">No Programming Languages added yet</p>
                            @endisset
                            </div>

                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div class="p-3 rounded-xl bg-gray-50">
                                    <p class="text-2xl font-bold text-gray-800">487</p>
                                    <p class="text-xs text-gray-500 mt-1">Connections</p>
                                </div>
                                <div class="p-3 rounded-xl bg-gray-50">
                                    <p class="text-2xl font-bold text-gray-800">52</p>
                                    <p class="text-xs text-gray-500 mt-1">Posts</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trending Tags -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="font-semibold mb-4 text-gray-800">Trending Tags</h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <span class="text-gray-600 group-hover:text-blue-600 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                                #javascript
                            </span>
                            <span class="text-gray-400 text-sm">2.4k</span>
                        </a>
                        <a href="#" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <span class="text-gray-600 group-hover:text-purple-600 flex items-center">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mr-2"></span>
                                #react
                            </span>
                            <span class="text-gray-400 text-sm">1.8k</span>
                        </a>
                        <a href="#" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <span class="text-gray-600 group-hover:text-green-600 flex items-center">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                #webdev
                            </span>
                            <span class="text-gray-400 text-sm">1.2k</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="lg:col-span-6 space-y-6">
                <!-- Post Creation -->
                <div x-data="{ showForm: false }" class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="User" class="w-12 h-12 rounded-full"/>
                        <button
                            @click="showForm = !showForm"
                            class="bg-gray-50 hover:bg-gray-100 text-gray-600 text-left rounded-xl px-6 py-4 flex-grow transition-all duration-200 hover:ring-2 hover:ring-blue-100">
                            Share your knowledge or ask a question...
                        </button>
                    </div>

                    <!-- Post Form -->
                    <div x-show="showForm" class="mt-6">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Title -->
                            <input type="text" name="title" class="w-full p-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500" placeholder="Post Title" required>

                            <!-- Content -->
                            <textarea name="content" rows="4" class="w-full p-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500 mt-4" placeholder="Write your post..." required></textarea>

                            <!-- Hashtags -->
                            <input type="text" name="hashtags" class="w-full p-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500 mt-4" placeholder="Add hashtags (comma separated)" required>

                            <!-- Image -->
                            <div class="mt-4">
                                <label for="image" class="block text-gray-600">Upload Image (optional)</label>
                                <input type="file" name="image" id="image" class="w-full p-2 border rounded-xl focus:ring-blue-500 mt-2">
                            </div>

                            <div class="mt-4 flex justify-between">
                                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Post</button>
                                <button type="button" @click="showForm = false" class="text-gray-500 hover:text-gray-700">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Posts -->
                @forelse ($posts as $post)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100" x-data="{ showEditForm: false }">
                        @if($post->user_id == Auth::id())
                            <div class="flex items-center justify-end p-4 space-x-4">
                                <!-- Edit Button -->
                                <button @click="showEditForm = !showEditForm" class="text-blue-500 hover:text-blue-700">
                                    {{-- <x-far-edit /> --}}
                                    edit
                                </button>
                                <!-- Delete Button -->
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        {{-- <x-fas-trash /> --}}
                                        delete
                                    </button>
                                </form>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="User" class="w-12 h-12 rounded-full"/>
                                    <div>
                                        <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                        <p class="text-gray-500 text-sm">{{ $post->title }}</p>
                                        <p class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <button class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                    </svg>
                                </button>
                            </div>
                            @if($post->title)
                                <div class="mt-6 flex flex-wrap gap-2">
                                    <h3 class="font-semibold">{{ $post->title }}</h3>
                                </div>
                            @endif
                            @if($post->hashtags)
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach(json_decode($post->hashtags) as $hashtag)
                                        <span class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium">#{{ $hashtag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="mt-6">
                                <p class="text-gray-700">{{ $post->content }}</p>
                                <div>
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image " class="w-full h-64 object-cover rounded-2xl">
                                </div>
                                <div class="mt-6 flex items-center justify-between border-t pt-6">
                                    <div class="flex items-center space-x-4">
                                        <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                            </svg>
                                            <span>{{ $post->likes()->count() }}</span>
                                        </button>
                                        <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                            </svg>
                                            <span>{{ $post->comments()->count() }}</span>
                                        </button>
                                    </div>
                                    <button class="text-gray-500 hover:text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div x-show="showEditForm">
                            <div class="fixed -inset-20 mt-0 bg-gray-500  flex justify-center items-center z-50">
                                <div class="bg-white border-2 w-1/2 p-12">
                                        <h3 class="text-lg font-bold text-center m-2">Update Post</h3>
                                    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" >
                                        @csrf
                                        @method('PUT')

                                        <!-- Title -->
                                        <input type="text" name="title" class="w-full p-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500" value="{{ $post->title }}" required>

                                        <!-- Content -->
                                        <textarea name="content" rows="4" class="w-full p-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500 mt-4" required>{{ $post->content }}</textarea>

                                        <!-- Hashtags -->
                                        <input type="text" name="hashtags" class="w-full p-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500 mt-4" value="{{ implode(',', json_decode($post->hashtags)) }}" required>

                                        <!-- Image -->
                                        <div class="mt-4">
                                            <label for="image" class="block text-gray-600">Upload Image (optional)</label>
                                            <input type="file" name="image" id="image" class="w-full p-2 border rounded-xl focus:ring-blue-500 mt-2">
                                        </div>

                                        <div class="mt-4 flex justify-between">
                                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Update Post</button>
                                            <button type="button" @click="showEditForm = false" class="text-gray-500 hover:text-gray-700">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                @empty
                    <div class="flex justify-center items-center h-screen"> No posts found.</div>
                @endforelse

            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Job Recommendations -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="font-semibold mb-6 text-gray-800">Job Recommendations</h3>
                    <div class="space-y-6">
                        <div class="p-4 hover:bg-gray-50 rounded-xl transition-all duration-200 border border-gray-100">
                            <div class="flex items-start space-x-3">
                                <img src="/api/placeholder/40/40" alt="Company" class="w-10 h-10 rounded"/>
                                <div>
                                    <h4 class="font-medium">Senior Full Stack Developer</h4>
                                    <p class="text-gray-500 text-sm">TechStart Inc.</p>
                                    <p class="text-gray-500 text-sm">Remote • Full-time</p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">React</span>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Node.js</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 hover:bg-gray-50 rounded-xl transition-all duration-200 border border-gray-100">
                            <div class="flex items-start space-x-3">
                                <img src="/api/placeholder/40/40" alt="Company" class="w-10 h-10 rounded"/>
                                <div>
                                    <h4 class="font-medium">DevOps Engineer</h4>
                                    <p class="text-gray-500 text-sm">CloudScale Solutions</p>
                                    <p class="text-gray-500 text-sm">San Francisco • Hybrid</p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">AWS</span>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Docker</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="mt-4 w-full text-blue-500 hover:text-blue-600 text-sm font-medium">
                        View All Jobs
                    </button>
                </div>

                <!-- Suggested Connections -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="font-semibold mb-4">Suggested Connections</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="https://avatar.iran.liara.run/public/boy" alt="User" class="w-10 h-10 rounded-full"/>
                                <div>
                                    <h4 class="font-medium">Emily Zhang</h4>
                                    <p class="text-gray-500 text-sm">Frontend Developer</p>
                                </div>
                            </div>
                            <button class="text-blue-500 hover:text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: true
            }).then(() => {
                @php session()->forget('success'); @endphp
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur!',
                text: "{{ session('error') }}",
                timer: 4000,
                showConfirmButton: true
            }).then(() => {
                @php session()->forget('error'); @endphp
            });
        @endif
    });
</script>
