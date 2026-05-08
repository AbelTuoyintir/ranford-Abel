@auth
<x-admin-sidebar>
    {{-- <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 rounded-lg shadow-lg mb-6">
        <h1 class="text-white font-bold text-3xl mb-2 text-center flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
            Voting Statistics Dashboard
        </h1>
        <p class="text-indigo-100 text-center opacity-80">Real-time election results and analytics</p>
    </div> --}}

    <!-- Timer Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-800">Time Remaining</h2>
            </div>
            <div class="bg-gradient-to-r from-red-500 to-pink-500 rounded-lg px-4 py-3 text-white shadow-md">
                <div class="flex items-center text-2xl font-bold" id="countdown">
                    <span id="countdown-timer">00:00:00</span>
                </div>
            </div>
        </div>

        <!-- Progress bar for time remaining -->
        <div class="mt-4 h-2 w-full bg-gray-200 rounded-full overflow-hidden">
            <div id="timer-progress" class="h-full bg-indigo-600 rounded-full" style="width: 65%;"></div>
        </div>
    </div>
    
    <!-- Loop through each poll type -->
    @foreach($GroupedPollData as $pollType => $polls)
        <div class="mb-10">
            <div class="flex items-center mb-6">
                <div class="w-1/4 h-px bg-gray-300"></div>
                <h2 class="text-l font-bold text-white px-4">{{ $pollType }}</h2>
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach($polls as $poll)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="relative">
                          @if($pollType == 'UCC GENERAL VOTING')
                          <img src="{{ asset('images/ucc_general_voting.jpg') }}" alt="UCC General Voting Image" class="w-full h-48 object-cover">
                      @elseif($pollType == 'HALL')
                          <img src="{{ asset('images/hall.jpg') }}" alt="Hall Image" class="w-full h-48 object-cover">
                      @elseif($pollType == 'DEPARTMENT')
                          <img src="{{ asset('images/department.jpg') }}" alt="Department Image" class="w-full h-48 object-cover">
                      @elseif($pollType == 'SPECIAL VOTING')
                          <img src="{{ asset('images/special_voting.jpg') }}" alt="Special Voting Image" class="w-full h-48 object-cover">
                      @else
                          <img src="{{ asset('images/default.jpg') }}" alt="Default Image" class="w-full h-48 object-cover">
                      @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="flex items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-indigo-300" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 2H5C3.9 2 3 2.9 3 4V18C3 19.1 3.9 20 5 20H9L12 23L15 20H19C20.1 20 21 19.1 21 18V4C21 2.9 20.1 2 19 2ZM13 18H11V16H13V18ZM15.07 10.25L14.17 11.17C13.45 11.9 13 12.5 13 14H11V13.5C11 12.4 11.45 11.4 12.17 10.67L13.41 9.41C13.78 9.05 14 8.55 14 8C14 6.9 13.1 6 12 6C10.9 6 10 6.9 10 8H8C8 5.79 9.79 4 12 4C14.21 4 16 5.79 16 8C16 8.88 15.64 9.68 15.07 10.25Z"/>
                                    </svg>
                                    <h3 class="text-xl  font-bold">{{ $poll->title }}</h3>
                                </div>
                                <p class="text-gray-300 text-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    {{ $poll->candidates->flatten()->count() }} Candidates
                                </p>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-semibold text-gray-800">Voting Summary</h4>
                                <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    Live Results
                                </span>
                            </div>
                            
                            <div class="space-y-3 max-h-72 overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-500 scrollbar-track-gray-200"> 
                                <div x-data="{ open: null }">
                                    @foreach($poll->candidates as $portfolio => $candidates)
                                        <div class="mb-3 border border-gray-200 rounded-lg">
                                            <button 
                                                @click="open = open === '{{ $portfolio }}' ? null : '{{ $portfolio }}'" 
                                                class="flex items-center justify-between w-full p-4 font-medium text-left text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-t-lg transition duration-200"
                                            >
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                        <circle cx="8.5" cy="7" r="4"></circle>
                                                        <path d="M20 8v6M23 11h-6"></path>
                                                    </svg>
                                                    {{ $portfolio }}
                                                </span>
                                                <svg 
                                                    :class="open === '{{ $portfolio }}' ? 'rotate-180' : ''" 
                                                    class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            
                                            <div x-show="open === '{{ $portfolio }}'" class="p-4 bg-white rounded-b-lg">
                                                @foreach($candidates as $candidate)
                                                    <div class="mb-4 last:mb-0">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <p class="text-sm font-medium text-gray-700">{{ $candidate->team_name }}</p>
                                                            <span class="text-xs font-medium px-2 py-1 rounded {{ $candidate->vote_status == 'Leading' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                                {{ $candidate->vote_status }}
                                                            </span>
                                                        </div>
                                                        
                                                        <div class="flex items-stretch bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                                            <!-- Candidate Image -->
                                                            <img class="object-cover w-1/3 h-24" src="{{ asset('storage/'. $candidate->image_path) }}" alt="{{ $candidate->name }}">
                                                            
                                                            <!-- Vote Information -->
                                                            <div class="flex flex-col justify-center p-3 flex-1">
                                                                <div class="flex items-end justify-between">
                                                                    <div>
                                                                        <div class="text-3xl font-bold text-gray-900">{{ $candidate->votes }}</div>
                                                                        <div class="text-sm text-gray-500">votes</div>
                                                                    </div>
                                                                    <!-- Vote percentage visualization -->
                                                                    <div class="w-16 h-16 relative">
                                                                        <svg viewBox="0 0 36 36" class="w-full h-full">
                                                                            <path
                                                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                                fill="none"
                                                                                stroke="#E5E7EB"
                                                                                stroke-width="3"
                                                                            />
                                                                            <path
                                                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                                fill="none"
                                                                                stroke="{{ $candidate->vote_status == 'Leading' ? '#10B981' : '#6366F1' }}"
                                                                                stroke-width="3"
                                                                                stroke-dasharray="{{ min(($candidate->votes / max($poll->candidates->flatten()->sum('votes'), 1)) * 100, 100) }}, 100"
                                                                            />
                                                                        </svg>
                                                                        <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center text-xs font-medium">
                                                                            {{ round(($candidate->votes / max($poll->candidates->flatten()->sum('votes'), 1)) * 100) }}%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Total votes indicator -->
                            <div class="mt-6 flex items-center justify-center">
                                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full px-6 py-2 shadow-md text-lg font-semibold">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        Total Votes: {{ $poll->candidates->flatten()->sum('votes') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    
    <!-- Footer stats -->
    <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-indigo-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Voters</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-voters">0</p>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Voter Turnout</p>
                        <p class="text-2xl font-bold text-gray-900" id="voter-turnout">0%</p>
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Election Status</p>
                        <p class="text-2xl font-bold text-gray-900">In Progress</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-sidebar>

