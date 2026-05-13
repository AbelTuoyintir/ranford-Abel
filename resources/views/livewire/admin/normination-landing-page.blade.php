<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UCC-EVOTE</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class="rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])
    <script src="https://unpkg.com/gsap@3.12.2/dist/gsap.min.js"></script>
    <style>
        :root {
            --ucc-navy: #00205B;
            --ucc-gold: #FFD700;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding-top: 2px;
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
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: modalFadeIn 0.3s;
        }
        
        @keyframes modalFadeIn {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: black;
        }
        
        .status-card {
            transition: all 0.3s ease;
        }
        
        .status-card:hover {
            transform: scale(1.03);
        }
        
        .status-nominee {
            border-left: 4px solid #4CAF50;
        }
        
        .status-aspirant {
            border-left: 4px solid #FFC107;
        }
        
        .status-candidate {
            border-left: 4px solid #2196F3;
        }
        
        .status-rejected {
            border-left: 4px solid #F44336;
        }
        
        .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid var(--ucc-navy);
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Success/Error Messages -->
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

    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="ucc-navy text-white shadow-lg">
            <div class="container mx-auto px-4 py-3 flex items-center justify-between space-x-2">
                <div class="flex items-center">
                    <img src="{{ asset('images/IMG_202411319_103428204.png') }}" alt="" class="h-10 w-10 rounded-lg m-1" />
                    <div>
                        <h1 class="text-xl font-bold">University of Cape Coast</h1>
                        <p class="text-sm text-ucc-gold">Electronic Voting Portal</p>
                    </div>
                </div>
                <div>
                    <button id="checkStatusBtn" class="bg-white text-ucc-navy px-4 py-2 rounded-md font-medium hover:bg-gray-100 transition duration-300">
                        Check Nomination Status
                    </button>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="py-16 ucc-navy text-white slide-in-section">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">UCC Student Elections </h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto">Participate in the democratic process of electing your student leaders.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <button id="nominateBtn" class="ucc-gold text-ucc-navy px-8 py-3 rounded-md font-bold text-lg hover:bg-yellow-500 transition duration-300 btn-hover">
                        Start Nomination Process
                    </button>
                    <button id="nominateBtn1" class="ucc-gold text-ucc-navy px-8 py-3 rounded-md font-bold text-lg hover:bg-yellow-500 transition duration-300 btn-hover">
                        Print Nomination Form
                    </button>
                </div>
            </div>
        </section>

        <!-- Nominations Section -->
        <section class="py-16 bg-white slide-in-section">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-ucc-navy mb-12">Nomination Process</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md card-hover">
                        <div class="text-ucc-gold text-4xl font-bold mb-4">1</div>
                        <h3 class="text-xl font-bold text-ucc-navy mb-3">Get Your Voucher</h3>
                        <p class="text-gray-600">Obtain your unique nomination voucher from your department or faculty office.</p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md card-hover">
                        <div class="text-ucc-gold text-4xl font-bold mb-4">2</div>
                        <h3 class="text-xl font-bold text-ucc-navy mb-3">Complete Nomination Form</h3>
                        <p class="text-gray-600">Fill out the online nomination form using your voucher code and password.</p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md card-hover">
                        <div class="text-ucc-gold text-4xl font-bold mb-4">3</div>
                        <h3 class="text-xl font-bold text-ucc-navy mb-3">Check Your Status</h3>
                        <p class="text-gray-600">Monitor your nomination status as it progresses through the screening process.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Status Info Section -->
        <section class="py-16 bg-gray-50 slide-in-section">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-ucc-navy mb-12">Nomination Status Levels</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Nominee -->
                    <div class="bg-white p-6 rounded-lg shadow-md status-card status-nominee">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-ucc-navy">Nominee</h3>
                        </div>
                        <p class="text-gray-600">Your nomination form has been successfully submitted and is awaiting initial screening.</p>
                    </div>
                    
                    <!-- Aspirant -->
                    <div class="bg-white p-6 rounded-lg shadow-md status-card status-aspirant">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-ucc-navy">Aspirant</h3>
                        </div>
                        <p class="text-gray-600">You've passed initial screening and are now an aspirant. Campaign materials can be submitted.</p>
                    </div>
                    
                    <!-- Candidate -->
                    <div class="bg-white p-6 rounded-lg shadow-md status-card status-candidate">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-ucc-navy">Candidate</h3>
                        </div>
                        <p class="text-gray-600">Congratulations! You've passed all screenings and are now an official candidate in the elections.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Nomination Modal -->
        <div id="nominationModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 class="text-2xl font-bold text-ucc-navy mb-6">Enter Voucher Details</h2>
                
                <form method="POST" action="{{ route('nomination.login') }}" id="nominationForm">
                    @csrf
                    <div class="mb-4">
                        <label for="Voucher" class="block text-sm font-medium text-gray-700 mb-1">Voucher Code</label>
                        <input type="text" id="Voucher" name="Voucher" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ucc-navy focus:border-ucc-navy" placeholder="ucc-eVote-XXXXX" required>
                    </div>
                    
                    <div class="mb-6">
                        <label for="Password" class="block text-sm font-medium text-gray-700 mb-1">Voucher Password</label>
                        <input type="password" id="Password" name="Password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ucc-navy focus:border-ucc-navy" placeholder="Enter your password" required>
                    </div>
                    
                    <div class="flex justify-between">
                        <button type="button" id="checkStatusOnlyBtn" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-md font-medium hover:bg-gray-300 transition duration-300">
                            Check Status Only
                        </button>
                        <button type="submit" class="ucc-navy text-white px-6 py-2 rounded-md font-medium hover:bg-blue-800 transition duration-300">
                            Proceed to Nomination
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="nominationModal_print" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('nominationModal_print').style.display='none'">&times;</span>
                <h2 class="text-2xl font-bold text-ucc-navy mb-6">Enter Voucher Details</h2>
                
                <form method="POST" action="{{ route('nomination.print') }}" id="nominationForm">
                    @csrf
                    <div class="mb-4">
                        <label for="Voucher" class="block text-sm font-medium text-gray-700 mb-1">Voucher Code</label>
                        <input type="text" id="Voucher" name="Voucher" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ucc-navy focus:border-ucc-navy" placeholder="ucc-eVote-XXXXX" required>
                    </div>
                    
                    <div class="mb-6">
                        <label for="Password" class="block text-sm font-medium text-gray-700 mb-1">Voucher Password</label>
                        <input type="password" id="Password" name="Password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ucc-navy focus:border-ucc-navy" placeholder="Enter your password" required>
                    </div>
                    
                    <div class="flex justify-between">
                        <button type="submit" class="ucc-navy text-white px-6 py-2 rounded-md font-medium hover:bg-blue-800 transition duration-300">
                            Proceed to Print
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Status Result Modal -->
        <div id="statusModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="statusContent">
                    <!-- Content will be dynamically inserted here -->
                </div>
            </div>
        </div>

        <!-- Loading Modal -->
        <div id="loadingModal" class="modal">
            <div class="modal-content">
                <div class="loading-spinner"></div>
                <p class="text-center mt-4 text-ucc-navy font-medium">Checking your nomination status...</p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8 slide-in-section">
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
    </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get modal elements
        const nominationModal = document.getElementById('nominationModal');
        const nominationModal_print = document.getElementById('nominationModal_print')
        const statusModal = document.getElementById('statusModal');
        const loadingModal = document.getElementById('loadingModal');
        const nominateBtn = document.getElementById('nominateBtn');
        const nominateBtn1 = document.getElementById('nominateBtn1');
        const checkStatusBtn = document.getElementById('checkStatusBtn');
        const checkStatusOnlyBtn = document.getElementById('checkStatusOnlyBtn');
        const closeButtons = document.querySelectorAll('.close');
        const nominationForm = document.getElementById('nominationForm');
        
        // ✅ FIXED: Open nomination modal (for starting new nomination)
        if (nominateBtn) {
            nominateBtn.addEventListener('click', function() {
                nominationModal.style.display = 'block';
            });
        }
        
        if (nominateBtn1) {
            nominateBtn1.addEventListener('click', function() {
                nominationModal_print.style.display = 'block';
            });
        }

        
        // ✅ FIXED: Open status check modal (this was wrong)
        if (checkStatusBtn) {
            checkStatusBtn.addEventListener('click', function() {
                // Clear previous values
                document.getElementById('Voucher').value = '';
                document.getElementById('Password').value = '';
                // Open the nomination modal which contains the status check form
                nominationModal.style.display = 'block';
            });
        }
        
        // Close modals when clicking X
        closeButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                nominationModal.style.display = 'none';
                statusModal.style.display = 'none';
                loadingModal.style.display = 'none';
            });
        });
        
        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === nominationModal) {
                nominationModal.style.display = 'none';
            }
            if (event.target === statusModal) {
                statusModal.style.display = 'none';
            }
            if (event.target === loadingModal) {
                loadingModal.style.display = 'none';
            }
        });
        
        // ✅ FIXED: Check status only
        if (checkStatusOnlyBtn) {
            checkStatusOnlyBtn.addEventListener('click', async function() {
                const voucherCode = document.getElementById('Voucher').value;
                const voucherPassword = document.getElementById('Password').value;
                
                if (!voucherCode || !voucherPassword) {
                    alert('⚠️ Please enter both voucher code and password');
                    return;
                }
                
                try {
                    // Show loading modal
                    loadingModal.style.display = 'block';
                    nominationModal.style.display = 'none';
                    
                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        throw new Error('CSRF token not found. Please refresh the page.');
                    }
                    
                    // Make API call to check status
                    const response = await fetch('/nomination/status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.content
                        },
                        body: JSON.stringify({
                            voucher: voucherCode,
                            password: voucherPassword
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (!response.ok) {
                        throw new Error(data.message || data.error || 'Failed to check status');
                    }
                    
                    // Hide loading modal and display status result
                    loadingModal.style.display = 'none';
                    displayStatusResult(data);
                    
                } catch (error) {
                    loadingModal.style.display = 'none';
                    alert('❌ ' + error.message);
                    console.error('Error checking status:', error);
                }
            });
        }
        
        // Function to display status result
        function displayStatusResult(data) {
            let statusContent = '';
            let statusClass = '';
            let icon = '';
            
            // Handle different status types
            const status = data.status;
            const role = data.role;
            const roleDisplay = data.role_display;
            const statusDisplay = data.status_display;
            const message = data.message;
            const updatedAt = data.updated_at;
            const rejectionReason = data.rejection_reason;
            
            // Set icon and class based on status
            if (status === 'rejected') {
                statusClass = 'status-rejected';
                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
            } 
            else if (status === 'approved') {
                if (role === 'candidate') {
                    statusClass = 'status-candidate';
                    icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>';
                } else if (role === 'aspirant') {
                    statusClass = 'status-aspirant';
                    icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                } else {
                    statusClass = 'status-approved';
                    icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                }
            }
            else if (status === 'submitted') {
                statusClass = 'status-submitted';
                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            }
            else if (status === 'saved') {
                statusClass = 'status-saved';
                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M12 3v8m0 0l-3-3m3 3l3-3" /></svg>';
            }
            else if (status === 'draft') {
                statusClass = 'status-draft';
                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>';
            }
            else if (status === 'not_started') {
                statusClass = 'status-not-started';
                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>';
            }
            else {
                statusClass = 'status-pending';
                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            }
            
            // Build rejection reason if available
            const rejectionHtml = rejectionReason 
                ? `<div class="mt-4 p-3 bg-red-50 border-l-4 border-red-500 rounded">
                      <p class="text-red-700 font-semibold"><i class="fas fa-exclamation-triangle"></i> Reason for Rejection:</p>
                      <p class="text-red-600 mt-1">${escapeHtml(rejectionReason)}</p>
                   </div>`
                : '';
            
            // Build position display
            const positionHtml = data.position 
                ? `<div class="mt-3 p-2 bg-gray-50 rounded">
                      <p class="text-sm text-gray-600"><strong>Position:</strong> ${escapeHtml(data.position)}</p>
                   </div>`
                : '';
            
            statusContent = `
                <div class="text-center p-6 ${statusClass}">
                    <div class="mx-auto w-24 h-24 mb-4">${icon}</div>
                    <h3 class="text-2xl font-bold text-ucc-navy mb-2">Status: ${escapeHtml(statusDisplay || 'Unknown')}</h3>
                    ${roleDisplay ? `<p class="text-lg text-ucc-blue mb-2">Role: ${escapeHtml(roleDisplay)}</p>` : ''}
                    <p class="text-gray-600 mb-4">${escapeHtml(message || 'Your nomination is being processed.')}</p>
                    ${positionHtml}
                    ${updatedAt ? `<p class="text-sm text-gray-500">Last updated: ${escapeHtml(updatedAt)}</p>` : ''}
                    ${rejectionHtml}
                </div>
            `;
            
            const statusContentElement = document.getElementById('statusContent');
            if (statusContentElement) {
                statusContentElement.innerHTML = statusContent;
                statusModal.style.display = 'block';
            }
        }
        
        // Helper function to escape HTML
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Animation code (only if GSAP is loaded)
        if (typeof gsap !== 'undefined') {
            const ballotElement = document.getElementById('ballot');
            if (ballotElement) {
                gsap.timeline({repeat: -1, repeatDelay: 2})
                    .to("#ballot", {y: -20, duration: 1})
                    .to("#ballot", {y: 150, duration: 1, delay: 0.5, ease: "bounce.out"});
            }
        }
        
        // Scroll animation for cards
        const cards = document.querySelectorAll('.card-hover');
        
        function checkScroll() {
            cards.forEach(card => {
                const cardPosition = card.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (cardPosition < screenPosition) {
                    card.style.opacity = 1;
                    card.style.transform = 'translateY(0)';
                }
            });
        }
        
        // Set initial state
        cards.forEach(card => {
            card.style.opacity = 0;
            card.style.transform = 'translateY(50px)';
            card.style.transition = 'all 0.6s ease-out';
        });
        
        // Check on load and scroll
        window.addEventListener('scroll', checkScroll);
        checkScroll();
        
        // Slide-in animation for all sections (using GSAP if available)
        const sections = document.querySelectorAll('.slide-in-section');
        
        if (typeof gsap !== 'undefined') {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        gsap.to(entry.target, {
                            opacity: 1,
                            y: 0,
                            duration: 1,
                            ease: "power2.out"
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });
            
            sections.forEach(section => {
                observer.observe(section);
            });
        } else {
            // Fallback for GSAP not loaded
            sections.forEach(section => {
                section.style.opacity = 1;
                section.style.transform = 'translateY(0)';
            });
        }
    });
</script>
</body>
</html>