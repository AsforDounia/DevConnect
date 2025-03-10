@extends('layouts.baseTemplate')

@section('title', 'Dashboard - DevConnect')
@livewireStyles
@section('content')
    <!-- Main Content -->

@section('content')
<div class="max-w-4xl mx-auto my-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Conversation Header -->
        <div class="bg-white px-6 py-4 border-b flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                    <span class="text-indigo-700 font-medium">{{ substr($receiver->name, 0, 1) }}</span>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $receiver->name }}</h3>
                    <p class="text-sm text-gray-500">
                        @if($receiver->is_online)
                            <span class="text-green-500">● Online</span>
                        @else
                            <span class="text-gray-400">Last seen {{ $receiver->last_activity_at }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <a href="{{ url()->previous() }}" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <!-- Messages Container -->
        <div id="messages-container" class="h-96 overflow-y-auto p-6 bg-gray-50">
            @if(count($messages) > 0)
                @foreach($messages as $message)
                    <div class="mb-4 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}">
                        <div class="inline-block max-w-xs sm:max-w-md {{ $message->sender_id === Auth::id() ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-200 text-gray-800' }} rounded-lg px-4 py-2 shadow-sm">
                            <p class="m-0">{{ $message->content }}</p>
                        </div>
                        <div class="mt-1 text-xs text-gray-500">
                            {{ $message->created_at->format('g:i a') }}
                            @if($message->sender_id === Auth::id())
                                · {{ $message->is_read ? 'Read' : 'Delivered' }}
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex flex-col items-center justify-center h-full text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @endif
        </div>

        <!-- Message Input -->
        <div class="px-6 py-4 bg-white border-t">
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                <div class="flex space-x-2">
                    <input type="text" name="content" class="flex-1 border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-md sm:text-sm" placeholder="Type your message..." required>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -ml-1 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Scroll to bottom of messages container on page load
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages-container');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});
</script>
@endsection



@livewireScripts
@endsection
