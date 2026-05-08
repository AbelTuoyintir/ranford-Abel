<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ucc candidate-Login</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class=" rounded-full w-16 h-16">
     <script src="https://cdn.tailwindcss.com"></script>
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
            <form id="loginForm" action="{{route('loginCandidate')}}" class="p-6 bg-white rounded-md shadow-xl" method="POST">
                @csrf
                <h1 class="text-lg mb-5 text-[#22296F] text-center font-bold">Candidate Panel</h1>
                <input
                    type="text"
                    name="school_id"
                    class="border border-gray-400 p-3 outline-none rounded-md w-full mb-4"
                    placeholder="Your id*"
                    value="{{ old('school_id') }}"
                />
                @error('school_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <input
                    name="password"
                    type="password"
                    placeholder="Password"
                    class="border border-gray-400 p-3 outline-none rounded-md w-full mb-10"
                />
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
                <button id="loginButton" type="submit" class="w-full p-3 bg-[#22296F] rounded-md text-white hover:bg-[#1A1F56] flex items-center justify-center">
                    <span id="loginText">Login</span>
                    <span id="loginSpinner" class="hidden ml-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </form>
            {{-- <button  class="text-base font-semibold bg-gray-200 rounded-md p-3 mt-5 w-full">
                <a href="/">
                Are you an Admin ? Use Admin Panel
                </a>
            </button > --}}
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const loginButton = document.getElementById('loginButton');
            const loginText = document.getElementById('loginText');
            const loginSpinner = document.getElementById('loginSpinner');

            // Disable the button to prevent multiple submissions
            loginButton.disabled = true;
            // Hide the login text and show the spinner
            loginText.classList.add('hidden');
            loginSpinner.classList.remove('hidden');
        });
    </script>
</body>
</html>