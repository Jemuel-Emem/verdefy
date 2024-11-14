<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Furniture') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css"
    rel="stylesheet"/>

    <style>
        [x-cloak] {
            display: none;
        }

        #chatify-icon-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .chatify-icon {
        display: block;
    }
    </style>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
     @wireUiScripts
    @livewireStyles
</head>

<body class="font-sans antialiased">
    @livewireScripts
    <x-dialog z-index="z-50" blur="md" align="center" />
    <x-notifications position="top-right" />
<div class="relative">
    <div class="w-screen h-screen">
        <img src="{{ asset('images/bg1.jpg') }}" alt="" class="w-full h-full blur-sm">
    </div>
    <div class="absolute top-2 w-screen ">
        <div class="w-full mx-auto bg-white border-b 2xl:max-w-8xl">
            <div x-data="{ open: false }" class="relative flex flex-col w-full p-5 mx-auto bg-amber-900 text-white md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
              <div class="flex flex-row items-center justify-between lg:justify-start">
                <a class="text-lg tracking-tight text-black uppercase focus:outline-none focus:ring lg:text-2xl" href="{{ route('admin-dashboard') }}">
                  <img src="{{ asset('images/logonani.png') }}" alt="" class="w-16 h-20">
                </a>
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 text-gray-400 hover:text-black focus:outline-none focus:text-black md:hidden">
                  <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
              <nav :class="{'flex': open, 'hidden': !open}" class="flex-col items-center flex-grow hidden md:pb-0 md:flex md:justify-end md:flex-row ml-44">

                <a class="px-2 py-2 text-sm text-white lg:ml-auto lg:px-6 md:px-3 hover:text-gray-200" href="{{ route('customers') }}">
                  Customers
                </a>

                <a href="{{ route('products') }}" class="px-2 py-2 text-sm text-white lg:px-6 md:px-3 hover:text-gray-200" href="#">
                  Products
                </a>
                <a class="px-2 py-2 text-sm text-white lg:px-6 md:px-3 hover:text-gray-200" href="{{ route('dileverysched') }}">
                    Delivery Schedule
                  </a>
                <a class="px-2 py-2 text-sm text-white lg:px-6 md:px-3 hover:text-gray-200" href="{{ route('order') }}">
                Orders
                </a>
                <a class="px-2 py-2 text-sm text-white lg:px-6 md:px-3 hover:text-gray-200" href="{{ route('customizes') }}" >
                    Customize Order
                </a>

                <div class="inline-flex items-center gap-2 list-none lg:ml-auto">

                    <a class="px-2 py-2 text-sm text-white lg:ml-auto lg:px-6 md:px-3 hover:text-gray-200" href="{{ route('admin-dashboard') }}">
                        Home
                      </a>
                         <span class="underline">{{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}"> <button class="block px-4 py-2 mt-2 text-sm text-red-500 md:mt-0 hover:text-red-600 focus:outline-none focus:shadow-outline">
                            LOGOUT
                             </button></a>


                </div>
              </nav>
            </div>
          </div>
          <main>
                <div class="">
                    <div class="  border-gray-200  rounded-lg dark:border-gray-700">
                        <main>
                            {{ $slot }}
                        </main>
                    </div>
                </div>
          </main>
    </div>

    <div id="chatify-icon-container">
        <a href="{{ route('chatify') }}" class="chatify-icon">
            <i class="ri-messenger-fill text-8xl text-blue-500 hover:text-blue-600"></i>
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var iconContainer = document.getElementById('chatify-icon-container');
        var isDragging = false;
        var offsetX, offsetY;

        iconContainer.addEventListener('mousedown', function (e) {
            isDragging = true;
            offsetX = e.clientX - iconContainer.getBoundingClientRect().left;
            offsetY = e.clientY - iconContainer.getBoundingClientRect().top;
        });

        document.addEventListener('mousemove', function (e) {
            if (isDragging) {
                var x = e.clientX - offsetX;
                var y = e.clientY - offsetY;

                iconContainer.style.left = x + 'px';
                iconContainer.style.top = y + 'px';
            }
        });

        document.addEventListener('mouseup', function () {
            isDragging = false;
        });
    });
</script>

</body>

</html>