<!-- Countdown Timer Script -->
<script>
    // Set the end time for the countdown
    const endTime = new Date().getTime();
    
    // Calculate total election duration for progress bar
    const startTime = new Date().getTime(); // Assuming election is ongoing
    const totalDuration = endTime - startTime;
    
    // Update the countdown every second
    const countdownTimer = setInterval(() => {
        const now = new Date().getTime();
        const timeLeft = endTime - now;
        
        // Calculate time components
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
        
        // Display the countdown
        const displayText = days > 0 
            ? `${days}d ${hours}h ${minutes}m ${seconds}s`
            : `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        
        document.getElementById("countdown-timer").innerHTML = displayText;
        
        // Update progress bar
        const percentageLeft = (timeLeft / totalDuration) * 100;
        const percentageComplete = 100 - percentageLeft;
        document.getElementById("timer-progress").style.width = `${percentageComplete}%`;
        
        // If the countdown is over
        if (timeLeft < 0) {
            clearInterval(countdownTimer);
            document.getElementById("countdown-timer").innerHTML = "Election Ended";
            document.getElementById("timer-progress").style.width = "100%";
        }
    }, 1000);
    
    // For demonstration purposes - calculate some dummy stats
    // In a real application, these would come from your backend
    document.addEventListener("DOMContentLoaded", function() {
        // Sum all votes across all polls
        let totalVotes = 0;
        @foreach($GroupedPollData as $pollType => $polls)
            @foreach($polls as $poll)
                totalVotes += {{ $poll->candidates->flatten()->sum('votes') }};
            @endforeach
        @endforeach
        
        // Set some example values
        const totalVoters = totalVotes * 1.2; // Example: assume this is 120% of current votes
        document.getElementById("total-voters").textContent = Math.round(totalVoters).toLocaleString();
        
        const voterTurnout = (totalVotes / totalVoters) * 100;
        document.getElementById("voter-turnout").textContent = `${Math.round(voterTurnout)}%`;
    });
</script>

@else
<script>
    window.location.href = "{{ route('/student') }}";
</script>
@endauth