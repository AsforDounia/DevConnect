<div class="comments-section">
    <div class="comments-list">
        @foreach($comments as $comment)
            <div class="flex items-start space-x-4">
                <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="User" class="w-8 h-8 rounded-full"/>
                <div>
                    <div class="font-semibold text-gray-800">{{ $comment->user->name }}</div>
                    <p class="text-gray-600">{{ $comment->content }}</p>
                    <p class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="comment-form mt-6">
        <textarea wire:model="content" class="w-full p-4 border rounded-xl focus:ring-blue-500 focus:border-blue-500 mt-4" placeholder="Write your comment..." required></textarea>
        <button wire:click="addComment" class="bg-blue-500 text-white px-6 py-2 rounded-lg mt-2" :disabled="content === ''">Add Comment</button>
    </div>
</div>
