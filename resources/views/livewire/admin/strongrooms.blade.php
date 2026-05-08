@auth
<x-admin-sidebar>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <div class="my-1 py-1">
        {{-- @php
            $polls = $polls;
            $endTime = isset($poll) ? \Carbon\Carbon::parse($poll->end_time)->timestamp * 1000 : 0;
			$startTime = isset($poll) ? \Carbon\Carbon::parse($poll->start_time)->timestamp * 1000 : 0;

        @endphp
        <div class="w-full">
            <div class="w-full max-w-9xl overflow-hidden relative">
                <div class="bg-gray-900 text-white relative overflow-hidden whitespace-nowrap shadow-md">
                    <div class="bg-red-600 text-white font-bold py-1 px-3 inline-flex items-center space-x-2 relative z-10">
                        <span>Count Down</span>
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
                    {{-- <div class="animate-ticker inline-block whitespace-nowrap"> --}}
                        {{-- @foreach($pollData as $poll)
                        <span class="inline-block px-8 py-1 relative after:content-['•'] after:absolute after:right-2">
                            Election currently ongoing: {{ $poll['title'] }} - 
                            <span class="countdown-timer" data-start="{{ $poll['start'] }}" data-end="{{ $poll['end'] }}"></span>
                        </span>
                        @endforeach
                    </div> --}} 
                </div>
            </div>
    </div>
    </div>
    <div class="grid grid-cols-4 gap-3">
        <!-- Card 2 -->
        <div class="w-full h-[80px] bg-[#1C204B] rounded-lg cursor-pointer overflow-hidden grid grid-rows-[50px_1fr]">
            <div class="p-4 rounded-lg relative -top-2 grid gap-1">
                <div class="text-4xl font-semibold mb-0 text-white " id="voter-count-number">{{$voters ?? 0000}} </div>
                <p class="text-sm text-gray-200">Votes</p>
            </div>
        </div>
        <div class="w-full h-[80px] bg-[#1C204B] rounded-lg cursor-pointer overflow-hidden grid grid-rows-[50px_1fr]">
            <div class="p-4 rounded-lg relative -top-2 grid gap-1">
                <div class="text-4xl font-semibold mb-0 text-white" id="non-voter-count-number">{{$totalCandidate}}</div>
                <p class="text-sm text-gray-200">Total Candidates</p>
            </div>
        </div>
        <div class="w-full h-[80px] bg-[#1C204B] rounded-lg cursor-pointer overflow-hidden grid grid-rows-[50px_1fr]">
            <div class="p-4 rounded-lg relative -top-2 grid gap-1">
                <div class="text-4xl font-semibold mb-0 text-white">{{ $totalVoters ?? 0000 }} </div>
                <p class="text-sm text-gray-200">Total voters</p>
            </div>
        </div>
        <div class="w-full h-[80px] bg-[#1C204B] rounded-lg cursor-pointer overflow-hidden grid grid-rows-[50px_1fr]">
            <div class="p-4 rounded-lg relative -top-2 grid gap-1">
                <div class="text-4xl font-semibold mb-0 text-white" id="skippedVotes">0000</div>
                <p class="text-sm text-gray-200">Skip votes</p>
            </div>
        </div>
    </div>

    <div class="w-full h-full overflow-y-auto max-h-full bg-gray-50">
        <nav class=" bg-gradient-to-r from-blue-600 to-indigo-600 top-0 flex items-center justify-between px-6 py-4 shadow-lg">
            <div class="flex items-center space-x-4">
                <!-- Hotel logo with badge styling -->
                <div class="flex items-center bg-white/10 backdrop-blur-sm rounded-lg px-4 py-2 space-x-3">
                    <i class="fa-solid fa-hotel text-white text-2xl"></i>
                    <h1 class="text-white font-bold text-2xl tracking-wide">
                        {{ auth()->user()->hall }}
                    </h1>
                </div>
            </div>
            {{-- @foreach($polls as $poll)
                @if (auth()->user()->hall . ' Hall ' . now()->year == $poll->title && $poll->status == 'complete')
                    <a href="#" class="group relative inline-flex items-center justify-center p-2.5 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 animate-bounce-up-down">
                        <!-- Main icon -->
                        <i class="fas fa-download text-white text-2xl transition-transform group-hover:scale-110"></i>

                        <!-- Animated background effect -->
                        <div class="absolute inset-0 rounded-xl bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Pulse animation effect -->
                        <div class="absolute inset-0 rounded-xl border-2 border-white/30 animate-pulse opacity-0 group-hover:opacity-100"></div>

                        <!-- Tooltip -->
                        <span class="absolute -bottom-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-sm px-3 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                            Download Resources
                            <span class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></span>
                        </span>
                    </a> 
                @endif
            @endforeach --}}

            
        </nav>

        <div class="w-full max-w-full min-w-full overflow-x-auto py-2 flex gap-5">
            <!-- Candidate Cards Grouped by Portfolio -->
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach($candidates->groupBy('portfolio_id') as $portfolioId => $portfolioCandidates)
                        @php
                            $portfolio = \App\Models\portfolios::find($portfolioId); // Fetch the portfolio
                            $currentAdminHall = auth()->user()->hall; // Get the logged in admin's hall
                            
                            // If portfolio name contains "hall", filter candidates to only show those from admin's hall
                            if (stripos($portfolio->name, 'HALL') !== false) {
                                $filteredCandidates = $portfolioCandidates->filter(function($candidate) use ($currentAdminHall) {
                                    return $candidate->hall == $currentAdminHall;
                                });
                            } else {
                                // For non-hall portfolios, show all candidates
                                $filteredCandidates = $portfolioCandidates;
                            }
                            
                            // Skip this portfolio slide if there are no candidates to display after filtering
                            if ($filteredCandidates->isEmpty()) {
                                continue;
                            }
                        @endphp
                        <div class="swiper-slide">
                            <div class="w-full p-4 ">
                                <div class="flex items-center">
                                    <svg class="w-10 h-10 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.86L12 17.77l-6.18 3.23L7 14.14l-5-4.87 6.91-1.01L12 2z"/>
                                    </svg>
                                    <h2 class="text-4xl font-bold text-red-600">{{ $portfolio->name }}</h2>
                                </div>
                                
                                <div class="flex gap-5 overflow-x-auto justify-center items-center">
                                    @foreach($filteredCandidates as $candidate)
                                    
                                        <div class="flex justify-center">
                                            <div class="rounded-lg shadow-lg p-3 text-white space-y-3 bg-white max-w-[250px] w-[250px] min-w-[250px]">
                                                <img src="{{ asset('storage/' . $candidate->image_path) }}" alt="candidate image" class="h-[200px] w-full object-cover bg-gray-200 rounded-md">
                                                <div>
                                                    <div class="p-2 bg-blue-200 rounded-md flex items-center justify-between text-black">
                                                        <div>
                                                            <h1 class="font-bold text-2xl text-blue-950" >{{ $candidate->team_name }}</h1>
                                                            <h1 class="text-black">{{ $candidate->teaser }}</h1>
                                                        </div>
                                                        <h1 class="text-1xl font-bold">
                                                            <span>#{{ $candidate->ballot_number }}</span>
                                                        </h1>
                                                    </div>
                                                </div>
                                                <div class="text-black">
                                                    <h1 class="text-black text-lg font-bold">Total</h1>
                                                    <h1 class="text-gray-600 mb-6 text-xl font-medium" id="vote-count-{{ $candidate->id }}">
                                                        {{ $candidate->votes()->count() }} <!-- Initial vote count -->
                                                    </h1>
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="bg-blue-600 rounded-full w-[45%] h-full"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Add navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <div class="px-2">
            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-700 dark:text-gray-400">
                @php
                    $halls = ['CASFORD', 'VALCO', 'KNHALL', 'OGUAA', 'ADEHYE', 'ATLANTIC', 'SRC', 'GUSSS', 'VTRUST', 'UHALL'];
                @endphp
                @foreach($halls as $hall)
                    <li class="me-2">
                        <a href="#" class="inline-block p-4 rounded-t-lg {{ auth()->user()->hall == $hall ? 'bg-gray-800 text-blue-500' : 'hover:bg-gray-800 hover:text-gray-400' }}">
                            {{ $hall }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-xl my-6 mx-3 mb-4">
            <h1 class="text-xl font-bold text-gray-600 mb-4">Current Voters</h1>

            <!-- Real-Time Voters (updated dynamically) -->
            <div class="grid grid-cols-10 gap-2" id="real-time-voters">
                <!-- Voters will be dynamically added here -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper
        const swiper = new Swiper('.swiper', {
            loop: true, // Enable looping
            autoplay: {
                delay: 5000, // Autoplay delay in milliseconds (5 seconds)
                disableOnInteraction: false, // Continue autoplay even after user interaction
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Listen for the 'user.logged.in' event
            window.Echo.channel('strongrooms')
                .listen('.user.logged.in', (data) => {
                    console.log('User logged in:', data);

                    // Check if the logged-in user's hall matches the authenticated user's hall
                    if (data.hall === "{{ auth()->user()->hall }}") {
                        // Create a new voter card
                        const voterCard = document.createElement('div');
                        voterCard.className = 'w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px]';
                        voterCard.id = `voter-${data.schoolId}`; // Add a unique ID for the card
                        voterCard.innerHTML = `
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="${data.image}" alt="voter-image" class="w-auto mx-auto h-[140px]" />
                            </div>
                            <h1 class="text-white p-3 text-bold text-center bg-[#22296F] rounded-lg">
                                ${data.schoolId}
                            </h1>
                        `;

                        // Append the new voter card to the real-time voters section
                        const realTimeVoters = document.getElementById('real-time-voters');
                        realTimeVoters.appendChild(voterCard);
                    }
                });

            // Listen for the 'user.logged.out' event
            window.Echo.channel('strongrooms')
                .listen('.user.logged.out', (data) => {
                    console.log('User logged out:', data);

                    // Check if the logged-out user's hall matches the authenticated user's hall
                    if (data.hall === "{{ auth()->user()->hall }}") {
                        // Find the voter card by its unique ID and remove it
                        const voterCard = document.getElementById(`voter-${data.schoolId}`);
                        if (voterCard) {
                            voterCard.remove();
                        }
                    }
                });

            // Listen for the 'voter.count.updated' event
            window.Echo.channel('strongrooms')
                .listen('.voter.count.updated', (data) => {
                    console.log('Voter count updated:', data);

                    // Check if the updated hall matches the authenticated user's hall
                    if (data.hall === "{{ auth()->user()->hall }}") {
                        // Update the voter count
                        document.getElementById('voter-count-number').textContent = data.voterCount;
                    }
                });

            // Listen for the 'non.voter.count.updated' event
            window.Echo.channel('strongrooms')
                .listen('.non.voter.count.updated', (data) => {
                    console.log('Non-voter count updated:', data);

                    // Check if the updated hall matches the authenticated user's hall
                    if (data.hall === "{{ auth()->user()->hall }}") {
                        // Update the non-voter count
                        document.getElementById('non-voter-count-number').textContent = data.nonVoterCount;
                    }
                });

            // Listen for the 'voter.skipped.updated' event
            window.Echo.channel('strongrooms')
                .listen('.voter.skipped.updated', (data) => {
                    console.log('voter.skipped.updated:', data);

                    // Check if the updated hall matches the authenticated user's hall
                    if (data.hall === "{{ auth()->user()->hall }}") {
                        // Update the skipped vote count
                        document.getElementById('skippedVotes').textContent = data.skippedCount;
                    }
                });

            // Listen for the 'VoteUpdated' event
            window.Echo.channel('strongrooms')
                .listen('.VoteUpdated', (data) => {
                    console.log('Vote updated:', data);

                    // Find the candidate's vote count element and update it
                    const voteCountElement = document.getElementById(`vote-count-${data.candidateId}`);
                    if (voteCountElement) {
                        voteCountElement.textContent = data.voteCount;
                    }
                });

                // Listen for the 'pollStatus' event
                // window.Echo.channel('strongrooms')
                //     .listen('.poll.updated', (data) => {
                //         console.log('Poll Updated:', data);

                //         if (data.status === 'complete') {
                //             if (data.role === 'admin') {
                //                 window.location.href = '/admin-result';
                //             } else if (data.role === 'moderator') {
                //                 window.location.href = '/result';
                //             } 
                //         }
                //     });
        });

    </script>
</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth