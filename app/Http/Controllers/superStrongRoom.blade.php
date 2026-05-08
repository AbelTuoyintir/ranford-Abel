<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Super Strong Room</title>
   

    @vite(["resources/css/app.css","resources/js/app.js"])
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> --}}
        <style>
            .swiper-container {
                padding: 30px 0;
            }
            
            .swiper-slide {
                opacity: 0.5;
                transition: all 0.3s ease;
                transform: scale(0.9);
                height: auto !important;
            }
            
            .swiper-slide-active {
                opacity: 1;
                transform: scale(1);
            }
            
            .swiper-button-next,
            .swiper-button-prev {
                color: #1C204B;
                background: rgba(255, 255, 255, 0.8);
                padding: 20px;
                border-radius: 50%;
                backdrop-filter: blur(5px);
            }
            
            .swiper-pagination-bullet {
                background: #1C204B;
                opacity: 0.5;
                width: 12px;
                height: 12px;
            }
            
            .swiper-pagination-bullet-active {
                opacity: 1;
                background: #1C204B;
            }
            </style>
    
</head>
<body>   
       <div class="bg-gray-100 p-6 rounded-xl">
        <h2 class="text-4xl font-bold text-[#1C204B] my-4">Super Strong Room</h2>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Voters Card -->
            <div class="bg-[#1C204B] rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:shadow-xl">
                <div class="p-5">
                    <p class="text-gray-300 text-sm font-medium mb-1">Voters</p>
                    <div class="flex items-center justify-between">
                        <h2 class="text-4xl font-bold text-white" id="voter-count-number">{{ $totalVoters }}</h2>
                        <svg class="w-10 h-10 text-indigo-400 opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Non Voters Card -->
            <div class="bg-[#1C204B] rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:shadow-xl">
                <div class="p-5">
                    <p class="text-gray-300 text-sm font-medium mb-1">Non Voters</p>
                    <div class="flex items-center justify-between">
                        <h2 class="text-4xl font-bold text-white" id="non-voter-count-number">0000</h2>
                        <svg class="w-10 h-10 text-indigo-400 opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Total Candidates Card -->
            <div class="bg-[#1C204B] rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:shadow-xl">
                <div class="p-5">
                    <p class="text-gray-300 text-sm font-medium mb-1">Total Candidates</p>
                    <div class="flex items-center justify-between">
                        <h2 class="text-4xl font-bold text-white">{{ $totalCandidate }}</h2>
                        <svg class="w-10 h-10 text-indigo-400 opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Skip Votes Card -->
            <div class="bg-[#1C204B] rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:shadow-xl">
                <div class="p-5">
                    <p class="text-gray-300 text-sm font-medium mb-1">Skip Votes</p>
                    <div class="flex items-center justify-between">
                        <h2 class="text-4xl font-bold text-white" id="skippedVotes">0000</h2>
                        <svg class="w-10 h-10 text-indigo-400 opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Navigation Header -->
        <div class="sticky top-0 bg-white shadow-md rounded-xl p-4 mb-6 z-10">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h1 class="text-[#1C204B] font-bold text-2xl flex items-center">
                    <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    {{ auth()->user()->hall }}
                </h1>
                {{-- <select id="electionTypeFilter" class="p-3 bg-gray-100 border border-gray-300 text-[#1C204B] font-medium rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="">ALL ELECTIONS</option>
                    <option value="general">GENERAL ELECTION</option>
                    <option value="department">DEPARTMENT ELECTION</option>
                    <option value="hall">HALL ELECTION</option>
                    <option value="special">SPECIAL ELECTION</option>
                </select> --}}
            </div>
        </div>
        @foreach($candidates->groupBy('portfolio_id') as $portfolioId => $portfolioCandidates)
    @php
        $portfolio = \App\Models\portfolios::find($portfolioId);

        if ($portfolioCandidates->isEmpty()) continue;

        // Filter to only 'UCC General Election' and 'Department Election'
        $allowedTypes = ['ucc general election', 'department election'];
        if (!in_array(strtolower($portfolio->election_type), $allowedTypes)) continue;
    @endphp

    <div class="swiper-slide bg-white rounded-xl shadow-md overflow-hidden" data-election-type="{{ strtolower($portfolio->election_type) }}">
        <!-- Portfolio Header -->
        <div class="bg-[#1C204B] px-6 py-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-red-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.86L12 17.77l-6.18 3.23L7 14.14l-5-4.87 6.91-1.01L12 2z"/>
                </svg>
                <h2 class="text-2xl font-bold text-white">{{ $portfolio->name }}</h2>
            </div>
        </div>

        <!-- Candidates -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($portfolioCandidates as $candidate)
                <div class="transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="bg-white rounded-xl overflow-hidden shadow-md h-full flex flex-col border border-gray-200">
                        <!-- Candidate Image -->
                        <div class="relative">
                            <img src="{{ asset('storage/' . $candidate->image_path) }}" alt="{{ $candidate->team_name }}" 
                                class="h-48 w-full object-cover">
                            <!-- Ballot Number Badge -->
                            <div class="absolute top-3 right-3 bg-[#1C204B] text-white font-bold px-3 py-1 rounded-full shadow">
                                #{{ $candidate->ballot_number }}
                            </div>
                        </div>
                        <!-- Candidate Info -->
                        <div class="p-4 flex-grow">
                            <div class="mb-4">
                                <h3 class="font-bold text-xl text-[#1C204B] mb-1">{{ $candidate->team_name }}</h3>
                                <p class="text-gray-600 italic text-sm">{{ $candidate->teaser }}</p>
                            </div>
                            
                            <!-- Vote Metrics -->
                            <div class="mt-auto">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-700 font-medium">Total Votes</span>
                                    <span class="text-2xl font-bold text-[#1C204B]" id="vote-count-{{ $candidate->id }}">
                                        {{ $candidate->votes()->count()}}
                                    </span>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 h-full rounded-full" 
                                        style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach

       
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            window.addEventListener('DOMContentLoaded', function () {
                // ============================ Realtime Event Listeners ============================
        
                // 1. User Logged In
                window.Echo.channel('strongrooms')
                    .listen('.user.logged.in', (data) => {
                        console.log('User logged in:', data);
        
                        if (data.hall === {!! json_encode(auth()->user()->hall) !!}) {
                            const voterCard = document.createElement('div');
                            voterCard.className = 'w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px]';
                            voterCard.id = `voter-${data.schoolId}`;
                            voterCard.innerHTML = `
                                <div class="flex-1 h-[240px] bg-white rounded-md">
                                    <img src="${data.image}" alt="voter-image" class="w-auto mx-auto h-[140px]" />
                                </div>
                                <h1 class="text-white p-3 text-bold text-center bg-[#22296F] rounded-lg">
                                    ${data.schoolId}
                                </h1>
                            `;
                            document.getElementById('real-time-voters').appendChild(voterCard);
                        }
                    });
        
                // 2. User Logged Out
                window.Echo.channel('strongrooms')
                    .listen('.user.logged.out', (data) => {
                        console.log('User logged out:', data);
        
                        if (data.hall === "{{ auth()->user()->hall }}") {
                            const voterCard = document.getElementById(`voter-${data.schoolId}`);
                            if (voterCard) {
                                voterCard.remove();
                            }
                        }
                    });
        
                // 3. Voter Count Updated
                window.Echo.channel('strongrooms')
                    .listen('.voter.count.updated', (data) => {
                        console.log('Voter count updated:', data);
        
                        if (data.hall === "{{ auth()->user()->hall }}") {
                            document.getElementById('voter-count-number').textContent = data.voterCount;
                        }
                    });
        
                // 4. Non-voter Count Updated
                window.Echo.channel('strongrooms')
                    .listen('.non.voter.count.updated', (data) => {
                        console.log('Non-voter count updated:', data);
        
                        if (data.hall === "{{ auth()->user()->hall }}") {
                            document.getElementById('non-voter-count-number').textContent = data.nonVoterCount;
                        }
                    });
        
                // 5. Skipped Votes Updated
                window.Echo.channel('strongrooms')
                    .listen('.voter.skipped.updated', (data) => {
                        console.log('Skipped votes updated:', data);
        
                        if (data.hall === "{{ auth()->user()->hall }}") {
                            document.getElementById('skippedVotes').textContent = data.skippedCount;
                        }
                    });
        
                // 6. Vote Count for Candidate Updated
                window.Echo.channel('strongrooms')
                    .listen('.VoteUpdated', (data) => {
                        console.log('Vote updated:', data);
        
                        const voteCountElement = document.getElementById(`vote-count-${data.candidateId}`);
                        if (voteCountElement) {
                            voteCountElement.textContent = data.voteCount;
                        }
                    });
        
                // ============================ Swiper Initialization ============================
        
                let swiper;
        
                function initializeSwiper() {
                    swiper = new Swiper('.swiper', {
                        direction: 'horizontal',
                        loop: true,
                        autoplay: {
                            delay: 4000,
                            disableOnInteraction: false,
                        },
                        speed: 800,
                        slidesPerView: 1,
                        spaceBetween: 30,
                        centeredSlides: true,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        observer: true,
                        observeParents: true,
                    });
                }
        
                initializeSwiper();
        
                // ============================ Filter Swiper Slides ============================
        
                document.getElementById('electionTypeFilter').addEventListener('change', function () {
                    const selectedType = this.value.toLowerCase();
        
                    document.querySelectorAll('.swiper-slide').forEach(slide => {
                        const slideType = slide.dataset.electionType;
                        if (selectedType === '' || slideType === selectedType) {
                            slide.classList.remove('hidden');
                        } else {
                            slide.classList.add('hidden');
                        }
                    });
        
                    // Refresh Swiper layout
                    swiper.update();
                });
            });
           
    </script>
</body>
</html>