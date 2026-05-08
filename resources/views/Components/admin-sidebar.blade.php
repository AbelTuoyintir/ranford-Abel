<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCC-EVOTE</title>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const assetBaseUrl = "{{ asset('storage/') }}"; // Laravel storage path
    </script>
    @livewireStyles
    
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class=" rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])


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
            const nominationButton = document.getElementById('normination-dropdown');
            const nominationMenu = document.getElementById('normination-menu');

            nominationButton.addEventListener('click', function (event) {
                nominationMenu.classList.toggle('hidden'); // Toggle visibility of the security menu
                event.stopPropagation(); // Prevent event from bubbling up
            });

            // Close the security dropdown menu when clicking outside of it
            body.addEventListener('click', function (event) {
                if (!nominationMenu.contains(event.target) && !nominationButton.contains(event.target)) {
                    nominationMenu.classList.add('hidden'); // Hide the dropdown menu
                }
            });

            const verificationButton = document.getElementById('verification-dropdown');
            const verificationMenu = document.getElementById('verification-menu');

            verificationButton.addEventListener('click', function (event) {
                verificationMenu.classList.toggle('hidden'); // Toggle visibility of the security menu
                event.stopPropagation(); // Prevent event from bubbling up
            });

            // Close the security dropdown menu when clicking outside of it
            body.addEventListener('click', function (event) {
                if (!verificationMenu.contains(event.target) && !verificationButton.contains(event.target)) {
                    verificationMenu.classList.add('hidden'); // Hide the dropdown menu
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
<body class="bg-gray-900 ">

<!-- Sidebar -->
<button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm  rounded-lg sm:hidden  focus:outline-none  focus:ring-gray-200 text-gray-400 hover:bg-gray-700 focus:ring-gray-600">
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
      @if(auth()->user()->role == 'admin')
      <ul class="space-y-2 font-medium">
         <!-- Dashboard Link -->
         <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('dashboard') }}" class="flex items-center p-2  rounded-lg text-white hover:bg-gray-700 group">
               <svg class="w-5 h-5  transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>

         <!-- Profile Link -->
         <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('manageMembers') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700 group">
               <svg class="w-5 h-5 transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.66 0-8 1.34-8 4v2h16v-2c0-2.66-5.34-4-8-4z"/>
               </svg>
               <span class="ms-3">Manage Members</span>
            </a>
         </li>

         <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('strong-room') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700 group">
                <!-- Lock Icon -->
                <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM10 17L6 13L8.5 10.5L10 12L15.5 6.5L18 9L10 17ZM12 14L14 12L12 10L10 12L12 14ZM12 0C13.53 0 15.04 0.26 16.39 0.73L9.36 7.76C8.87 7.44 8.21 7.43 7.72 7.74L3.45 10.98C2.99 11.31 2.99 11.92 3.43 12.26L9.55 17.26L10.68 16.33L7.36 13.26L9.68 12.07L12 14L13.82 12.13L15.95 13.58C16.41 13.92 17.08 13.93 17.57 13.61L21.84 10.37C22.29 10.04 22.29 9.44 21.84 9.09L15.72 4.09L14.64 5.01C13.83 5.84 12.17 5.84 11.36 5.01L10.28 3.99C9.89 3.66 9.32 3.66 8.93 3.99L6.5 6.91L3.36 3.73C2.86 3.43 2.15 3.44 1.72 3.76L1.14 4.04C0.87 4.18 0.85 4.55 1.02 4.87L1.8 6.47L2.64 5.83C2.68 5.79 2.74 5.76 2.81 5.73L2.81 5.73Z" />
                </svg>
                <span class="ms-3">Strong Room</span>
            </a>
        </li>

        <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('portfolios') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                <!-- Portfolio for Elections Icon -->
                <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM10 17L6 13L8.5 10.5L10 12L15.5 6.5L18 9L10 17ZM12 14L14 12L12 10L10 12L12 14ZM12 0C13.53 0 15.04 0.26 16.39 0.73L9.36 7.76C8.87 7.44 8.21 7.43 7.72 7.74L3.45 10.98C2.99 11.31 2.99 11.92 3.43 12.26L9.55 17.26L10.68 16.33L7.36 13.26L9.68 12.07L12 14L13.82 12.13L15.95 13.58C16.41 13.92 17.08 13.93 17.57 13.61L21.84 10.37C22.29 10.04 22.29 9.44 21.84 9.09L15.72 4.09L14.64 5.01C13.83 5.84 12.17 5.84 11.36 5.01L10.28 3.99C9.89 3.66 9.32 3.66 8.93 3.99L6.5 6.91L3.36 3.73C2.86 3.43 2.15 3.44 1.72 3.76L1.14 4.04C0.87 4.18 0.85 4.55 1.02 4.87L1.8 6.47L2.64 5.83C2.68 5.79 2.74 5.76 2.81 5.73L2.81 5.73Z" />
                </svg>
                <span class="ms-3">Create Portfolios</span>
            </a>
        </li>

        <li>
            <button id="normination-dropdown" class="flex items-center p-2 w-full  rounded-lg text-white  hover:bg-gray-700 group">
                <svg class="w-5 h-5  transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3c4.97 0 9 4.03 9 9s-4.03 9-9 9-9-4.03-9-9 4.03-9 9-9zm0-2c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10-4.48-10-10-10z"/>
                </svg>
                <span class="ms-3">Nomination</span>
                <svg class="w-5 h-5  ml-auto text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"></path>
                </svg>
            </button>
            <ul id="normination-menu" class="hidden space-y-2 pl-5">
                <li><a href="{{ route('/generate-voucher') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700">
                    <!-- Log Icon -->
                    <svg class="w-5 h-5 transition duration-75 text-gray-400  group-hover:text-white" viewBox="0 -4 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#9a9898"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>ticket</title> <path d="M39.5 23h0.5v1c-0.299 0-0.628 0-1 0-1.104 0-2 0.896-2 2 0 0.366 0 0.705 0 1h-34c0-0.295 0-0.634 0-1 0-1.104-0.896-2-2-2-0.319 0-0.666 0-1 0v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1c0.299 0 0.628 0 1 0 1.104 0 2-0.896 2-2 0-0.366 0-0.705 0-1h34c0 0.295 0 0.634 0 1 0 1.104 0.896 2 2 2 0.372 0 0.701 0 1 0v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5zM36 11c0-1.104-0.896-2-2-2h-28c-1.104 0-2 0.896-2 2v11c0 1.104 0.896 2 2 2h28c1.104 0 2-0.896 2-2v-11zM34 23h-28c-0.553 0-1-0.448-1-1v-11c0-0.553 0.447-1 1-1h28c0.552 0 1 0.447 1 1v11c0 0.552-0.448 1-1 1zM11.387 13.988h-3.973v0.59h1.652v4.422h0.664v-4.422h1.656v-0.59zM12.768 13.988h-0.664v5.012h0.664v-5.012zM14.759 15.49c0.104-0.312 0.287-0.56 0.546-0.744 0.258-0.185 0.58-0.277 0.965-0.277 0.335 0 0.613 0.083 0.834 0.25 0.222 0.166 0.39 0.432 0.506 0.797l0.652-0.154c-0.134-0.462-0.372-0.821-0.714-1.076s-0.764-0.383-1.265-0.383c-0.442 0-0.847 0.101-1.215 0.303s-0.651 0.497-0.852 0.886c-0.199 0.389-0.299 0.844-0.299 1.365 0 0.479 0.089 0.927 0.266 1.344s0.434 0.736 0.771 0.956c0.339 0.22 0.778 0.33 1.318 0.33 0.521 0 0.963-0.143 1.324-0.429s0.611-0.701 0.75-1.246l-0.664-0.168c-0.091 0.422-0.266 0.74-0.522 0.955-0.258 0.214-0.571 0.321-0.943 0.321-0.305 0-0.589-0.079-0.851-0.236s-0.455-0.395-0.579-0.713-0.187-0.69-0.187-1.117c0.002-0.332 0.054-0.653 0.159-0.964zM23.363 13.988h-0.898l-2.488 2.48v-2.48h-0.664v5.012h0.664v-1.738l0.822-0.795 1.783 2.533h0.875l-2.195-2.98 2.101-2.032zM27.938 18.41h-3.074v-1.707h2.77v-0.59h-2.77v-1.535h2.957v-0.59h-3.621v5.012h3.738v-0.59zM32.625 13.988h-3.973v0.59h1.652v4.422h0.664v-4.422h1.656v-0.59z"></path> </g></svg>
                    <span class="ms-3">generate-voucher</span>
                </a></li>

                <li><a href="{{ route('admin.tickets') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700">
                    <!-- Log Icon -->
                    <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" viewBox="0 -4 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#9a9898">
                        <path d="M39.5 23h0.5v1c-0.299 0-0.628 0-1 0-1.104 0-2 0.896-2 2 0 0.366 0 0.705 0 1h-34c0-0.295 0-0.634 0-1 0-1.104-0.896-2-2-2-0.319 0-0.666 0-1 0v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1h0.5c0.276 0 0.5-0.224 0.5-0.5s-0.224-0.5-0.5-0.5h-0.5v-1c0.299 0 0.628 0 1 0 1.104 0 2-0.896 2-2 0-0.366 0-0.705 0-1h34c0 0.295 0 0.634 0 1 0 1.104 0.896 2 2 2 0.372 0 0.701 0 1 0v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5zM36 11c0-1.104-0.896-2-2-2h-28c-1.104 0-2 0.896-2 2v11c0 1.104 0.896 2 2 2h28c1.104 0 2-0.896 2-2v-11zM34 23h-28c-0.553 0-1-0.448-1-1v-11c0-0.553 0.447-1 1-1h28c0.552 0 1 0.447 1 1v11c0 0.552-0.448 1-1 1zM11.387 13.988h-3.973v0.59h1.652v4.422h0.664v-4.422h1.656v-0.59zM12.768 13.988h-0.664v5.012h0.664v-5.012zM14.759 15.49c0.104-0.312 0.287-0.56 0.546-0.744 0.258-0.185 0.58-0.277 0.965-0.277 0.335 0 0.613 0.083 0.834 0.25 0.222 0.166 0.39 0.432 0.506 0.797l0.652-0.154c-0.134-0.462-0.372-0.821-0.714-1.076s-0.764-0.383-1.265-0.383c-0.442 0-0.847 0.101-1.215 0.303s-0.651 0.497-0.852 0.886c-0.199 0.389-0.299 0.844-0.299 1.365 0 0.479 0.089 0.927 0.266 1.344s0.434 0.736 0.771 0.956c0.339 0.22 0.778 0.33 1.318 0.33 0.521 0 0.963-0.143 1.324-0.429s0.611-0.701 0.75-1.246l-0.664-0.168c-0.091 0.422-0.266 0.74-0.522 0.955-0.258 0.214-0.571 0.321-0.943 0.321-0.305 0-0.589-0.079-0.851-0.236s-0.455-0.395-0.579-0.713-0.187-0.69-0.187-1.117c0.002-0.332 0.054-0.653 0.159-0.964zM23.363 13.988h-0.898l-2.488 2.48v-2.48h-0.664v5.012h0.664v-1.738l0.822-0.795 1.783 2.533h0.875l-2.195-2.98 2.101-2.032zM27.938 18.41h-3.074v-1.707h2.77v-0.59h-2.77v-1.535h2.957v-0.59h-3.621v5.012h3.738v-0.59zM32.625 13.988h-3.973v0.59h1.652v4.422h0.664v-4.422h1.656v-0.59z"></path>
                    </svg>
                    <span class="ms-3">Vouchers</span>
                </a></li>

                <li><a href="/{{ App\Models\RouteMap::getUuidForRoute('nomination-management') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700">
                    <!-- Details Icon -->
                    <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ms-3">Current Nominees</span>
                </a></li>

                
            </ul>

        </li>
            
            
        
        
        
        <li>
         <a href="/{{ App\Models\RouteMap::getUuidForRoute('create-poll') }}" class="flex items-center p-2  rounded-lg text-white hover:bg-gray-700 group">
             <!-- Ballot Box Icon -->
             <svg class="w-5 h-5 transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                 <path d="M3 2C2.44772 2 2 2.44772 2 3V21C2 21.5523 2.44772 22 3 22H21C21.5523 22 22 21.5523 22 21V3C22 2.44772 21.5523 2 21 2H3ZM4 6H20V18H4V6ZM7 8C7.55228 8 8 8.44772 8 9V15C8 15.5523 7.55228 16 7 16C6.44772 16 6 15.5523 6 15V9C6 8.44772 6.44772 8 7 8ZM10 8C10.5523 8 11 8.44772 11 9V15C11 15.5523 10.5523 16 10 16C9.44772 16 9 15.5523 9 15V9C9 8.44772 9.44772 8 10 8ZM13 8C13.5523 8 14 8.44772 14 9V15C14 15.5523 13.5523 16 13 16C12.4477 16 12 15.5523 12 15V9C12 8.44772 12.4477 8 13 8ZM16 8C16.5523 8 17 8.44772 17 9V15C17 15.5523 16.5523 16 16 16C15.4477 16 15 15.5523 15 15V9C15 8.44772 15.4477 8 16 8Z" />
             </svg>
             <span class="ms-3">Create Poll</span>
         </a>
     </li>





         <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('analysis') }}" class="flex items-center p-2  rounded-lg text-white hover:bg-gray-700 group">
               <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 3c4.97 0 9 4.03 9 9s-4.03 9-9 9-9-4.03-9-9 4.03-9 9-9zm0-2c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10-4.48-10-10-10zm0 14c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
               </svg>
               <span class="ms-3">Analysis Page</span>
            </a>
         </li>

         <li>
            <button id="verification-dropdown" class="flex items-center p-2 w-full  rounded-lg text-white  hover:bg-gray-700 group">
                <svg class="w-5 h-5  transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3c4.97 0 9 4.03 9 9s-4.03 9-9 9-9-4.03-9-9 4.03-9 9-9zm0-2c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10-4.48-10-10-10z"/>
                </svg>
                <span class="ms-3">Verification</span>
                <svg class="w-5 h-5  ml-auto text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"></path>
                </svg>
            </button>
            <ul id="verification-menu" class="hidden space-y-2 pl-5">
                <li>
                    <a href="/{{ App\Models\RouteMap::getUuidForRoute('verification') }}" class="flex items-center p-2 rounded-lg text-white  hover:bg-gray-700 group">
                        <svg class="w-5 h-5 transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 1c-1.1 0-1.99.9-1.99 2L7 5h10l.01-2c0-1.1-.89-2-1.99-2H9zM5 8v10c0 1.1.89 2 1.99 2H17c1.1 0 1.99-.9 1.99-2V8H5z"/>
                        </svg>
                        <span class="ms-3">Local Verification </span>
                    </a>
                </li>

                <li>
                    <a href="/{{ App\Models\RouteMap::getUuidForRoute('automatic-verification') }}" class="flex items-center p-2 rounded-lg text-white  hover:bg-gray-700 group">
                        <svg class="w-5 h-5 transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 1c-1.1 0-1.99.9-1.99 2L7 5h10l.01-2c0-1.1-.89-2-1.99-2H9zM5 8v10c0 1.1.89 2 1.99 2H17c1.1 0 1.99-.9 1.99-2V8H5z"/>
                        </svg>
                        <span class="ms-3">Automatic Verification</span>
                    </a>
                </li>

                <li>
                    <a href="/{{ App\Models\RouteMap::getUuidForRoute('update-email') }}" class="flex items-center p-2 rounded-lg text-white  hover:bg-gray-700 group">
                        <svg class="w-5 h-5 transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 1c-1.1 0-1.99.9-1.99 2L7 5h10l.01-2c0-1.1-.89-2-1.99-2H9zM5 8v10c0 1.1.89 2 1.99 2H17c1.1 0 1.99-.9 1.99-2V8H5z"/>
                        </svg>
                        <span class="ms-3">Email Update</span>
                    </a>
                </li>

                
            </ul>

        </li>

         

        

        <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('ipblocker') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5L12 1zm0 2.18l7 3.5v4.32c0 4.54-3.25 8.79-7 9.94-3.75-1.15-7-5.4-7-9.94V6.68l7-3.5z"/>
                    <path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0 8c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
                    <path d="M16.5 10L19 12.5 16.5 15 14 12.5z"/>
                    <path d="M7.5 10L5 12.5 7.5 15 10 12.5z"/>
                    <path d="M12 12.5L14.5 15 17 12.5 14.5 10z"/>
                    <path d="M12 12.5L9.5 15 7 12.5 9.5 10z"/>
                </svg>
                <span class="ms-3">IP Blocker</span>
            </a>
        </li>

        <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('database') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                <!-- Database Icon -->
                <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3C6.48 3 2 5.99 2 9C2 12.01 6.48 15 12 15C17.52 15 22 12.01 22 9C22 5.99 17.52 3 12 3ZM12 13C7.58 13 4 10.58 4 9C4 7.42 7.58 5 12 5C16.42 5 20 7.42 20 9C20 10.58 16.42 13 12 13ZM12 17C8.69 17 6 18.66 6 20V21H18V20C18 18.66 15.31 17 12 17Z"/>
                </svg>
                <span class="ms-3">Database</span>
            </a>
        </li>
        
        <li><a href="/{{ App\Models\RouteMap::getUuidForRoute('election-coalition') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700">
            <!-- Election Coalition Icon -->
            <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="ms-3">Election Coalition</span>
        </a></li>

         <!-- Dropdown Menu -->
         <li>
            <button id="products-dropdown" class="flex items-center p-2 w-full  rounded-lg text-white  hover:bg-gray-700 group">
                <svg class="w-5 h-5  transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3c4.97 0 9 4.03 9 9s-4.03 9-9 9-9-4.03-9-9 4.03-9 9-9zm0-2c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10-4.48-10-10-10z"/>
                </svg>
                <span class="ms-3">Security</span>
                <svg class="w-5 h-5  ml-auto text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"></path>
                </svg>
            </button>
            <ul id="products-menu" class="hidden space-y-2 pl-5">
                <li><a href="/{{ App\Models\RouteMap::getUuidForRoute('log') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700">
                    <!-- Log Icon -->
                    <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="ms-3">LOG</span>
                </a></li>

                <li><a href="/{{ App\Models\RouteMap::getUuidForRoute('/details') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700">
                    <!-- Details Icon -->
                    <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ms-3">DETAILS</span>
                </a></li>

                
            </ul>

        </li>
        
        <!-- Settings menu -->
       <!-- Settings menu -->
