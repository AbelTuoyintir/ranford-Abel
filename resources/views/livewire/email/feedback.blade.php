<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Voting Status</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class=" rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])
    <style>
        .animate-bounce {
            animation: bounce 1s infinite;
        }
        @keyframes bounce {
            0%, 100% {
                transform: translateY(-5%);
            }
            50% {
                transform: translateY(0);
            }
        }
        .success-prompt, .error-prompt {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        .opacity-0 {
            opacity: 0;
        }
        .translate-x-full {
            transform: translateX(100%);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <!-- Alert Notifications -->
        @if ($errors->any())
            <div class="fixed top-4 right-4 z-50 error-prompt" role="alert">
                <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl transition-transform duration-300 ease-in-out animate-bounce">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                        </svg>
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="fixed top-4 right-4 z-50 success-prompt" role="alert">
                <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl transition-transform duration-300 ease-in-out animate-bounce">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="min-h-screen flex items-center justify-center py-12">
            @if(session('success'))
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
                    <div class="mb-4">
                        <img src="/images/vote.png" alt="Voting Success">
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">You're Ready to Vote!</h2>
                    <p class="text-gray-600 mb-6">Your verification was successful. You can now proceed to the voting station.</p>
                    <div class="text-sm text-gray-500">
                        <p class="mb-2">Please note that this is just verification. Move to a PC to vote.</p>
                        <p class="mb-2">Voting hours: 7:00 AM - 7:00 PM</p>
                        <p class="mt-4 text-blue-600">Your voting station: [Station Name/Location]</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
                    <div class="text-red-500 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Verification Required</h2>
                    <p class="text-gray-600 mb-6">You need to verify your voting eligibility before proceeding.</p>
                    <div class="bg-gray-50 p-4 rounded-md text-sm text-gray-500">
                        <p class="mb-2">Please visit the nearest verification office with:</p>
                        <ul class="list-disc text-left pl-6 mb-4">
                            <li>Valid ID document</li>
                            <li>Proof of residence</li>
                            <li>Any additional supporting documents</li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Auto-dismiss for success prompt
        setTimeout(() => {
            const successMessage = document.querySelector('.success-prompt');
            if (successMessage) {
                successMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
                setTimeout(() => {
                    successMessage.remove();
                }, 800);
            }
        }, 8000);

        // Auto-dismiss for error prompt
        setTimeout(() => {
            const errorMessage = document.querySelector('.error-prompt');
            if (errorMessage) {
                errorMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
                setTimeout(() => {
                    errorMessage.remove();
                }, 500);
            }
        }, 5000);

        // Redirect after 35 seconds if success exists
        if (document.querySelector('.success-prompt')) {
            setTimeout(() => {
                window.location.href = "/";
            }, 35000); // 35 seconds
        }
    </script>
</body>
</html>
