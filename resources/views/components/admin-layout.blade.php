<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet" />

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

        /* Dark Green Color Scheme */
        .bg-dark-green {
            background-color: #064e3b;
        }

        .text-dark-green {
            color: #064e3b;
        }

        .hover-dark-green:hover {
            background-color: #036d55;
            color: #ffffff;
        }

        .border-dark-green {
            border-color: #064e3b;
        }

        /* Yellow Accent */
        .text-yellow-500 {
            color: #fbbf24;
        }

        .bg-yellow-500 {
            background-color: #fbbf24;
        }

        .hover-yellow-500:hover {
            background-color: #eab308;
        }

        .btn-primary {
            background-color: #064e3b;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #036d55;
        }

    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @wireUiScripts
</head>

<body class="font-sans antialiased bg-white">

    @livewireScripts
    <x-dialog z-index="z-50" blur="md" align="center" />
    <x-notifications position="top-right" />


    <nav class="bg-dark-green border-gray-200">
        <div class="flex flex-wrap items-center justify-between mx-auto p-4">
            <a class="bg-white text-lg tracking-tight text-yellow-500 font-black uppercase focus:outline-none focus:ring lg:text-2xl" href="{{ route('admin-dashboard') }}">
                <img src="{{ asset('images/ver.png') }}" alt="Logo" class="w-16 h-20">
            </a>
            <button @click="open = !open" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-100 rounded-lg md:hidden hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            <div class="text-white hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 dark:bg-gray-800">
                    <li><a href="{{ route('customers') }}" class="hover-dark-green p-2">Customers</a></li>
                    <li><a href="{{ route('products') }}" class="hover-dark-green p-2">Products</a></li>
                    <li><a href="{{ route('dileverysched') }}" class="hover-dark-green p-2">Delivery Schedule</a></li>
                    <li><a href="{{ route('order') }}" class="hover-dark-green p-2">Orders</a></li>
                    {{-- <li><a href="{{ route('customizes') }}" class="hover-dark-green p-2">Customize Order</a></li> --}}
                    <li><a href="{{ route('admin-dashboard') }}" class="hover-dark-green p-2">Home</a></li>
                    <li><span class="underline">{{ Auth::user()->name }}</span></li>
                    <li><a href="{{ route('logout') }}" class="hover-yellow-500 p-2 text-red-500">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="p-8">
        <main class="border border-dark-green rounded-lg dark:border-gray-700">
            {{ $slot }}
        </main>
    </div>

    {{-- <!-- Chat Icon -->
    <div id="chatify-icon-container">
        <a href="{{ route('chatify') }}" class="chatify-icon">
            <i class="ri-messenger-fill md:text-8xl text-teal-600 hover:text-teal-700"></i>
        </a>
    </div> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var iconContainer = document.getElementById('chatify-icon-container');
            var isDragging = false;
            var offsetX, offsetY;

            iconContainer.addEventListener('mousedown', startDragging);
            document.addEventListener('mousemove', dragIcon);
            document.addEventListener('mouseup', stopDragging);

            iconContainer.addEventListener('touchstart', startDragging);
            document.addEventListener('touchmove', dragIcon);
            document.addEventListener('touchend', stopDragging);

            function startDragging(e) {
                isDragging = true;
                offsetX = e.clientX - iconContainer.getBoundingClientRect().left;
                offsetY = e.clientY - iconContainer.getBoundingClientRect().top;
            }

            function dragIcon(e) {
                if (isDragging) {
                    e.preventDefault();
                    iconContainer.style.left = (e.clientX - offsetX) + 'px';
                    iconContainer.style.top = (e.clientY - offsetY) + 'px';
                }
            }

            function stopDragging() {
                isDragging = false;
            }
        });
    </script>
</body>

</html>
