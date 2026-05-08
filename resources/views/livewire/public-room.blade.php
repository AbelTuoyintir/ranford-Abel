<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-VOTE</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class="rounded-full w-16 h-16">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- Tailwind + Your App CSS -->
    @vite(["resources/css/app.css", "resources/js/app.js"])

    <style>
        .swiper {
            width: 100%;
            padding: 20px 0;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: start;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Stats -->
    <div class="grid grid-cols-4 gap-3 m-2">
        @php
            $stats = [
                ['id' => 'voter-count-number', 'label' => 'Voters'],
                ['id' => 'non-voter-count-number', 'label' => 'Non Voters'],
                ['id' => null, 'label' => 'Total candidate', 'value' => $totalCandidate],
                ['id' => 'skippedVotes', 'label' => 'Skip votes'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="w-full h-[80px] bg-[#1C204B] rounded-lg cursor-pointer overflow-hidden">
                <div class="p-4 rounded-lg relative -top-2 grid gap-1">
                    <div class="text-4xl font-semibold mb-0 text-white" id="{{ $stat['id'] ?? '' }}">
                        {{ $stat['value'] ?? '0000' }}
                    </div>
                    <p class="text-sm text-gray-200">{{ $stat['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Navigation + Election Type -->
    <nav class="sticky top-0 bg-gray-50 z-50 flex items-center justify-between p-3">
        <h1 class="text-[#000] font-bold text-3xl">
            <i class="fa-solid fa-hotel"></i> {{ auth()->user()->hall }}
        </h1>
        <select class="p-3 bg-gray-200 outline-none rounded-lg">
            <option value="">GENERAL ELECTION</option>
            <option value="">DEPARTMENT ELECTION</option>
            <option value="">HALL ELECTION</option>
            <option value="">SPECIAL ELECTION</option>
        </select>
    </nav>

    <!-- Swiper Portfolio Slider -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach($candidates->groupBy('portfolio_id') as $portfolioId => $candidatesGroup)
                @php
                    $portfolio = \App\Models\portfolios::find($portfolioId);
                @endphp
                <div class="swiper-slide">
                    <div class="p-4 w-full max-w-screen-xl mx-auto">
                        <div class="flex items-center mb-4">
                            <svg class="w-10 h-10 mr-4 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.86L12 17.77l-6.18 3.23L7 14.14l-5-4.87 6.91-1.01L12 2z"/>
                            </svg>
                            <h2 class="text-3xl font-bold text-red-600">{{ $portfolio->name }}</h2>
                        </div>

                        <div class="flex flex-wrap justify-center gap-5">
                            @foreach($candidatesGroup as $candidate)
                                <div class="rounded-lg shadow-lg p-3 text-white space-y-3 bg-white max-w-[250px] w-[250px]">
                                    <img src="{{ asset('storage/' . $candidate->image_path) }}" alt="candidate image" class="h-[200px] w-full object-cover bg-gray-200 rounded-md">
                                    <div class="p-2 bg-blue-200 rounded-md flex items-center justify-between text-black">
                                        <h1 class="font-bold text-2xl text-blue-950">{{ str_replace(' ', '', $candidate->team_name) }}</h1>
                                    </div>
                                    <div class="text-black">
                                        <h1 class="text-lg font-bold">Total</h1>
                                        <h1 class="text-gray-600 mb-4 text-xl font-medium" id="vote-count-{{ $candidate->id }}">
                                            {{ $candidate->votes()->count() }}
                                        </h1>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 rounded-full w-[45%] h-full"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Swiper Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Halls Tabs -->
    <div class="px-2">
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-700 dark:text-gray-400">
            @php
                $halls = ['CASFORD', 'VALCO', 'KNH', 'OGUAA', 'ADEHYE', 'ATL', 'SRC', 'SUPERNUATION', 'VALCO-TRUST', 'UNIVERSITY HALL'];
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

    <!-- Live Voter Section -->
    <div class="p-4 bg-white rounded-lg shadow-xl my-6 mx-3 mb-4">
        <h1 class="text-xl font-bold text-gray-600 mb-4">Current Voters</h1>
        <div class="grid grid-cols-10 gap-2" id="real-time-voters">
            <!-- Live voters added here -->
        </div>
    </div>

    <!-- Swiper + Real-Time Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        document.addEventListener('DOMContentLoaded', function () {
            window.Echo.channel('strongrooms')
                .listen('.user.logged.in', (data) => {
                    if (data.hall === "{{ auth()->user()->hall }}") {
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
                })
                .listen('.user.logged.out', (data) => {
                    if (data.hall === "{{ auth()->user()->hall }}") {
                        const voterCard = document.getElementById(`voter-${data.schoolId}`);
                        if (voterCard) voterCard.remove();
                    }
                })
                .listen('.non.voter.count.updated', (data) => {
                    if (data.hall === "{{ auth()->user()->hall }}") {
                        document.getElementById('non-voter-count-number').textContent = data.nonVoterCount;
                    }
                })
                .listen('.voter.skipped.updated', (data) => {
                    if (data.hall === "{{ auth()->user()->hall }}") {
                        document.getElementById('skippedVotes').textContent = data.skippedCount;
                    }
                });
        });
    </script>
</body>
</html>
