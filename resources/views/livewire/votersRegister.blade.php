<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UCC-EVOTE</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
  <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class="rounded-full w-16 h-16">
  @vite(["resources/css/app.css","resources/js/app.js"])
  <style>
    
    :root {
            --ucc-navy: #00205B;
            --ucc-gold: #FFD700;
        }
    body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .ucc-navy {
            background-color: var(--ucc-navy);
        }
        
        .ucc-gold {
            background-color: var(--ucc-gold);
        }
        
        .text-ucc-navy {
            color: var(--ucc-navy);
        }
        
        .text-ucc-gold {
            color: var(--ucc-gold);
        }
        
        .border-ucc-navy {
            border-color: var(--ucc-navy);
        }
        
        .border-ucc-gold {
            border-color: var(--ucc-gold);
        }
        
        .btn-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 32, 91, 0.3);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 32, 91, 0.2);
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
    
    .skeleton-loader {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: .5; }
    }
    /* Responsive Table */
    @media (max-width: 640px) {
      .sticky-header th {
      position: sticky;
      top: 0;
      background-color: #f9fafb; /* Match the background color of the header */
      z-index:99999;
    }
      .responsive-table th, .responsive-table td {
        font-size: 14px;
        padding: 8px;
      }
     
    }
    /* Fixed height for table container */
    .table-container {
      height: 500px; /* Adjust this value as needed */
      overflow-y: auto;
    }
    /* Sticky table header */
    .sticky-header th {
      position: sticky;
      top: 0;
      background-color: #f9fafb; /* Match the background color of the header */
      z-index:99999;
    }
    
  </style>
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="container mx-auto px-4 py-8">
    <!-- Accessibility Announcement -->
    <div aria-live="polite" class="sr-only">
      <span x-text="Showing ${filteredVoters.length} results"></span>
    </div>

    <div>
      <!-- Header Section -->
      <header class="ucc-navy text-white shadow-lg mb-2">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <!-- UCC Logo (simplified version) -->
                <img src="{{ asset('images/IMG_202411319_103428204.png') }}" alt="" class="h-10 w-10 rounded-lg m-1" />

                <div>
                    <h1 class="text-xl font-bold">University of Cape Coast</h1>
                    <p class="text-sm text-ucc-gold">Electronic Voting Register</p>
                </div>
            </div>
            
           
        </div>
    </header>
    </div>

    <!-- Search Section -->
    <div class="mb-4">
      <label for="searchInput" class="sr-only">Search</label>
      <div class="relative mx-auto w-full sm:w-3/4 md:w-1/2 lg:w-1.5/3">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input 
          id="searchInput" 
          type="text" 
          class="block w-full pl-10 pr-4 py-2 rounded-lg bg-[#E3E6EC] border border-gray-600 text-black placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
          placeholder="Search for candidates..." 
          oninput="searchCandidates()" 
        />
      </div>
    </div>

    <!-- Loading State -->
    <template x-if="isLoading">
      <div class="space-y-3">
        <div class="skeleton-loader h-10 bg-gray-200 rounded"></div>
        <div class="skeleton-loader h-10 bg-gray-200 rounded"></div>
        <div class="skeleton-loader h-10 bg-gray-200 rounded"></div>
      </div>
    </template>

    <!-- Legend -->
    <div class="flex flex-wrap justify-center gap-6 mb-8">
      <div class="flex items-center">
        <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
        <span class="text-gray-700">Missing Email [{{$emptyEmailUsers}}]</span>
      </div>
      <div class="flex items-center">
        <span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
        <span class="text-gray-700">Institutional Email [{{$intUsers}}]</span>
      </div>
      <div class="flex items-center">
        <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span>
        <span class="text-gray-700">Personal Email [{{$norUsers}}]</span>
      </div>
      <div class="flex items-center">
        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
        <span class="text-gray-700">Invalid Email </span>
      </div>
    </div>

    <!-- Voter Table -->
    <div class="table-container">
      <div class="responsive-table" x-show="!isLoading">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
          <caption class="sr-only">Voter registration list with email status indicators</caption>
          <thead class="sticky-header bg-gray-50">
            <tr>
              
              <th class="py-3 px-4 text-left font-semibold text-gray-700">Name</th>
              <th class="py-3 px-4 text-left font-semibold text-gray-700">Email</th>
              <th class="py-3 px-4 text-left font-semibold text-gray-700">Status</th>
            </tr>
          </thead>
          <tbody id="candidates-table">
            <!-- voter's data will be inserted here dynamically -->
            @foreach ($users as $user)
              @php
                if (!$user->email) {
                  $rowClass = "bg-red-50 border-l-4 border-red-500"; // Missing email
                  $statusText = "Missing Email";
                } elseif (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $user->email)) {
                  $rowClass = "bg-yellow-100 border-l-4 border-yellow-500"; // Invalid email
                  $statusText = "Invalid Email";
                } elseif (strpos($user->email, 'stu.ucc.edu.gh') !== false) {
                  $rowClass = "bg-blue-100 border-l-4 border-blue-500"; // Institutional email
                  $statusText = "Institutional Email";
                } else {
                  $rowClass = "bg-green-100 border-l-4 border-green-500"; // Personal email
                  $statusText = "Personal Email";
                }
              @endphp

              <tr class="border-b hover:bg-[#E1E7FB] {{ $rowClass }}">
                <td class="px-6 py-4">{{ $user->firstName.' '.$user->middleName.' '.$user->lastName }}</td>
                <td class="px-6 py-4">{{ !empty($user->email) ? $user->email : 'No Email' }}</td>
                <td class="px-6 py-4">{{ $statusText }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Help Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mt-2">
      <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
        <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Need Help?
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
          <div class="flex items-center mb-2">
            <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            <h3 class="font-medium text-gray-800">Contact Support</h3>
          </div>
          <p class="text-gray-600 text-sm">
            If you can't find your name or need to update your email,
            please contact our support team.
          </p>
          <a href="#" class="mt-3 text-blue-600 hover:text-blue-800 inline-flex items-center text-sm">
            Contact us
            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </a>
        </div>
        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
          <div class="flex items-center mb-2">
            <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="font-medium text-gray-800">Registration Guidelines</h3>
          </div>
          <p class="text-gray-600 text-sm">
            Learn about our registration process and
            requirements for voting.
          </p>
          <a href="#" class="mt-3 text-blue-600 hover:text-blue-800 inline-flex items-center text-sm">
            Read guidelines
            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>

  <footer class="bg-gray-900 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                  </svg>
                <h3 class="text-lg font-bold mb-4">UCC E-Vote</h3>
                <p class="text-gray-400">Your secure platform for campus elections.</p>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{route('/')}}" class="text-gray-400 hover:text-ucc-gold transition duration-300">Home</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">About</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">Elections</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">Help Center</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="text-gray-400">University of Cape Coast</li>
                    <li class="text-gray-400">Cape Coast, Ghana</li>
                    <li class="text-gray-400">Email: evoting@ucc.edu.gh</li>
                    <li class="text-gray-400">Phone: +233 XX XXX XXXX</li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Stay Connected</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124-4.09-.193-7.715-2.157-10.141-5.126-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 14-7.503 14-14v-.617c.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-700">
        <p class="text-center text-gray-500">&copy; 2025 University of Cape Coast E-Voting System. All rights reserved.</p>
    </div>
</footer>
  <script>
    function searchCandidates() {
      const searchValue = document.getElementById('searchInput').value.toLowerCase();
      const rows = document.querySelectorAll('#candidates-table tr');

      rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        if (rowText.includes(searchValue)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    function getEmailStatus(email) {
      if (!email) return 'missing';
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) return 'invalid';
      if (email.includes('stu.ucc.edu.gh')) return 'institutional';
      return 'personal';
    }
  </script>
</body>
</html>