<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Forbidden</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class=" rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <div class="text-center">
                <!-- Error Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v4m0 0l-3-3m3 3l3-3" />
                </svg>
                
                <h1 class="text-3xl font-bold text-red-600 mt-4">Access Denied</h1>
                {{-- <p class="text-gray-600 mt-2">
                    You are not authorized to access this page.
                </p> --}}
                
                <!-- Image Section -->
                <div class="mt-6">
                    <img src="{{ asset('images/error.jpg') }}" alt="Access Denied" class="w-full h-64 object-cover rounded-lg">
                </div>
                
                <div class="mt-6">
                    <p class="text-gray-500">
                        If you believe this is an error, please contact your network administrator or try connecting to a different network.
                    </p>
                </div>
                
                <div class="mt-6">
                    <button class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                        Go Back
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>