@auth
<x-admin-sidebar>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }

        .ucc-primary { background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%); }
        .ucc-secondary { background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%); }
        .ucc-accent { background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%); }
        .ucc-gold { background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%); }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .toggle-checkbox:checked {
            right: 0;
            border-color: #3b82f6;
        }
        
        .toggle-checkbox {
            transition: all 0.3s ease;
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
        }
        
        .notification-enter {
            animation: slideInRight 0.5s ease-out;
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .pattern-bg {
            background-image: 
                radial-gradient(circle at 25% 25%, #3b82f6 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, #1e40af 0%, transparent 50%);
            background-size: 100px 100px;
            background-position: 0 0, 50px 50px;
        }
    </style>

<body class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen pattern-bg">
    <!-- Flash Messages -->
    <div id="flash-messages" class="fixed top-4 right-4 z-50 space-y-2"></div>
     <!-- Flash Error Message -->
          @if(session('success') || session('error'))
          <div class="fixed top-4 right-4 z-50 space-y-2">
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
    <!-- Header -->
    <header class="ucc-primary text-white shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-6 py-8 relative z-10">
            <div class="flex flex-col lg:flex-row justify-between items-center">
                <div class="text-center lg:text-left mb-6 lg:mb-0">
                    <div class="flex items-center justify-center lg:justify-start mb-4">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mr-4 floating-animation">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold">University of Cape Coast</h1>
                            <p class="text-blue-100 text-lg">Voting System - Advanced Settings</p>
                        </div>
                    </div>
                    <p class="text-xl text-blue-50">Manage app restrictions, notifications, and election controls</p>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="glass-effect text-blue-600 px-6 py-3 rounded-xl hover:shadow-xl transition-all duration-300 hover-scale">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Help & Support
                    </button>
                    <button class="glass-effect text-blue-600 px-6 py-3 rounded-xl hover:shadow-xl transition-all duration-300 hover-scale">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Documentation
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <!-- Network Access Controls -->
        <section class="glass-effect rounded-2xl shadow-2xl mb-8 overflow-hidden hover-scale fade-in">
            <div class="ucc-primary text-white p-6">
                <h2 class="text-3xl font-bold flex items-center">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    Network Access Controls
                </h2>
                <p class="text-blue-100 mt-2">Configure who can access the voting system</p>
            </div>
            
            <div class="p-8 space-y-8">
                <!-- Campus Network Restriction -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                Campus Network Only
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                Restrict access to users connected to the University of Cape Coast network infrastructure. 
                                Only students and staff on campus Wi-Fi or VPN can participate in elections.
                            </p>
                        </div>
                        
                        <div class="ml-6">
                            <label class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="campus-network" class="sr-only toggle-input" {{ $settings['network_restriction'] ?? false ? 'checked' : '' }}>
                                    <div class="block bg-gray-300 w-14 h-8 rounded-full toggle-bg transition-all duration-300"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-all duration-300 toggle-dot"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Open Access Mode -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border border-green-100">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                Open Access Mode
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                Allow unrestricted access from any network location. Students and staff can participate 
                                in elections from anywhere with an internet connection.
                            </p>
                        </div>
                        
                        <div class="ml-6">
                            <label class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="open-access" class="sr-only toggle-input" {{ !($settings['network_restriction'] ?? false) ? 'checked' : '' }}>
                                    <div class="block bg-gray-300 w-14 h-8 rounded-full toggle-bg transition-all duration-300"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-all duration-300 toggle-dot"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Notification Settings -->
        <section class="glass-effect rounded-2xl shadow-2xl mb-8 overflow-hidden hover-scale fade-in">
            <div class="ucc-primary text-white p-6">
                <h2 class="text-3xl font-bold flex items-center">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Notification Preferences
                </h2>
                <p class="text-orange-100 mt-2">Configure how students receive election updates</p>
            </div>
            
            <div class="p-8 space-y-8">
                <!-- SMS Notifications -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-100">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                                <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                SMS Notifications
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                Send election updates, reminders, and results via SMS to registered student phone numbers. 
                                Ideal for urgent announcements and high-priority communications.
                            </p>
                        </div>
                        
                        <div class="ml-6">
                            <label class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="sms-notifications" class="sr-only toggle-input" {{ $settings['notification_sms'] ?? false ? 'checked' : '' }}>
                                    <div class="block bg-gray-300 w-14 h-8 rounded-full toggle-bg transition-all duration-300"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-all duration-300 toggle-dot"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Email Notifications -->
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 p-6 rounded-xl border border-blue-100">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                                <div class="w-8 h-8 bg-cyan-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                Email Notifications
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                Send detailed election information, candidate profiles, and comprehensive results via email 
                                to student UCC email addresses. Perfect for detailed communications.
                            </p>
                        </div>
                        
                        <div class="ml-6">
                            <label class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="email-notifications" class="sr-only toggle-input" {{ ($settings['notification_email'] ?? true) ? 'checked' : '' }}>
                                    <div class="block bg-gray-300 w-14 h-8 rounded-full toggle-bg transition-all duration-300"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-all duration-300 toggle-dot"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Election Management -->
        <section class="glass-effect rounded-2xl shadow-2xl mb-8 overflow-hidden hover-scale fade-in">
            <div class="ucc-primary text-white p-6">
                <h2 class="text-3xl font-bold flex items-center">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Election Management
                </h2>
                <p class="text-red-100 mt-2">Start, pause, or end election periods</p>
            </div>
            
            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Start Election -->
                    <form action="{{ route('settings.start-election') }}" method="POST">
                          @csrf
                        <button type="submit" class="w-full ucc-accent text-white p-6 rounded-xl hover:shadow-xl transition-all duration-300 hover-scale group">
                            <div class="flex items-center justify-center mb-3">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Start Election</h3>
                            <p class="text-green-100 text-sm">Begin the voting process and open polls</p>
                        </button>
                    </form>

                    <!-- End Election -->
                    <form action="{{ route('settings.end-election') }}" method="POST">
                          @csrf
                        <button type="submit" class="w-full ucc-secondary text-white p-6 rounded-xl hover:shadow-xl transition-all duration-300 hover-scale group">
                            <div class="flex items-center justify-center mb-3">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2">End Election</h3>
                            <p class="text-red-100 text-sm">Close polls and finalize results</p>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Vote Consolidation -->
        <section class="glass-effect rounded-2xl shadow-2xl overflow-hidden hover-scale fade-in">
            <div class="ucc-primary bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6">
                <h2 class="text-3xl font-bold flex items-center">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    Vote Consolidation & Archive
                </h2>
                <p class="text-indigo-100 mt-2">Finalize election data and prepare for new elections</p>
            </div>
            
            <div class="p-8 text-center">
                <div class="max-w-2xl mx-auto">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 floating-animation">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Consolidate All Votes</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Archive current election data, generate final reports, and reset the system for new elections. 
                        This process will create a permanent record and clear all active voting data.
                    </p>

                    <form id="consolidate-form" action="{{route('settings.consolidate-votes')}}" method="POST">
                          @csrf
                        <button type="submit" id="consolidate-button" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-xl hover:shadow-2xl transition-all duration-300 hover-scale text-lg font-semibold group">
                            <span id="button-text" class="flex items-center justify-center">
                                <svg class="w-6 h-6 mr-3 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Consolidate & Archive Votes
                            </span>
                            <span id="loading-spinner" class="hidden flex items-center justify-center">
                                <svg class="animate-spin w-6 h-6 mr-3" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing Archive...
                            </span>
                        </button>
                    </form>
                    
                    <p class="text-sm text-gray-500 mt-4">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        This action cannot be undone. Please ensure all election activities are complete.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-8 mt-16">
        <div class="container mx-auto px-6 text-center">
            <div class="flex items-center justify-center mb-4">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold">University of Cape Coast</h3>
            </div>
            <p class="text-gray-400 text-sm">&copy; 2025 University of Cape Coast. All rights reserved.</p>
        </div>
    </footer>
</body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle functionality
            const toggles = document.querySelectorAll('.toggle-input');
            
            toggles.forEach(toggle => {
                const bg = toggle.parentElement.querySelector('.toggle-bg');
                const dot = toggle.parentElement.querySelector('.toggle-dot');
                
                // Initialize toggle state
                updateToggleStyle(toggle, bg, dot);
                
                toggle.addEventListener('change', function() {
                    updateToggleStyle(this, bg, dot);
                    handleToggleChange(this);
                });
            });
            
            function updateToggleStyle(toggle, bg, dot) {
                if (toggle.checked) {
                    bg.classList.remove('bg-gray-300');
                    bg.classList.add('bg-blue-500');
                    dot.classList.add('translate-x-6');
                } else {
                    bg.classList.add('bg-gray-300');
                    bg.classList.remove('bg-blue-500');
                    dot.classList.remove('translate-x-6');
                }
            }
            
            function handleToggleChange(changedToggle) {
                const toggleId = changedToggle.id;
                
                // Handle network settings
                if (toggleId === 'campus-network' || toggleId === 'open-access') {
                    handleNetworkSettings(changedToggle);
                }
                
                // Handle notification settings
                if (toggleId === 'sms-notifications' || toggleId === 'email-notifications') {
                    handleNotificationSettings(changedToggle);
                }
            }
            
            function handleNetworkSettings(changedToggle) {
                const toggleId = changedToggle.id;
                
                if (toggleId === 'campus-network' && changedToggle.checked) {
                    const openAccess = document.getElementById('open-access');
                    if (openAccess.checked) {
                        openAccess.checked = false;
                        const openBg = openAccess.parentElement.querySelector('.toggle-bg');
                        const openDot = openAccess.parentElement.querySelector('.toggle-dot');
                        updateToggleStyle(openAccess, openBg, openDot);
                    }
                    sendNetworkUpdate('network_restriction', true);
                } else if (toggleId === 'open-access' && changedToggle.checked) {
                    const campusNetwork = document.getElementById('campus-network');
                    if (campusNetwork.checked) {
                        campusNetwork.checked = false;
                        const campusBg = campusNetwork.parentElement.querySelector('.toggle-bg');
                        const campusDot = campusNetwork.parentElement.querySelector('.toggle-dot');
                        updateToggleStyle(campusNetwork, campusBg, campusDot);
                    }
                    sendNetworkUpdate('network_restriction', false);
                }
            }
            
            function handleNotificationSettings(changedToggle) {
                const toggleId = changedToggle.id;
                const smsToggle = document.getElementById('sms-notifications');
                const emailToggle = document.getElementById('email-notifications');
                
                if (toggleId === 'sms-notifications' && changedToggle.checked) {
                    // If SMS is enabled, disable email
                    if (emailToggle.checked) {
                        emailToggle.checked = false;
                        const emailBg = emailToggle.parentElement.querySelector('.toggle-bg');
                        const emailDot = emailToggle.parentElement.querySelector('.toggle-dot');
                        updateToggleStyle(emailToggle, emailBg, emailDot);
                        sendNotificationUpdate('notification_email', false);
                    }
                    sendNotificationUpdate('notification_sms', true);
                    showNotification('SMS notifications enabled. Email notifications disabled.', 'success');
                } 
                else if (toggleId === 'email-notifications' && changedToggle.checked) {
                    // If email is enabled, disable SMS
                    if (smsToggle.checked) {
                        smsToggle.checked = false;
                        const smsBg = smsToggle.parentElement.querySelector('.toggle-bg');
                        const smsDot = smsToggle.parentElement.querySelector('.toggle-dot');
                        updateToggleStyle(smsToggle, smsBg, smsDot);
                        sendNotificationUpdate('notification_sms', false);
                    }
                    sendNotificationUpdate('notification_email', true);
                    showNotification('Email notifications enabled. SMS notifications disabled.', 'success');
                }
                else if (toggleId === 'sms-notifications' && !changedToggle.checked) {
                    // If SMS is disabled, enable email by default
                    if (!emailToggle.checked) {
                        emailToggle.checked = true;
                        const emailBg = emailToggle.parentElement.querySelector('.toggle-bg');
                        const emailDot = emailToggle.parentElement.querySelector('.toggle-dot');
                        updateToggleStyle(emailToggle, emailBg, emailDot);
                        sendNotificationUpdate('notification_email', true);
                    }
                    sendNotificationUpdate('notification_sms', false);
                    showNotification('SMS notifications disabled. Email notifications enabled by default.', 'info');
                }
                else if (toggleId === 'email-notifications' && !changedToggle.checked) {
                    // If email is disabled, enable SMS by default
                    if (!smsToggle.checked) {
                        smsToggle.checked = true;
                        const smsBg = smsToggle.parentElement.querySelector('.toggle-bg');
                        const smsDot = smsToggle.parentElement.querySelector('.toggle-dot');
                        updateToggleStyle(smsToggle, smsBg, smsDot);
                        sendNotificationUpdate('notification_sms', true);
                    }
                    sendNotificationUpdate('notification_email', false);
                    showNotification('Email notifications disabled. SMS notifications enabled.', 'info');
                }
            }
            
            function sendNetworkUpdate(setting, value) {
                const formData = new FormData();
                formData.append('setting', setting);
                formData.append('value', value ? 1 : 0);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                fetch('/settings/update-network', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        showNotification('Failed to update network settings', 'error');
                        // Revert the toggle if update failed
                        const toggle = document.getElementById(value ? 'campus-network' : 'open-access');
                        toggle.checked = !value;
                        const bg = toggle.parentElement.querySelector('.toggle-bg');
                        const dot = toggle.parentElement.querySelector('.toggle-dot');
                        updateToggleStyle(toggle, bg, dot);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Network error occurred', 'error');
                });
            }
            
            function sendNotificationUpdate(setting, value) {
                const formData = new FormData();
                formData.append('setting', setting);
                formData.append('value', value ? 1 : 0);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                fetch('/settings/update-notifications', {
                    method: 'POST',
                    body: formData
                })
                
                .then(response => response.json())
                .then(data => {
                  console.log(data);
                    if (!data.success) {
                        showNotification('Failed to update notification settings', 'error');
                        // Revert the toggle if update failed
                        const toggle = document.getElementById(setting === 'notification_sms' ? 'sms-notifications' : 'email-notifications');
                        toggle.checked = !value;
                        const bg = toggle.parentElement.querySelector('.toggle-bg');
                        const dot = toggle.parentElement.querySelector('.toggle-dot');
                        updateToggleStyle(toggle, bg, dot);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Network error occurred', 'error');
                });
            }
            
            function showNotification(message, type) {
                const flashContainer = document.getElementById('flash-messages');
                const notification = document.createElement('div');
                
                const bgColor = type === 'success' ? 'bg-green-500' : 
                               type === 'error' ? 'bg-red-500' : 
                               type === 'info' ? 'bg-blue-500' : 'bg-gray-500';
                
                const icon = type === 'success' ? 
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' :
                    type === 'error' ? 
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' :
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                
                notification.innerHTML = `
                    <div class="${bgColor} text-white px-6 py-4 rounded-xl shadow-2xl notification-enter flex items-center space-x-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${icon}
                        </svg>
                        <span class="font-medium">${message}</span>
                    </div>
                `;
                
                flashContainer.appendChild(notification);
                
                // Auto-dismiss after 4 seconds
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 4000);
            }
            
            // Consolidate form handling
            const consolidateForm = document.getElementById('consolidate-form');
            const consolidateButton = document.getElementById('consolidate-button');
            const buttonText = document.getElementById('button-text');
            const loadingSpinner = document.getElementById('loading-spinner');
            
            consolidateForm.addEventListener('submit', function(event) {
                event.preventDefault();
                
                // Show confirmation dialog
                if (!confirm('Are you sure you want to consolidate all votes? This action cannot be undone and will archive all current election data.')) {
                    return;
                }
                
                // Disable button and show loading
                consolidateButton.disabled = true;
                buttonText.classList.add('hidden');
                loadingSpinner.classList.remove('hidden');
                
                // Submit form after delay
                setTimeout(() => {
                    consolidateForm.submit();
                }, 1000);
            });
            
            // Initialize animations
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach((element, index) => {
                element.style.animationDelay = ${index * 0.1}s;
            });
        });
    </script>

</x-admin-sidebar>
@else
<script>
  window.location.href = "{{ route('/student') }}";
</script> 
@endauth