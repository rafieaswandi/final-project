<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'EventEase') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-md p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-xl font-bold">EventEase</h1>
                <nav>
                    <a href="/" class="mx-2 text-sm">Home</a>
                    @auth
                        <a href="/dashboard" class="mx-2 text-sm">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-red-500">Logout</button>
                        </form>
                    @else
                    @endauth
                </nav>
            </div>
        </header>
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto p-4">
                @yield('content')
            </div>
        </main>
        <footer class="bg-white shadow-md p-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} EventEase. All rights reserved.
        </footer>
    </div>
</body>
</html>
