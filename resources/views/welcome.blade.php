<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Professional Networking Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">DevConnect</h1>
                </div>
                <div class="flex space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-transparent hover:bg-blue-50 text-blue-600 px-4 py-2 rounded-lg border border-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <div class="bg-white h-[calc(100vh-4rem)]">
        <div class="max-w-7xl mx-auto px-4 h-full flex items-center">
            <div class="text-center w-full">
                <h2 class="text-5xl font-bold text-gray-900 mb-6">Welcome to DevConnect</h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Your gateway to professional opportunities. Connect, grow, and advance your career with our powerful networking platform.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{route('register')}}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 text-lg">Get Started</a>
                    <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-lg border border-blue-600 hover:bg-blue-50 text-lg">Learn More</a>
                </div>
            </div>
        </div>
    </div>


</body>
</html>