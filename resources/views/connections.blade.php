@extends('layouts.baseTemplate')

@section('title', 'Friends - DevConnect')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Stats Section -->
        <div class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Stats Cards with subtle shadows and gradients -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-all">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <span class="block text-3xl font-bold">{{ count($connections)}}</span>
                            <span class="text-sm font-medium text-blue-100">Connections</span>
                        </div>
                    </div>
                </div>

                <!-- Similar styling for other stat cards -->
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-all">
                    <!-- Keep existing content but update styling -->
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <span class="block text-3xl font-bold">{{ count($pandingRequests) }}</span>
                            <span class="text-sm font-medium text-yellow-100">Pending</span>
                        </div>
                    </div>
                </div>

                <!-- Remaining stat cards with similar styling -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-all">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <span class="block text-3xl font-bold">{{ count($followers) }}</span>
                            <span class="text-sm font-medium text-green-100">Followers</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-all">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <span class="block text-3xl font-bold">{{ count($following) }}</span>
                            <span class="text-sm font-medium text-purple-100">Following</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Pending Invitations -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h2 class="text-xl font-bold text-gray-800">Pending Invitations</h2>
            </div>
            <div class="divide-y divide-gray-100 overflow-y-auto" style="height: 300px;">
            @foreach ($pandingRequests->take(2) as $request)
            <div class="p-6 hover:bg-gray-50 transition-all duration-300">
            <!-- Keep existing content for each pending request -->
            <div class="flex items-center space-x-4">
            <img src="{{ Storage::url($request->sender->image) ?? 'https://ui-avatars.com/api/?name=' . urlencode($request->sender->name) }}" 
             alt="{{ $request->sender->name }}" 
             class="w-14 h-14 rounded-full border-4 border-blue-100 shadow-sm">
            <div class="flex-1 min-w-0">
            <h3 class="text-lg font-semibold text-gray-900">{{ $request->sender->name }}</h3>
            <p class="text-sm text-gray-600">{{ $request->sender->headline ?? 'Developer' }}</p>
            </div>
            </div>
            <div class="flex space-x-3 mt-4">
            <form class="w-1/2" action="{{route("connections.accept", $request->sender->id )}}" method="POST">
            @csrf
            @method("POST")
            <button type="submit" class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-300 font-medium">Accept</button>
            </form>
            <form class="w-1/2" action="{{route("connections.ignore" , $request->sender->id )}}" method="POST">
            @csrf
            @method("POST")
            <button type="submit" class="w-full px-4 py-2.5 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-300 font-medium">Ignore</button>
            </form>
            </div>
            </div>
            @endforeach
            </div>
            </div>

            <!-- Current Connections -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
            <h2 class="text-xl font-bold text-gray-800">Your Connections</h2>
            </div>
            <div class="divide-y divide-gray-100 overflow-y-auto" style="height: 300px;">
            @foreach ($connections as $connection)
            <div class="p-6 hover:bg-gray-50 transition-all duration-300">
            <div class="flex items-center space-x-4">
            <img src="{{ Storage::url($connection->image) ?? 'https://ui-avatars.com/api/?name=' . urlencode($connection->name) }}" 
             alt="{{ $connection->name }}" 
             class="w-14 h-14 rounded-full border-4 border-green-100 shadow-sm">
            <div class="flex-1 min-w-0">
            <h3 class="text-lg font-semibold text-gray-900">{{ $connection->name }}</h3>
            <p class="text-sm text-gray-600">{{ $connection->headline ?? 'Developer' }}</p>
            <p class="text-xs text-gray-500 mt-1">Connected {{ $connection->pivot?->created_at->diffForHumans() ?? 'recently' }}</p>
            </div>
            </div>
            <div class="flex space-x-3 mt-4">
            <form action="" class="w-1/2">
            <button type="submit" class="w-full px-4 py-2.5 bg-indigo-100 text-indigo-700 rounded-xl hover:bg-indigo-200 transition-all duration-300 font-medium">Message</button>
            </form>
            <form action="{{route("connections.remove" ,  $connection->id  )}}" method="POST" class="w-1/2">
            @csrf
            @method("delete")
            <button type="submit" class="w-full px-4 py-2.5 border-2 border-red-500 text-red-500 rounded-xl hover:bg-red-50 transition-all duration-300 font-medium">Remove</button>
            </form>
            </div>
            </div>
            @endforeach
            </div>
            </div>

            <!-- People You May Know -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
            <h2 class="text-xl font-bold text-gray-800">People You May Know</h2>
            </div>
            <div class="divide-y divide-gray-100 overflow-y-auto" style="height: 300px;">
            @foreach ($otherusers as $suggestion)
            <div class="p-6 hover:bg-gray-50 transition-all duration-300">
            <div class="flex items-center space-x-4">
            <img src="{{ Storage::url($suggestion->image) ?? 'https://ui-avatars.com/api/?name=' . urlencode($suggestion->name) }}" 
             alt="{{ $suggestion->name }}" 
             class="w-14 h-14 rounded-full border-4 border-purple-100 shadow-sm">
            <div class="flex-1 min-w-0">
            <h3 class="text-lg font-semibold text-gray-900">{{ $suggestion->name }}</h3>
            <p class="text-sm text-gray-600">{{ $suggestion->headline ?? 'Developer' }}</p>
            @if ($suggestion->status == 'pending')
            <button class="mt-3 w-full px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl transition-all duration-300 font-medium">
            <i class="mr-2 fa-solid fa-hourglass-start"></i>Pending
            </button>
            @else
            <form action="{{route("connections.send" , $suggestion->id) }}" method="POST">
            @csrf
            @method("POST")
            <button type="submit" class="mt-3 w-full px-4 py-2.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all duration-300 font-medium">
            Connect
            </button>
            </form>
            @endif
            </div>
            </div>
            </div>
            @endforeach
            </div>
            </div>
        </div>
    </div>
</div>
@endsection