<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verdefy Cosmetics</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative flex justify-center items-center min-h-screen bg-gray-100 dark:bg-gray-900">

        <div class="absolute w-full h-full">
            <img src="{{ asset('images/bgcos.jpg') }}" alt="" class="w-full h-full object-cover blur-sm opacity-60">
        </div>

        <div class="relative z-10 flex flex-col items-center text-center p-8 bg-white bg-opacity-80 rounded-xl shadow-lg">

            <h1 class="text-6xl font-extrabold text-gray-800" style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; letter-spacing: 6px;">
                WELCOME TO VERDEFY
            </h1>
            <p class="text-gray-700 mt-4 text-xl max-w-xl">
                Discover the world of **Verdefy**, a revolutionary cosmetics system committed to enhancing natural beauty through eco-friendly, sustainable, and cruelty-free products. We prioritize quality and innovation to help you look and feel your best.
            </p>

            <div class="mt-8 flex gap-4">
                <a href="{{ route('register') }}">
                    <button class="bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white py-3 px-6 rounded-lg shadow-lg transition-all duration-300">
                        Sign Up
                    </button>
                </a>
                <a href="{{ route('login') }}">
                    <button class="bg-gray-800 hover:bg-gray-900 text-white py-3 px-6 rounded-lg shadow-lg transition-all duration-300">
                        Login
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
