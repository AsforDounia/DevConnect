@extends('layouts.baseTemplate')

@section('title', 'Dashboard - DevConnect')
@livewireStyles
@section('content')
@if (session('post_deleted'))
    <div x-data="{ showAlert: true }" x-show="showAlert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('post_deleted') }}</span>
        <span @click="showAlert = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
            </svg>
        </span>
    </div>
@endif
    <!-- Main Content -->
    <div class="w-1/2 mx-auto px-4 pb-10" x-data="{ showModal: false, contentType: '' }">
        <div class="">
            <!-- Main Feed -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Creation -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center space-x-4">
                        <img src="{{ Storage::url(auth()-> user() -> image) }}" alt="User" class="w-12 h-12 rounded-full"/>
                        <button @click="showModal = true" class="bg-gray-100 hover:bg-gray-200 text-gray-500 text-left rounded-lg px-4 py-3 flex-grow transition-colors duration-200">
                            Share your knowledge or ask a question...
                        </button>
                    </div>
                    <div class="flex justify-between mt-4 pt-4 border-t">
                        <button @click="showModal = true; contentType = 'code'" class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                            <span>Code</span>
                        </button>
                        <button @click="showModal = true; contentType = 'image'" class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Image</span>
                        </button>
                        <button @click="showModal = true; contentType = 'link'" class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span>Link</span>
                        </button>
                    </div>
                </div>

                <!-- Modal -->
                <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Create Post</h3>
                            <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="/posts" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="mb-4">
                                <textarea name="content" placeholder="Write your post..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Add Content:</label>
                                <div class="flex space-x-4 mt-2">
                                    <div x-show="contentType === 'image'">
                                        <input type="file" name="image" class="hidden" id="image-upload">
                                        <label for="image-upload" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-500 px-4 py-2 rounded-lg transition-colors duration-200">Image</label>
                                    </div>
                                    <input x-show="contentType === 'link'" type="text" name="link" placeholder="Add a link..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    <textarea x-show="contentType === 'code'" name="code" placeholder="Add code snippet..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                                </div>
                                <!-- hashtags -->
                                <div class="my-4">
                                    <textarea name="hashtags" placeholder="tags separated by commas: PHP, JS, MYSQL..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Edit Post Modal -->
                <div id="editPostModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                        <div class="flex justify-between items-center border-b pb-3 mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Edit Post</h3>
                            <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form id="editPostForm" action="/posts" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <textarea name="content" id="editPostContent" placeholder="Edit your post..." class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Posts -->
                @foreach ($allPosts as $post)
                    <div class="bg-white rounded-xl shadow-sm post">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ Storage::url($post -> user -> image) }}" alt="User" class="w-12 h-12 rounded-full"/>
                                <div>
                                    <h3 class="font-semibold">{{$post -> user -> name}}</h3>
                                    <p class="text-gray-400 text-xs">{{ $post -> created_at -> diffForHumans() }}</p>
                                </div>
                            </div>
                           @if (Auth::user() -> id === $post -> user_id)
                           <div class="relative" x-data="{ open: false }">
                                <button class="text-gray-400 hover:text-gray-600 transition-colors duration-200" @click="open = !open">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-20">
                                    <button data-id="{{$post  -> id}}" data-content="{{$post -> content}}" class="edit-post block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit Post</button>
                                    <form action="/posts/{{ $post -> id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class=" block px-4 py-2 text-rose-700 hover:bg-gray-100 transition-colors duration-200">Delete Post</button>
                                    </form>

                                </div>
                            </div>

                           @endif
                        </div>

                        <div class="mt-4">
                            <p class="text-gray-700">{{ $post -> content }}</p>

                            @if ($post -> post_type === 'image')
                                <img src="{{ Storage::url($post -> content_type) }}" alt="Post Image" class="w-full h-auto max-h-96 object-cover rounded-lg mt-4">
                            @elseif ($post -> post_type === 'code')
                            <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200 overflow-x-auto">
                                <pre><code>{{$post -> content_type}}</code></pre>
                            </div>
                            @elseif ($post -> post_type === 'link')
                                <a href="https://{{ $post -> content_type }}" target="_blank" class="text-blue-500 hover:underline break-words">
                                    <div class="border border-gray-300 rounded-lg p-2 mt-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                            <span>{{ $post -> content_type }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            <div class="mt-4 flex flex-wrap gap-2">
                                @forelse (explode(',', trim($post->hashtags)) as $tag)
                                    @if(!empty($tag))
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $tag }}</span>
                                    @endif
                                @empty
                                    <!-- No tags to display -->
                                @endforelse
                            </div>

                            <div class="mt-4 flex items-center justify-between border-t pt-4">
                                <div class="flex items-center space-x-4">
                                    {{-- <form action="/posts/{{ $post -> id }}/like" method="post">
                                        @csrf
                                    <button type="submit" class="flex items-center space-x-2 {{
                                        $post -> likes -> contains('user_id', Auth::user() -> id) ? 'text-blue-500' : 'text-gray-500'
                                    }} hover:text-blue-500 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                        </svg>
                                        <span>{{ count($post -> likes) }}</span>
                                    </button>
                                    </form> --}}
                                    @livewire('like',['post'=>$post])
                                    <button id="comments-toggle" class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                        <span>{{ count($post -> comments) }}</span>
                                    </button>
                                </div>
                                <div class="relative" x-data="{ shareOpen: false }">
                                    <button @click="shareOpen = !shareOpen" class="text-gray-500 hover:text-blue-500 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                    </button>
                                    <div x-show="shareOpen" @click.away="shareOpen = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-20">
                                        {{-- Use route() helper instead of hardcoded URLs --}}
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->id)) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700">
                                             <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                  <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                                             </svg>
                                             Share on Facebook
                                        </a>

                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->id)) }}&text={{ Str::limit($post->content, 100) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700">
                                             <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                  <path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/>
                                             </svg>
                                             Share on Twitter
                                        </a>

                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('posts.show', $post->id)) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700">
                                             <svg class="w-5 h-5 mr-2 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                                                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                             </svg>
                                             Share on LinkedIn
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section - Hidden by Default -->
                    <div class="comments-section transition-all duration-200 hidden border-t p-4 space-y-4">
                        <h4 class="font-medium text-gray-700">Comments ({{ count($post -> comments) }})</h4>

                        <div class="max-h-64 overflow-y-auto">
                            @foreach ($post -> comments as $index => $comment)
                                @if ($index < 4)
                                    <!-- Comment -->
                                    <div class="flex space-x-3">
                                        <img src="{{Storage::url($comment -> user -> image)}}" alt="User" class="w-8 h-8 rounded-full mt-1"/>
                                        <div class="flex-1">
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <h5 class="font-medium text-sm">{{ $comment -> user -> name }}</h5>
                                                    <span class="text-gray-400 text-xs">{{$comment -> created_at -> diffForHumans()}}</span>
                                                </div>
                                                <p class="text-gray-700 text-sm mt-1">{{$comment -> content}}</p>
                                            </div>
                                            @if (Auth::user() -> id === $comment -> user_id)
                                            <div class="flex items-center space-x-4 mt-2 ml-2">
                                                <form action="{{route('comments.destroy',$comment -> id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="text-xs text-gray-500 hover:text-blue-500 transition-colors duration-200">Delete</button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- New Comment Input -->
                        <div class="flex space-x-3 mt-4">
                            <img src="{{ Storage::url(Auth::user() -> image )}}" alt="User" class="w-8 h-8 rounded-full"/>
                            <div class="flex-1">
                                <form action="{{route('comments.store')}}" method="post">
                                    @csrf
                                    <input type="text" name="post_id" value="{{$post -> id}}" class="hidden">
                                    <textarea name="comment" placeholder="Write a comment..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                                    @error('comment')
                                        <span>{{$message}}</span>
                                    @enderror
                                    <div class="flex justify-end mt-2">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-lg text-sm transition-colors duration-200">Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                @endforeach
                {{ $allPosts -> links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // comments
    document.addEventListener('DOMContentLoaded', function() {
        let posts = document.querySelectorAll('.post');
        posts.forEach((post) => {
            let commentsToggle = post.querySelector('#comments-toggle');
            let commentsSection = post.querySelector('.comments-section');
            commentsToggle.addEventListener('click', () => {
                commentsSection.classList.toggle('hidden');
            });
        });
    });
    // edit post
    let editBtn = document.querySelectorAll(".edit-post");
    let editModel = document.getElementById('editPostModal');
    let closeModal = document.getElementById('closeModal');
    editBtn.forEach((btn) => {
        btn.addEventListener("click", () => {
            editModel.classList.remove('hidden');
            let postId = btn.getAttribute('data-id');
            let content = btn.getAttribute('data-content');
            let editPostForm = document.getElementById('editPostForm');
            let editPostinput = document.getElementById('editPostContent');
            editPostinput.textContent = content;
            editPostForm.action = `/posts/${postId}`;

        });
    });
    closeModal.addEventListener('click',()=> {
        editModel.classList.add('hidden');
    })
    // comments section
    let posts = document.querySelectorAll('.post');
    posts.forEach((post) => {
        let commentsToggle = post.querySelector('#comments-toggle');
        let commentsSection = post.querySelector('#comments-section');
        commentsToggle.addEventListener('click', () => {
            commentsSection.classList.toggle('hidden');
        });
    });
</script>
@livewireScripts
@endsection
