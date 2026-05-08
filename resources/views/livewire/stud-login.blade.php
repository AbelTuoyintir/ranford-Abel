<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ucc voters-Login</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class=" rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])
</head>
<body>
    <div class="h-screen w-full flex items-center justify-center bg-gray-50">
        <img src="{{ asset('images/vecteezy_united-states-election-vote-box.png') }}" alt="" class="absolute h-full opacity-5" />
        <div class="w-[70%] md:w-[30%] relative">
            <div class="bg-[#22296F] text-white p-4 rounded-md mb-3 flex items-start gap-3">
                <img src="{{ asset('images/IMG_202411319_103428204.png') }}" alt="" class="h-10 w-10 rounded-lg" />
                <div>
                    <h1 class="text-lg">UNIVERSITY OF CAPE COAST</h1>
                    <h1 class="text-sm font-semibold text-gray-300">VOTING SYSTEM</h1>
                </div>
            </div>

            <!-- Flash Error Message -->
            @if(session('success') || session('error'))
            <div class="fixed top-4 right-4 z-50">
                @if(session('success'))
                    <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl transition-all duration-300 ease-in-out animate-bounce mb-2">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
        
                @if(session('error'))
                    <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl transition-all duration-300 ease-in-out animate-bounce">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        
            <script>
                // Auto-dismiss messages after 5 seconds
                setTimeout(() => {
                    document.querySelectorAll('.bg-green-500, .bg-red-500').forEach((message) => {
                        message.classList.add('animate-fadeOut');
                        setTimeout(() => message.remove(), 500);
                    });
                }, 5000);
            </script>
        @endif

            <form id="loginForm" action="{{ route('loginVoter') }}" class="p-6 bg-white rounded-md shadow-xl" method="POST">
                @csrf
                <h1 class="text-lg mb-5 text-[#22296F] text-center font-bold">Voter Panel</h1>
                <input
                    type="text"
                    name="school_id"
                    class="border border-gray-400 p-3 outline-none rounded-md w-full mb-4"
                    placeholder="Your Registration Number"
                    value="{{ old('school_id') }}"
                />
                @error('school_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <div class="relative">
                    <input
                        name="password"
                        type="text"
                        id="passwordInput"
                        placeholder="Password (1998-08-18)*"
                        class="border border-gray-400 p-3 outline-none rounded-md w-full mb-10 pr-12"
                    />
                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 p-1 bg-white rounded-full focus:outline-none flex items-center justify-center">
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.956 9.956 0 012.293-3.95M6.634 6.634A9.956 9.956 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.956 9.956 0 01-4.293 5.95M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
               
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
                <button type="submit" id="loginButton" class="w-full p-3 bg-[#22296F] rounded-md text-white hover:bg-[#1A1F56] flex items-center justify-center">
                    <span id="loginText">Login</span>
                    <span id="loginSpinner" class="hidden ml-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </form>
            {{-- <button class="text-base font-semibold bg-gray-200 rounded-md p-3 mt-5 w-full">
                <a href="/candidate-login">
                Are you an Candidate ? Use Candidate Panel
                </a>
            </button> --}}
        </div>
    </div>

    <script>
      
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            if (input.type === 'text') {
                input.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
        // Set default to visible (text)
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('passwordInput').type = 'text';
            document.getElementById('eyeOpen').classList.remove('hidden');
            document.getElementById('eyeClosed').classList.add('hidden');
        });
               
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            const loginButton = document.getElementById('loginButton');
            const loginText = document.getElementById('loginText');
            const loginSpinner = document.getElementById('loginSpinner');

            // Disable the button and show the spinner
            loginButton.disabled = true;
            loginText.textContent = 'Logging in...';
            loginSpinner.classList.remove('hidden');
        });
    </script>
</body>
</html>