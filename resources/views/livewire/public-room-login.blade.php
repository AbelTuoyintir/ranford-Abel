<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login for Public View</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class="rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])

    <style>
        body {
           
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Inter', sans-serif;
            animation: fadeIn 1s ease-in-out;
            background: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0)), url('images/logo60.jpg'); /* Semi-transparent white overlay */
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: slideIn 0.8s ease-in-out;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .login-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .input-field {
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-field:focus {
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-primary {
            background-color: #4F46E5;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #4338CA;
            transform: translateY(-2px);
        }

        .animate-bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .animate-fadeOut {
            animation: fadeOut 0.5s ease-in-out forwards;
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <div class="login-box p-8 w-96">
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

        <!-- Logo or Branding -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/vote.png') }}" alt="Logo" class="w-20 h-20 mx-auto mb-4 floating">
            <h1 class="text-3xl font-bold text-gray-800">Welcome Back</h1>
            <p class="text-gray-500">Sign in to your Public View</p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('/public-login') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">School ID</label>
                <input
                    type="text"
                    id="username"
                    name="school_id"
                    class="input-field mt-1 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter your School ID"
                >
            </div>
            @error('school_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="input-field mt-1 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter your password"
                >
            </div>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Submit Button -->
            <div>
                <button type="submit" id="loginButton" class="w-full p-3 bg-[#22296F] rounded-md text-white hover:bg-[#1A1F56] flex items-center justify-center">
                    <span id="loginText">Login</span>
                    <span id="loginSpinner" class="hidden ml-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>

        <!-- Sign Up Link -->
        <div class="mt-6 text-center">
            <a href="/" class="text-indigo-600 hover:text-indigo-500">
                <p class="text-sm text-gray-600">Take me back 
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="inline w-6 h-6">
                        <path d="M15.3 9.3L13.6 11H4v2h9.6l-1.7 1.7L12 17l-5-5 5-5 1.3 1.3z"/>
                    </svg>
                </p>
            </a>
        </div>
    </div>

    <script>
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