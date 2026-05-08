<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Your UCC Voting Status</title>
  
  <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class=" rounded-full w-16 h-16">
  @vite(["resources/css/app.css","resources/js/app.js"])
</head>
<style>
  body {
      /* background-image: url('images/ucc.png'); Replace with your background image */
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Inter', sans-serif;
      background-blend-mode: overlay; /* Adds a blend mode for the background */
      background: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0)), url('images/logo60.jpg'); /* Semi-transparent white overlay */
  }
</style>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded-xl shadow-lg max-w-md w-full text-center">
    <!-- Icon -->
    <div class="mx-auto mb-6">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
    </div>

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Verify Your Voting Status</h1>
    <p class="text-gray-600 mb-6">Ensure your UCC voting status is up-to-date and verified.</p>

    <!-- Google-style button -->
    <form action="{{route('google.login')}}" method="get">
      @csrf
    <button
    type="submit"
      class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-600 rounded-lg shadow-md text-white font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
    >
            <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
        <path fill="#4285F4" d="M45.12 24.5c0-1.56-.14-3.06-.4-4.5H24v8.51h11.84c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.56-9.47 6.56-16.17z"/>
        <path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.31-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"/>
        <path fill="#FBBC05" d="M11.69 28.18C11.25 26.86 11 25.45 11 24s.25-2.86.69-4.18v-5.7H4.34C2.85 17.09 2 20.45 2 24s.85 6.91 2.34 9.88l7.35-5.7z"/>
        <path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.92 4.18 29.94 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.35 5.7c1.73-5.2 6.58-9.07 12.31-9.07z"/>
        <path fill="none" d="M0 0h48v48H0z"/>
      </svg>
      Verify with Google
    </button>
  </form>
    <!-- Footer -->
    <div class="mt-6 text-center">
      <p class="text-sm text-gray-500">By verifying, you agree to our <a href="#" class="text-blue-600 hover:underline">Terms of Service</a>.</p>
    </div>
  </div>
</body>
</html>