<li>
    <!-- Dropdown Button -->
    <button id="settings-dropdown" class="flex items-center p-2 w-full rounded-lg text-white hover:bg-gray-700 group">
        <!-- Settings Icon -->
        <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="ms-3">Settings</span>
        <!-- Dropdown Arrow Icon -->
        <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <ul id="settings-menu" class="hidden space-y-2 pl-5">
        <!-- Overview Section -->
        <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('/overview') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700">
                <!-- Overview Icon -->
                <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span class="ms-3">Overview</span>
            </a>
        </li>

        <!-- Advanced Settings Section -->
        <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('/advance-settings') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700">
                <!-- Advanced Settings Icon -->
                <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                <span class="ms-3">Advanced Settings</span>
            </a>
        </li>

    </ul>
</li>

<!-- JavaScript for Dropdown Toggle -->
<script>
    document.getElementById('settings-dropdown').addEventListener('click', function () {
        const settingsMenu = document.getElementById('settings-menu');
        settingsMenu.classList.toggle('hidden');
    });
</script>

      </ul>

    
    
      @elseif (auth()->user()->role == 'verification_officer')
      <ul class="space-y-2 font-medium">
        <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('verification') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700 group">
                <svg class="w-5 h-5  transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 1c-1.1 0-1.99.9-1.99 2L7 5h10l.01-2c0-1.1-.89-2-1.99-2H9zM5 8v10c0 1.1.89 2 1.99 2H17c1.1 0 1.99-.9 1.99-2V8H5z"/>
                </svg>
                <span class="ms-3">Verification Page</span>
            </a>
        </li>
        
      </ul>
      
      @elseif (auth()->user()->role == 'moderator')
      <ul class="space-y-2 font-medium">
        <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('verification') }}" class="flex items-center p-2  rounded-lg text-white  hover:bg-gray-700 group">
                <svg class="w-5 h-5  transition duration-75 text-gray-400  group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 1c-1.1 0-1.99.9-1.99 2L7 5h10l.01-2c0-1.1-.89-2-1.99-2H9zM5 8v10c0 1.1.89 2 1.99 2H17c1.1 0 1.99-.9 1.99-2V8H5z"/>
                </svg>
                <span class="ms-3">Verification Page</span>
            </a>
        </li>
        <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('/advance-settings') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700">
                <!-- Advanced Settings Icon -->
                <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                <span class="ms-3">Advanced Settings</span>
            </a>
        </li>
        <li>
            <a href="/{{ App\Models\RouteMap::getUuidForRoute('strong-room') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 2H8a2 2 0 00-2 2v16a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2zM12 8v4m-4-4h8m-2 8h4m-8 0h4"/>
                </svg>
                <span class="ms-3">Strong Room</span>
            </a>
        </li>
        
      </ul>

      {{-- @elseif (auth()->candidate()->role == 'candidate')
      <ul class="space-y-2 font-medium">
        
        <li>
            <a href="{{route('/camp')}}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 2H8a2 2 0 00-2 2v16a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2zM12 8v4m-4-4h8m-2 8h4m-8 0h4"/>
                </svg>
                <span class="ms-3">Strong Room</span>
            </a>
        </li> --}}
        
      </ul>


      @endif
      {{-- @if(auth()->user()->role == 'voter')
      @php
          $user = auth()->user();
          // Fetch the poll that happened on the current day
          $currentPoll = App\Models\election_coalition::where('status', 'complete') // Poll is complete
              ->whereDate('start_date', now()->toDateString()) // Poll started (and ended) today
              ->orderBy('created_at', 'desc') // Order by the most recent
              ->first();
  
          // Debugging: Uncomment to see the fetched poll
          //dd($currentPoll);
  
          $showResults = false;
  
          if ($currentPoll) {
              // Fetch the querystring from PollSettings
            //   dd($currentPoll->querystring ,$user->hall);
  
              // Check poll type and user-specific conditions
              if ($currentPoll->poll_type === 'UCC GENERAL VOTING') {
                  $showResults = true;
              } elseif ($currentPoll->poll_type === 'HALL'&& $currentPoll->querystring === $user->hall) {
                  $showResults = true;
              } elseif ($currentPoll->poll_type === 'DEPARTMENT' && $querystring == $user->Programs) {
                  $showResults = true;
              }
              elseif ($currentPoll->poll_type === 'SPECIAL VOTING' && $querystring == $user->Programs) {
                  $showResults = true;
              }
          }
      @endphp
  
      @if($showResults)
          <li>
              <a href="/{{ App\Models\RouteMap::getUuidForRoute('public-view') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700">
                  <!-- Details Icon -->
                  <svg class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span class="ms-3">Results</span>
              </a>
          </li>
          
      @endif 
  @endif
  --}}



      <!-- Admin Info (Move it below the nav links) -->
      <div class="mt-auto flex items-center space-x-2 mb-6 ">
        <!-- Admin Picture -->
        <!-- Profile Link (Dropdown) -->
        <li>
            <button id="profile-dropdown" class="flex items-center p-2 w-full rounded-lg text-white hover:bg-gray-700 group">
                <img src="{{ asset(auth()->user()->image) }}" alt="Admin Picture" class="w-10 h-10 rounded-full border-2 border-gray-300">
                <span class="ms-3 text-sm font-semibold">{{auth()->user()->firstName }} {{auth()->user()->lastName }}</span>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"></path>
                </svg>
            </button>
            <ul id="profile-menu" class="hidden max-h-60 overflow-y-auto space-y-2 pl-5 mt-2 shadow-lg rounded-lg z-10 w-48 bg-gray-800">
                <!-- Role Section -->
                <li>
                    @if (auth()->user()->role == 'admin')
    
                    <li>
                        <a href="/{{ App\Models\RouteMap::getUuidForRoute('/update/profile') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                            <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="8" r="5" fill="none" stroke="currentColor" stroke-width="2"/>
                                <path fill="none" stroke="currentColor" stroke-width="2" d="M20 21a8 8 0 00-16 0"/>
                            </svg>
                            Profile
                        </a>
                    </li>
                    
                    <span class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                        <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 2L4 6v6a12 12 0 008 11.32A12 12 0 0020 12V6l-8-4zm0 12a3 3 0 100-6 3 3 0 000 6z"/>
                        </svg>
                        {{auth()->user()->role }}
                    </span>
    
                    @elseif (auth()->user()->role == 'verification_officer')
                    <a href="/{{ App\Models\RouteMap::getUuidForRoute('update-profile') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                        <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="8" r="5" fill="none" stroke="currentColor" stroke-width="2"/>
                            <path fill="none" stroke="currentColor" stroke-width="2" d="M20 21a8 8 0 00-16 0"/>
                        </svg>
                        Profile
                    </a>
    
                    <a href="/{{ App\Models\RouteMap::getUuidForRoute('verification') }}">
                        <span class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                            <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 2L4 6v6a12 12 0 008 11.32A12 12 0 0020 12V6l-8-4zm0 12a3 3 0 100-6 3 3 0 000 6z"/>
                            </svg>
                            {{auth()->user()->role }}
                        </span>
                    </a>
    
                    @elseif (auth()->user()->role == 'moderator')
                    <a href="/{{ App\Models\RouteMap::getUuidForRoute('update-profile') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                        <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="8" r="5" fill="none" stroke="currentColor" stroke-width="2"/>
                            <path fill="none" stroke="currentColor" stroke-width="2" d="M20 21a8 8 0 00-16 0"/>
                        </svg>
                        Profile
                    </a>
                    <a href="/{{ App\Models\RouteMap::getUuidForRoute('verification') }}">
                        <span class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                            <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 2L4 6v6a12 12 0 008 11.32A12 12 0 0020 12V6l-8-4zm0 12a3 3 0 100-6 3 3 0 000 6z"/>
                            </svg>
                            {{auth()->user()->role }}
                        </span>
                    </a>
    
                    @endif
                </li>
    
                <!-- Hall Section -->

                <li>
                    <span class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                        <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                        </svg>
                        {{auth()->user()->hall }}
                    </span>
                </li>
    
                <!-- Profile Link Section -->
                @if (auth()->user()->role == 'voter')
                <li>
                    <a class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                        <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="8" r="5" fill="none" stroke="currentColor" stroke-width="2"/>
                            <path fill="none" stroke="currentColor" stroke-width="2" d="M20 21a8 8 0 00-16 0"/>
                        </svg>
                        {{auth()->user()->school_id}}
                    </a>
                </li>
                
                <li>
                    <a href="/{{ App\Models\RouteMap::getUuidForRoute('/update/profile') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 text-sm">
                        <svg class="w-5 h-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="8" r="5" fill="none" stroke="currentColor" stroke-width="2"/>
                            <path fill="none" stroke="currentColor" stroke-width="2" d="M20 21a8 8 0 00-16 0"/>
                        </svg>
                        Profile
                    </a>
                </li>
                @endif
    
                <!-- Logout Section -->
                <li>
                    <form action="{{route('logout')}}" method="POST">
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
    </div>

    <div class="mt-4  mb-4"></div>
    <br>


   </div>
</aside>

<!-- Main Content -->
@auth
    <main class="p-4 sm:ml-64">
        <div class="">
            {{ $slot }}
            <!-- Add more sections as needed -->
        </div>
    </main>
@else
    <script>
        window.location.href = "{{ route('/voter-login') }}";
    </script>
@endauth
@livewireScripts
</body>
</html>



