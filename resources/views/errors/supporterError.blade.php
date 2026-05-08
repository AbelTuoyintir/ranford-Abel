<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class="rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <div class="text-center">
                <!-- SVG Icon Section -->
                @if(session('success') && str_contains(session('success'), 'Thank you'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @elseif(session('success') && str_contains(session('success'), 'declined'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v4m0 0l-3-3m3 3l3-3" />
                    </svg>
                @endif

                <h1 class="text-3xl font-bold mt-4
                    @if(session('success') && str_contains(session('success'), 'Thank you')) text-green-600
                    @elseif(session('success') && str_contains(session('success'), 'declined')) text-yellow-600
                    @else text-red-600 @endif">
                    @if(session('success') && str_contains(session('success'), 'Thank you'))
                        Success
                    @elseif(session('success') && str_contains(session('success'), 'declined'))
                        Declined
                    @else
                        Notification
                    @endif
                </h1>

                <div class="mt-6">
                    <p class="text-gray-500">
                        {{ session('success') ?? 'If you believe this is an error, please contact your network administrator.' }}
                    </p>
                </div>

                <div class="mt-6">
                    <a href="{{ url()->previous() }}">
                        <button class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                            Go Back
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
