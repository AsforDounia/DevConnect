@extends('layouts.baseTemplate')

@section('title', 'Friends - DevConnect')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">


                <!-- Current Connections -->
                @foreach ($connections as $connection)
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

                        <div class="divide-y divide-gray-100 overflow-y-auto">
                            <div class="flex justify-end m-5">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="bg-red-500 rounded-full w-5 h-5 flex justify-center items-center">5</span>
                            </div>
                            <div class="p-6 hover:bg-gray-50 transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ Storage::url($connection->image) ?? 'https://ui-avatars.com/api/?name=' . urlencode($connection->name) }}"
                                        alt="{{ $connection->name }}"
                                        class="w-14 h-14 rounded-full border-4 border-green-100 shadow-sm">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $connection->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $connection->headline ?? 'Developer' }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Connected
                                            {{ $connection->pivot?->created_at->diffForHumans() ?? 'recently' }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-3 mt-4">
                                    <form action="{{ route('conversations.show', $connection->id) }}" class="w-1/2">
                                        <button type="submit"
                                            class="w-full px-4 py-2.5 bg-indigo-100 text-indigo-700 rounded-xl hover:bg-indigo-200 transition-all duration-300 font-medium">Message</button>
                                    </form>
                                    <form action="{{ route('connections.remove', $connection->id) }}" method="POST"
                                        class="w-1/2">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="w-full px-4 py-2.5 border-2 border-red-500 text-red-500 rounded-xl hover:bg-red-50 transition-all duration-300 font-medium">Remove</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
