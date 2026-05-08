<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Strong Room</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .swiper-container {
            padding: 30px 0;
        }

        .swiper-slide {
            opacity: 0.5;
            transform: scale(0.9);
            transition: all 0.3s ease;
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
<body class="bg-gray-100 p-6">

<div class="bg-gray-100 p-6 rounded-xl">
        <h2 class="text-4xl font-bold text-[#1C204B] my-4">Strong Room</h2>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Voters Card -->
            <div class="bg-[#1C204B] rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:shadow-xl">
                <div class="p-5">
                    <p class="text-gray-300 text-sm font-medium mb-1"> Total Voters</p>
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
                    <p class="text-gray-300 text-sm font-medium mb-1">Total Votes</p>
                    <div class="flex items-center justify-between">
                        <h2 class="text-4xl font-bold text-white" id="non-voter-count-number">{{ $totalVotes }}</h2>
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
                        <h2 class="text-4xl font-bold text-white" id="skippedVotes">{{ $skippedVoters }}</h2>
                        <svg class="w-10 h-10 text-indigo-400 opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    
    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        
    </div>

    <!-- SWIPER CANDIDATE DISPLAY -->
    @if ($poll_special)
    <div class="swiper swiper-container relative w-full h-auto">
        <div class="swiper-wrapper">
            @foreach($candidates->groupBy('portfolio_id') as $portfolioId => $portfolioCandidates)
                @php
                    $portfolio = \App\Models\portfolios::find($portfolioId);
                    if ($portfolioCandidates->isEmpty()) continue;
                @endphp

                <div class="swiper-slide bg-white rounded-xl shadow-md p-6" data-election-type="{{ strtolower($portfolio->election_type ?? '') }}">
                    <div class="bg-[#1C204B] text-white p-4 rounded-t-xl">
                        <h2 class="text-xl font-bold">{{ $portfolio->name }}</h2>
                    </div>

                    <div class="w-full flex justify-center">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6 mt-4">
                            @foreach($portfolioCandidates as $candidate)
                            <div class="border border-gray-200 rounded-xl overflow-hidden shadow hover:shadow-lg transition-all">
                                <img src="{{ asset('storage/' . $candidate->image_path) }}" alt="Candidate Image" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="font-bold text-[#1C204B]">{{ $candidate->team_name }}</h3>
                                    <p class="text-gray-600 italic text-sm">{{ $candidate->teaser }}</p>
                                    <div class="mt-2 flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-700">Votes</span>
                                        <span class="text-lg font-bold text-[#1C204B]" id="vote-count-{{ $candidate->id }}">
                                            {{ $candidate->votes()->count() }}
                                        </span>
                                    </div>
                                    {{-- make progress bar based on the total votes per candidate --}}
                                    <div>
                                            @php
                                                $totalVotesForCandidate = $candidate->votes()->count();
                                                $votePercentage = $totalVotes > 0 ? ($totalVotesForCandidate / $totalVotes) * 100 : 0;
                                            @endphp
                                            <div class="bg-gray-100 h-2.5 rounded-full mt-2">
                                                <div class="bg-indigo-600 h-full rounded-full" style="width: {{ $votePercentage }}%"></div>
                                            </div>
                                    </div>
                                    {{-- <div class="bg-gray-100 h-2.5 rounded-full mt-2">
                                        <div class="bg-indigo-600 h-full rounded-full" style="width: 45%"></div>
                                    </div> --}}
                                </div>
                            </div>
                            @endforeach
                            @php
                            // count skipped votes foreach portfolio
                            $portfolioVotes = $portfolioCandidates->sum(fn($c) => $c->votes()->count());
                            $totalSkipped = $totalVotes - $portfolioVotes;
                            @endphp
                            <div class="border border-gray-200 rounded-xl overflow-hidden shadow hover:shadow-lg transition-all">
                                <img src="{{ asset('/images/ZLfvzpbgLl0BtUYRwzsiqBtZR8quIEKazQ58FcGZ.jpg') }}" alt="Candidate Image" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="font-bold text-[#1C204B]">SKIPPED VOTES</h3>
                                    <p class="text-gray-600 italic text-sm">SKIPPED</p>
                                    <div class="mt-2 flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-700">Votes</span>
                                        <span class="text-lg font-bold text-[#1C204B]" id="vote-count-{{ $totalSkipped }}">
                                            {{ $totalSkipped }}
                                        </span>
                                    </div>
                                    <div>
                                            @php
                                                $totalVotesForCandidate = $totalSkipped;
                                                $votePercentage = $totalVotes > 0 ? ($totalVotesForCandidate / $totalVotes) * 100 : 0;
                                            @endphp
                                            <div class="bg-gray-100 h-2.5 rounded-full mt-2">
                                                <div class="bg-indigo-600 h-full rounded-full" style="width: {{ $votePercentage }}%"></div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
    @endif

    <!-- Swiper + Real-time Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        let swiper;

        function initializeSwiper() {
            if (swiper) swiper.destroy(true, true);
            swiper = new Swiper('.swiper-container', {
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                speed: 800,
                slidesPerView: 1,
                centeredSlides: true,
                spaceBetween: 30,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initializeSwiper();

            // Real-time events (Laravel Echo)
            window.Echo.channel('strongrooms')
                .listen('.user.logged.in', (data) => {
                    if (data.hall === {!! json_encode(auth()->user()->hall) !!}) {
                        console.log("User logged in:", data);
                        // add UI changes if needed
                    }
                })
                .listen('.user.logged.out', (data) => {
                    if (data.hall === {!! json_encode(auth()->user()->hall) !!}) {
                        console.log("User logged out:", data);
                        // remove from UI if needed
                    }
                })
                .listen('.voter.count.updated', (data) => {
                    if (data.hall === {!! json_encode(auth()->user()->hall) !!}) {
                        document.getElementById('voter-count-number').textContent = data.voterCount;
                    }
                })
                .listen('.non.voter.count.updated', (data) => {
                    if (data.hall === {!! json_encode(auth()->user()->hall) !!}) {
                        document.getElementById('non-voter-count-number').textContent = data.nonVoterCount;
                    }
                })
                .listen('.voter.skipped.updated', (data) => {
                    if (data.hall === {!! json_encode(auth()->user()->hall) !!}) {
                        document.getElementById('skippedVotes').textContent = data.skippedCount;
                    }
                })
                .listen('.VoteUpdated', (data) => {
                    const el = document.getElementById(`vote-count-${data.candidateId}`);
                    if (el) el.textContent = data.voteCount;
                });
        });
    </script>

</body>
</html>
