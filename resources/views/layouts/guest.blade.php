<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>VERDEFY</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center sm:pt-0 bg-gray-100">
            <div class="w-screen">
                <img src="{{ asset('images/bgcos.jpg') }}" alt="" class="w-full h-full blur-sm">
            </div>

            <div class="absolute w-full flex flex-col mt-20">
                <div class="flex justify-center">
                    <div >
                        <a href="/" wire:navigate>
                            <img src="{{ asset('images/cosmetics.png') }}" alt="" class="w-32 h-32 fill-current text-gray-500 mb-2" >
                        </a>
                    </div>
                </div>
              <div class="flex justify-center">
                <div class= "w-full sm:max-w-md  px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {{ $slot }}
                </div>
              </div>
            </div>
            </div>
    </body>
</html>
