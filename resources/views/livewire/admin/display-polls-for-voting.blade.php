@auth
<x-admin-sidebar>
    <body class="bg-gray-800 p-3 flex mt-24">
        <div class="w-full p-4">
            <div class="flex flex-wrap gap-4">
                @php
                    $displayedPollTypes = collect();
                    $hasActivePoll = false;
                    
                    // Filter polls that are valid for this user
                    $filteredPolls = collect();
                    
                    foreach ($polls as $poll) {
                        if ($poll->status !== 'active') continue;
                        
                        // Check if this poll matches user's criteria
                        $showPoll = false;
                        
                        // Department check
                        if ($poll->poll_type === 'DEPARTMENT' && 
                            $poll->pollSettings && 
                            $poll->pollSettings->querystring === auth()->user()->Programs) {
                            $showPoll = true;
                        }
                        // Special Voting check
                        elseif ($poll->poll_type === 'SPECIAL VOTING' && auth()->user()->type === 'staff') {
                            if ($poll->pollSettings) {
                                $pollGroups = explode(' ', $poll->pollSettings->querystring);
                                $userGroups = explode(' ', auth()->user()->Programs);
                                $hasAccess = collect($userGroups)->every(fn($group) => in_array($group, $pollGroups));
                                $showPoll = $hasAccess;
                            }
                        }
                        // General Election check
                        elseif ($poll->poll_type === 'UCC GENERAL VOTING' && auth()->user()->type === 'student') {
                            $showPoll = true;
                        }
                        // Hall check
                        elseif ($poll->poll_type === 'HALL' && 
                               $poll->pollSettings && 
                               auth()->user()->type === 'student' && 
                               strtoupper(trim($poll->pollSettings->querystring)) === strtoupper(trim(auth()->user()->hall))) {
                            $showPoll = true;
                        }
                        
                        if ($showPoll) {
                            $filteredPolls->push($poll);
                        }
                    }
                    
                    // Now group by poll type to ensure we only show one per type
                    $groupedPolls = $filteredPolls->groupBy('poll_type');
                @endphp
                
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
                    setTimeout(() => {
                        document.querySelectorAll('.bg-green-500, .bg-red-500').forEach((message) => {
                            message.classList.add('animate-fadeOut');
                            setTimeout(() => message.remove(), 500);
                        });
                    }, 5000);
                </script>
                @endif
                
                @foreach ($groupedPolls as $pollType => $pollsOfType)
                    @php
                        // Take the first poll of this type (we'll only display one card per type)
                        $poll = $pollsOfType->first();
                        $hasActivePoll = true;
                    @endphp

                    <!-- Department Card -->
                    @if ($pollType === 'DEPARTMENT')
                        <div class="w-full sm:w-1/3 md:w-1/4 lg:w-1/5">
                            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <a href="{{ route('/voter', ['poll_type' => $poll->poll_type]) }}" class="block">
                                    <div class="relative">
                                        <img src="{{ asset('images/department.jpg') }}" alt="department" class="w-full h-36 object-cover rounded-t-lg">
                                        <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full shadow-md flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M7 20l8-16 8 16M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-xs font-medium text-gray-800">Department</span>
                                        </div>
                                    </div>                           
                                    <div class="p-4">
                                        <h2 class="text-base font-semibold text-gray-800">Department Election</h2>
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                                        <div class="space-y-2 mt-2">
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <p class="text-sm">Vote for your department representative.</p>
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2zm10 2v10m-4-10v10M9 9v10" />
                                                </svg>
                                                <p class="text-sm">Ends on: {{ $poll->end_time }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Special Voting Card -->
                    @if ($pollType === 'SPECIAL VOTING')
                        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <a href="{{ route('/voter', ['poll_type' => $poll->poll_type]) }}" class="block">
                                    <div class="relative">
                                        <img src="{{ asset('images/special_voting.jpg') }}" alt="special voting" class="w-full h-36 object-cover rounded-t-lg">
                                        <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full shadow-md flex items-center gap-2">
                                            <svg class="w-4 h-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            <span class="text-xs font-medium text-gray-800">Special Voting</span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h2 class="text-base font-semibold text-gray-800">Special Voting</h2>
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                                        <div class="space-y-2 mt-2">
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <p class="text-sm">Vote for special committee members.</p>
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2zm10 2v10m-4-10v10M9 9v10" />
                                                </svg>
                                                <p class="text-sm">Ends on: {{ $poll->end_time }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a> 
                            </div>
                        </div>
                    @endif

                    <!-- General Election Card -->
                    @if ($pollType === 'UCC GENERAL VOTING')
                        <div class="w-full sm:w-1/3 md:w-1/4 lg:w-1/5">
                            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <a href="{{ route('/voter', ['poll_type' => $poll->poll_type]) }}" class="block">
                                    <div class="relative">
                                        <img src="{{ asset('images/ucc_general_voting.jpg') }}" alt="general election" class="w-full h-36 object-cover rounded-t-lg">
                                        <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full shadow-md flex items-center gap-2">
                                            <svg class="w-4 h-4 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            <span class="text-xs font-medium text-gray-800">General Election</span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h2 class="text-base font-semibold text-gray-800">General Election</h2>
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                                        <div class="space-y-2 mt-2">
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <p class="text-sm">Vote for the main leadership positions.</p>
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2zm10 2v10m-4-10v10M9 9v10" />
                                                </svg>
                                                <p class="text-sm">Ends on: {{ $poll->end_time }}</p>
                                            </div>
                                        </div>                                       
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                 
                    <!-- Hall Card -->
                    @if ($pollType === 'HALL')
                        <div class="w-full sm:w-1/3 md:w-1/4 lg:w-1/5">
                            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <a href="{{ route('/voter', ['poll_type' => $poll->poll_type]) }}" class="block">
                                    <div class="relative">
                                        <img src="{{ asset('images/hall.jpg') }}" alt="hall" class="w-full h-36 object-cover rounded-t-lg">
                                        <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full shadow-md flex items-center gap-2">
                                            <svg class="w-4 h-4 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            <span class="text-xs font-medium text-gray-800">Hall</span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h2 class="text-base font-semibold text-gray-800">{{ $poll->title }}</h2>
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                                        <div class="space-y-2 mt-2">
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <p class="text-sm">Vote for your hall representatives.</p>
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2zm10 2v10m-4-10v10M9 9v10" />
                                                </svg>
                                                <p class="text-sm">Ends on: {{ $poll->end_time }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach

                @if (!$hasActivePoll)
                <div class="flex-1 p-8 overflow-auto" style="background-image: url('{{ asset('images/logo60.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-center text-white">
                            <h1 class="text-3xl font-bold mb-2">Elections</h1>
                            <p class="text-blue-100">Choose Your Future Leader</p>
                        </div>
                        <div class="p-8 text-center mt-16">
                            <img src="{{ asset('images/voting.svg') }}" alt="Voting Not Available" class="w-100 h-80 mx-auto mb-4">
                            <h2 class="text-2xl font-bold text-blue-900 mb-2">Voting isn't available now</h2>
                            <p class="text-gray-600">Please check back later for the election.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </body>
</x-admin-sidebar>
@else
<script>
    window.location.href = "{{ route('/student') }}";
</script>
@endauth