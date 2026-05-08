@auth('candidates')
<x-candidate-sidebar>
    <style>
        .chart-container {
            width: 100%;
            height: 300px;
        }
        .progress-ring {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        @keyframes ticker {
		  0% {
			transform: translateX(0);
		  }
		  100% {
			transform: translateX(-100%);
		  }
		}
		
		.animate-ticker {
		  animation: ticker 30s linear infinite;
		}
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    
    
    <!-- Dashboard Stats -->
    <div class="container mx-auto py-6">
        
        <div class="mb-4">
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
            <p id="greeting" class="text-white">Hello 👋, welcome Team {{$candidate->team_name}}!</p>
        
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 mt-4">
            
            <div class="bg-white rounded-lg shadow-md p-4 stat-card">
                
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                   
                    <div>
                        <p class="text-sm text-gray-500">Total Voters</p>
                        <p class="text-lg font-bold">{{$totalvoters}}</p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-xs text-green-500"><i class="fas fa-arrow-up"></i> 12% from last election</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-4 stat-card">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Voter Turnout</p>
                        <p class="text-lg font-bold vote-turnout">{{$voterTurnout}}%</p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-xs text-green-500"><i class="fas fa-arrow-up"></i> 5.2% from last election</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-4 stat-card">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Candidates</p>
                        <p class="text-lg font-bold">{{$totalcandidate->count()}}</p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-xs text-red-500"><i class="fas fa-arrow-down"></i> 2 fewer than last election</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-4 stat-card">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">votes counts</p>
                        <p class="text-lg font-bold vote-count">{{$totalVotes}}</p>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto py-6">
        <!-- Tabs Navigation -->
        <div class="bg-white shadow-md rounded-lg mb-6 overflow-x-auto scroll-container">
            <ul class="flex border-b whitespace-nowrap">
                <!-- Overview Tab -->
                <li class="tab-item -mb-px mr-1" data-tab="overview">
                    <a href="#" class="bg-white inline-block py-3 px-6 text-gray-600 hover:text-blue-600 font-semibold transition-colors duration-200 border-b-2 border-transparent hover:border-blue-600">
                        <i class="fas fa-home mr-2"></i>Overview
                    </a>
                </li>
        
                <!-- Candidate Tab -->
                <li class="tab-item mr-1" data-tab="candidate">
                    <a href="#" class="bg-white inline-block py-3 px-6 text-gray-600 hover:text-blue-600 font-semibold transition-colors duration-200 border-b-2 border-transparent hover:border-blue-600">
                        <i class="fas fa-user mr-2"></i>Candidate
                    </a>
                </li>
        
                <!-- Voting Data Tab -->
                <li class="tab-item mr-1" data-tab="voting">
                    <a href="#" class="bg-white inline-block py-3 px-6 text-gray-600 hover:text-blue-600 font-semibold transition-colors duration-200 border-b-2 border-transparent hover:border-blue-600">
                        <i class="fas fa-chart-bar mr-2"></i>Voting Data
                    </a>
                </li>
        
                <!-- Coalition Tab -->
                <li class="tab-item mr-1" data-tab="coalition">
                    <a href="#" class="bg-white inline-block py-3 px-6 text-gray-600 hover:text-blue-600 font-semibold transition-colors duration-200 border-b-2 border-transparent hover:border-blue-600">
                        <i class="fas fa-users mr-2"></i>Coalition
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Overview Tab -->
            <div id="overview" class="tab-content active">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Election Overview</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        
                            <div>
                                <h3 class="text-xl font-semibold mb-4">Election Progress</h3>
                                <div class="">
                                    <!-- Progress Circle -->
                                    <svg width="200" height="200" viewBox="0 0 100 100">
                                        <!-- Background Circle -->
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="#e6e6e6" stroke-width="10" />
                                        <!-- Progress Circle -->
                                        <circle class="progress-ring" cx="50" cy="50" r="45" fill="none" stroke="#3b82f6" stroke-width="10" stroke-dasharray="283" stroke-dashoffset="283" />
                                        <!-- Progress Percentage -->
                                        <text x="50" y="50" font-size="20" text-anchor="middle" alignment-baseline="middle" fill="#333">0%</text>
                                    </svg>
                        
                                    <!-- Election News Ticker -->
                                    <div class="bg-gray-900 text-white relative overflow-hidden whitespace-nowrap shadow-md mt-4">
                                        <div class="bg-red-600 text-white font-bold py-1 px-3 inline-flex items-center space-x-2 relative z-10">
                                            <span>ELECTION NEWS</span>
                                            <svg viewBox="0 0 1024 1024" class="icon w-6 h-6" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#fffafa" stroke="#fffafa">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path d="M780.8 535.7l-39.5-6.2 46-292.8-286.6 48-6.6-39.4 341.3-57.2z" fill="#ededed"></path>
                                                    <path d="M626.153 367.866L760.915 236.92l27.876 28.688-134.762 130.947z" fill="#ededed"></path>
                                                    <path d="M404.6 711.1m-87.1 0a87.1 87.1 0 1 0 174.2 0 87.1 87.1 0 1 0-174.2 0Z" fill="#1a1a1a"></path>
                                                    <path d="M811.4 212.4m-87.1 0a87.1 87.1 0 1 0 174.2 0 87.1 87.1 0 1 0-174.2 0Z" fill="#1a1a1a"></path>
                                                    <path d="M329.1 63.9c-6.9 5.6-13.5 11.5-19.9 17.8-134.8 133.1-102.3 381 72.5 553.6S807.5 840 942.3 706.9c6.4-6.3 12.4-12.9 18-19.7L329.1 63.9zM575.4 928.1c0.5-3.8 0.8-7.6 0.8-11.5 1.9-81.5-82.2-147.6-187.9-147.7-105.7-0.1-193 65.9-195 147.4-0.1 3.9 0 7.7 0.3 11.5l381.8 0.3z" fill="#ededed"></path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="animate-ticker inline-block whitespace-nowrap">
                                            @foreach($pollData as $poll)
                                            <span class="inline-block px-8 py-1 relative after:content-['•'] after:absolute after:right-2">
                                                Election currently ongoing: {{ $poll['title'] }} - 
                                                <span class="countdown-timer" data-start="{{ $poll['start'] }}" data-end="{{ $poll['end'] }}"></span>
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Progress Description -->
                                <div class="mt-4">
                                    <p class="text-gray-600">The election is in progress with <span id="progress-percentage">0%</span> of the time elapsed. Voting will continue for <span id="time-left">0d 0h 0m 0s</span>.</p>
                                </div>
                            </div>                 
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Key Events</h3>
                        <div class="space-y-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium">Candidate Registration</h4>
                                    <p class="text-gray-500">{{$candidate->created_at}}</p>
                                </div>
                            </div>
                            

                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                                        <i class="fas fa-microphone"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium">Public Debate</h4>
                                    <p class="text-gray-500"> - University Auditorium</p>
                                </div>
                            </div>
                            

                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white">
                                        <i class="fas fa-vote-yea"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium">Voting Period</h4>
                                    <p class="text-gray-500">{{$candidate->created_at}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- <div class="mt-8">
                    <h3 class="text-xl font-semibold mb-4">Leading Candidates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($totalcandidate as $index => $totalcandidates)
                            <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 p-4 rounded-lg shadow">
                                <div class="flex items-center mb-4">
                                    <img src="{{ asset('storage/default_image/special_voting.jpg') }}" alt="Candidate" class="rounded-full border-4 border-white shadow w-20 h-20">
                                    <div class="ml-4">
                                        <h4 class="font-bold">Candidate {{ $loop->iteration }}</h4>
                                        <p class="text-sm text-gray-600">{{ $totalcandidates->encrypted_team_name }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <p>{{ $totalcandidates->vote_percentage }}%</p>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalcandidates->vote_percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
                
            </div>

            <!-- Candidate Tab -->
            <div id="candidate" class="tab-content">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Candidate Profile</h2>
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/' . $candidate->image_path) }}" alt="Candidate" class="rounded-lg shadow-md mb-4 md:mb-0">
                    </div>
                    <div class="md:w-2/3 md:ml-6">
                        <h3 class="text-xl font-semibold mb-4">{{$candidate->name}}</h3>
                        <p class="text-gray-600 mb-4">{{$candidate->biography}}</p>
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Position</p>
                                <p class="text-lg font-bold">{{$candidate->portfolio}}</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Votes Received</p>
                                <p class="text-lg font-bold vote-count">{{$totalVotes}}</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Percentage</p>
                                <p class="text-lg font-bold vote-turnout">{{$voterTurnout}}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Voting Data Tab -->
            
            <div class="overflow-x-auto">
                <div id="voting" class="tab-content">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Voting Data by Hall</h2>
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Hall</th>
                                    <th class="py-3 px-6 text-left">Total People</th>
                                    <th class="py-3 px-6 text-left">Candidate Votes</th>
                                    <th class="py-3 px-6 text-left">Total Votes in Hall</th>
                                    <th class="py-3 px-6 text-left">Percentage</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($hallVotesData as $hall => $data)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">{{ $hall }}</td>
                                    <td class="py-3 px-6 text-left">{{ $data['total_people'] }}</td>
                                    <td class="py-3 px-6 text-left">{{ $data['candidate_votes'] }}</td>
                                    <td class="py-3 px-6 text-left">{{ $data['total_votes_in_hall'] }}</td>
                                    <td class="py-3 px-6 text-left">{{ $data['percentage'] }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Coalition Tab -->
            <div id="coalition" class="tab-content">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Election Information</h2>
                <div>
                    <p>Coalition Name: <span class="font-bold">{{$candidate->team_name}}</span></p>
                    
                    <p>Election Members: <span class="font-bold">
                        @foreach ( $totalcandidate as  $totalcandidates)
                        {{$totalcandidates->team_name.","}}
                        @endforeach
                    </span>
                       
                    </p>   
                    
                    
                    <p>Total Election Coalition Votes: <span class="font-bold">{{$totalVotesElection}}</span></p>
                    <p>Election Goals: <span class="font-bold">Improve student facilities, enhance academic programs, promote community engagement</span></p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    {{-- <footer class="bg-gradient-to-r from-blue-600 to-indigo-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <p class="text-sm">© 2025 University Name. All rights reserved.</p>
            <div>
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer> --}}

    <script>


    // document.addEventListener('DOMContentLoaded', function () {
    //     // Listen for the 'voter.count.updated' event
    //     // window.Echo.channel('strongrooms')
    //     // .listen('.VoteUpdated', (data) => {
    //     //     console.log('Vote updated:', data);

    //     //     // Total voters in the election
    //     //     const totalVoters = {{ $totalvoters }}; // Ensure this variable is passed from Blade

    //     //     // Check if the event is for the current candidate
    //     //     if (data.candidateId === "{{ auth('candidates')->user()->id }}") {
    //     //         // Update all elements with the class 'vote-count'
    //     //         document.querySelectorAll('.vote-count').forEach(el => {
    //     //             el.textContent = data.voteCount;
    //     //         });

    //     //         // Calculate voter turnout percentage
    //     //         const turnoutPercentage = totalVoters > 0 ? ((data.voteCount / totalVoters) * 100).toFixed(2) : "0.00";

    //     //         // Update the voter turnout percentage
    //     //         document.querySelectorAll('.vote-turnout').forEach(el => {
    //     //             el.textContent = `${turnoutPercentage}%`;
    //     //         });

    //     //         // Log for debugging
    //     //         console.log('Total votes updated for candidate:', data.candidateId);
    //     //         console.log('Updated turnout percentage:', turnoutPercentage);
    //     //     }
    //     // });

            
            
    //         })

       
        // JavaScript for tab functionality
        document.querySelectorAll('.tab-item').forEach(item => {
            item.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                document.querySelectorAll('.tab-item').forEach(el => el.classList.remove('-mb-px'));
                this.classList.add('-mb-px');
                document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
                document.getElementById(tabId).classList.add('active');
            });
        });

        const beepSound = document.getElementById('beep-sound');

// Initialize all countdown timers and progress bars
document.querySelectorAll('.countdown-timer').forEach((countdownElement) => {
    const startTime = parseInt(countdownElement.dataset.start);
    const endTime = parseInt(countdownElement.dataset.end);
    const progressRing = document.querySelector('.progress-ring');
    const progressText = document.querySelector('text');
    const progressPercentageElement = document.getElementById('progress-percentage');
    const timeLeftElement = document.getElementById('time-left');

    function updateTimer() {
        const now = Date.now();
        const totalDuration = endTime - startTime;
        const timePassed = now - startTime;
        const timeLeft = endTime - now;

        // Calculate progress percentage
        const progress = Math.min((timePassed / totalDuration) * 100, 100);
        const progressOffset = 283 - (283 * progress) / 100;

        // Update progress bar
        progressRing.style.strokeDashoffset = progressOffset;
        progressText.textContent = `${Math.round(progress)}%`;
        progressPercentageElement.textContent = `${Math.round(progress)}%`;

        // Update countdown timer
        if (timeLeft > 0) {
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            countdownElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            timeLeftElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;

        
        } else {
            countdownElement.textContent = 'Poll ended';
            timeLeftElement.textContent = 'Poll ended';
        }
    }

    setInterval(updateTimer, 1000);
    updateTimer();
});

// Initialize ticker animation
$(function() {
    const ticker = $('.animate-ticker');
    ticker.append(ticker.html()); // Clone content for seamless loop
});

    </script>
</body>
</x-candidate-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth