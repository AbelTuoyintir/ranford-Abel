<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCC-ELECTIONS</title>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const assetBaseUrl = "{{ asset('storage/') }}"; // Laravel storage path
    </script>
    @livewireStyles

    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class="rounded-full w-16 h-16">
    @vite(["resources/css/app.css", "resources/js/app.js"])

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarButton = document.querySelector('[data-drawer-toggle="sidebar-multi-level-sidebar"]');
            const sidebar = document.getElementById('sidebar-multi-level-sidebar');
            const body = document.body;

            // Toggle sidebar visibility
            sidebarButton.addEventListener('click', function (event) {
                sidebar.classList.toggle('-translate-x-full'); // Toggle visibility
                event.stopPropagation(); // Prevent event from bubbling up to document
            });

            // Close the sidebar when clicking outside of it
            body.addEventListener('click', function (event) {
                if (!sidebar.contains(event.target) && !sidebarButton.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full'); // Hide the sidebar
                }
            });

            // Prevent the click event from closing the sidebar if it is clicked inside
            sidebar.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent click from bubbling up
            });

            // Profile dropdown toggle functionality
            const profileButton = document.getElementById('profile-dropdown');
            const profileMenu = document.getElementById('profile-menu');

            profileButton.addEventListener('click', function (event) {
                profileMenu.classList.toggle('hidden'); // Toggle visibility of the profile menu
                event.stopPropagation(); // Prevent event from bubbling up
            });

            // Close the dropdown menu when clicking outside of it
            body.addEventListener('click', function (event) {
                if (!profileMenu.contains(event.target) && !profileButton.contains(event.target)) {
                    profileMenu.classList.add('hidden'); // Hide the dropdown menu
                }
            });

            // Security dropdown toggle functionality
            const securityButton = document.getElementById('products-dropdown');
            const securityMenu = document.getElementById('products-menu');

            securityButton.addEventListener('click', function (event) {
                securityMenu.classList.toggle('hidden'); // Toggle visibility of the security menu
                event.stopPropagation(); // Prevent event from bubbling up
            });

            // Close the security dropdown menu when clicking outside of it
            body.addEventListener('click', function (event) {
                if (!securityMenu.contains(event.target) && !securityButton.contains(event.target)) {
                    securityMenu.classList.add('hidden'); // Hide the dropdown menu
                }
            });
        });
    </script>
</head>
<body class="bg-gray-900 h-full">

<!-- Sidebar -->
<button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm rounded-lg sm:hidden focus:outline-none focus:ring-gray-200 text-gray-400 hover:bg-gray-700 focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full flex flex-col justify-between px-3 py-4 overflow-y-auto bg-gray-800">
        <!-- Logo and Name at the top -->
        <div class="flex items-center space-x-4 mb-6 bg-gray-700 m-1 py-1 px-1 rounded-md">
            <!-- Replace with your logo -->
            <img src="{{ asset('images/IMG_202411319_103428204.png') }}" alt="Logo" class="w-10 h-10 rounded-full">
            <span class="text-2xl font-semibold text-white">UCC-EVOTE</span>
        </div>

        @if (auth('candidates')->check() && auth('candidates')->user()->role == 'candidate')
            <ul class="space-y-2 font-medium">
                <li>
                    <a href=" {{ App\Models\RouteMap::getUuidForRoute('camp') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2H8a2 2 0 00-2 2v16a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2zM12 8v4m-4-4h8m-2 8h4m-8 0h4"/>
                        </svg>
                        <span class="ms-3">Coalition Room</span>
                    </a>
                </li>
            </ul>
        @endif

        <!-- Admin Info -->
        <div class="mt-auto flex items-center space-x-2 mb-6">
            @if (auth('candidates')->check() && auth('candidates')->user()->role == 'candidate')
                <li>
                    <button id="profile-dropdown" class="flex items-center p-2 w-full rounded-lg text-white hover:bg-gray-700 group">
                        <img src="{{ asset('storage/' . auth('candidates')->user()->image_path) }}" alt="Candidate Picture" class="w-10 h-10 rounded-full border-2 border-gray-300">
                        <span class="ms-3 text-sm font-semibold">{{ auth('candidates')->user()->name }} </span>
                        <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"></path>
                        </svg>
                    </button>
                    <ul id="profile-menu" class="hidden space-y-2 pl-5 mt-2 shadow-lg rounded-lg z-10 w-48 max-h-64 overflow-y-auto">
                        <li>
                            <a href="{{ App\Models\RouteMap::getUuidForRoute('update-candidate-profile') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                                <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="8" r="5" fill="none" stroke="currentColor" stroke-width="2"/>
                                    <path fill="none" stroke="currentColor" stroke-width="2" d="M20 21a8 8 0 00-16 0"/>
                                </svg>
                                Profile
                            </a>
                        </li>
                        <li>
                            <span class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                                <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 2L4 6v6a12 12 0 008 11.32A12 12 0 0020 12V6l-8-4zm0 12a3 3 0 100-6 3 3 0 000 6z"/>
                                </svg>
                                {{ auth('candidates')->user()->role }}
                            </span>
                        </li>
                        {{-- <li>
                            <span class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                                <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                                </svg>
                                {{ auth('candidates')->user()->hall }}
                            </span>
                        </li> --}}
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center p-2 rounded-lg text-white hover:bg-red-500 text-sm">
                                    <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                                        <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M16 17l5-5-5-5"/>
                                        <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M21 12H9"/>
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
        </div>

        <div class="mt-4  mb-4"></div>
        <br>
    </div>
</aside>

<!-- Main Content -->
<main class="p-4 sm:ml-64 h-full">
    <div class="h-full">
        {{ $slot }}
    </div>
</main>

@livewireScripts
</body>
</html>