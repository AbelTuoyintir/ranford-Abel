<x-admin-sidebar>
	<style>
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
    <div>
        
	 
	 <div class="bg-gray-100">
		
		<div class="p-4  rounded-lg ">
			@php
				$endTime = isset($poll) ? \Carbon\Carbon::parse($poll->end_time)->timestamp * 1000 : 0;
				$startTime = isset($poll) ? \Carbon\Carbon::parse($poll->start_time)->timestamp * 1000 : 0;

				//votes count per hall
				$casfordVotes =  $hallVoterCounts['CASFORD'] ?? 00;
    			$valcoVotes =  $hallVoterCounts['VALCO'] ?? 00;
				$KNHVotes = $hallVoterCounts['KNHALL'] ?? 00;
				$oguaaVotes =  $hallVoterCounts['OGUAA'] ?? 00;
				$adehyeVotes =  $hallVoterCounts['ADEHYE'] ?? 00;
				$atlVotes =$hallVoterCounts['ATLANTIC'] ?? 00;
				$srcVotes = $hallVoterCounts['SRC'] ?? 00;
				$supernuationVotes = $hallVoterCounts['GUSSS'] ?? 00;
				$valcotrustVotes = $hallVoterCounts['VTRUST'] ?? 00;
				$uniVotes = $hallVoterCounts['UHALL'] ?? 00;
				$specialVotesCount = $hallVoterCounts['SPECIAL'] ??00;
			@endphp
			<div class="w-full">
					<div class="w-full max-w-9xl overflow-hidden relative">
						<div class="bg-gray-900 text-white relative overflow-hidden whitespace-nowrap shadow-md">
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
			</div>
			  
			
		   <div class="grid grid-cols-5 gap-5 mb-4 shadow-lg">
            
                <div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
                        <!-- Image Section -->
						<div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
							<img src="{{ asset('images/hall-logo/casford.jpg') }}" alt="" class="w-16 h-16 rounded-lg absolute -rotate-45 right-[-5px]" />
						</div>
						
                    
                        <!-- Card Description -->
                        <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
                            <!-- Card Header -->
                            <div class="flex items-center w-full">
                                <div class="flex-1 text-xl text-blue-900  font-medium">Casford Hall</div>
                                <div class="flex gap-1 mx-auto">
                                    <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                                    <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                                    <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                                </div>
                            </div>
                            
                            <!-- Card Time -->
                            <div class="text-2xl text-black font-semibold" id="CASFORD-votes">{{$casfordVotes}}</div>
                    
                            <!-- Recent Section -->
                            <div class="text-sm text-black leading-none">total voters </div>
                        </div>
					</div>   
                <div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
                    <!-- Image Section -->
                    <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
                        <img src="{{ asset('images/hall-logo/valco.jpg') }}" alt="" class="w-16 h-16 rounded-lg  absolute -rotate-45 right-[-5px]" />
                    </div>
                
                    <!-- Card Description -->
                    <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
                        <!-- Card Header -->
                        <div class="flex items-center w-full">
                            <div class="flex-1 text-xl text-blue-900 font-medium">Valco Hall</div>
                            <div class="flex gap-1 mx-auto">
                                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            </div>
                        </div>
                        
                        <!-- Card Time -->
                        <div class="text-2xl text-black font-semibold" id="VALCO-votes">{{$valcoVotes}}</div>
                
                        <!-- Recent Section -->
                        <div class="text-sm text-black leading-none">total voters </div>
                    </div>	
			
			 </div>

             <div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
                <!-- Image Section -->
                <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
                    <img src="{{ asset('images/hall-logo/knh.jpg') }}" alt="" class="w-16 h-16 rounded-lg  absolute -rotate-45 right-[-5px]" />
                </div>
            
                <!-- Card Description -->
                <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
                    <!-- Card Header -->
                    <div class="flex items-center w-full">
                        <div class="flex-1 text-xl text-blue-900 font-medium">KNH</div>
                        <div class="flex gap-1 mx-auto">
                            <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                        </div>
                    </div>
                    
                    <!-- Card Time -->
                    <div class="text-2xl font-semibold text-black" id="KNH-votes">{{$KNHVotes}}</div>
            
                    <!-- Recent Section -->
                    <div class="text-sm leading-none text-black">total voters </div>
                </div>	
         </div>

         <div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
            <!-- Image Section -->
            <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
                <img src="{{ asset('images/hall-logo/oguaa.jpg') }}" alt="" class="w-16 h-16 rounded-lg absolute -rotate-45 right-[-5px]" />
            </div>
        
            <!-- Card Description -->
            <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
                <!-- Card Header -->
                <div class="flex items-center w-full">
                    <div class="flex-1 text-xl font-medium text-blue-900">Oguaa Hall</div>
                    <div class="flex gap-1 mx-auto">
                        <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                    </div>
                </div>
                
                <!-- Card Time -->
                <div class="text-2xl font-semibold text-black"  id="OGUAA-votes">{{$oguaaVotes}}</div>
        
                <!-- Recent Section -->
                <div class="text-sm leading-none text-black">total voters </div>
            </div>	
     </div>


     <div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
        <!-- Image Section -->
        <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
            <img src="{{ asset('images/hall-logo/adehye.jpg') }}" alt="" class="w-16 h-16 rounded-lg absolute -rotate-45 right-[-5px]" />
        </div>
    
        <!-- Card Description -->
        <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
            <!-- Card Header -->
            <div class="flex items-center w-full">
                <div class="flex-1 text-xl text-blue-900 font-medium">Adehye Hall</div>
                <div class="flex gap-1 mx-auto">
                    <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                    <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                    <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                </div>
            </div>
            
            <!-- Card Time -->
            <div class="text-2xl text-black font-semibold" id="ADEHYE-votes">{{$adehyeVotes}}</div>
    
            <!-- Recent Section -->
            <div class="text-sm text-black leading-none">total voters </div>
        </div>	
 </div>



 <div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
    <!-- Image Section -->
    <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
        <img src="{{ asset('images/hall-logo/atl.jpg') }}" alt="" class="w-16 h-16 rounded-lg  absolute -rotate-45 right-[-5px]" />
    </div>

    <!-- Card Description -->
    <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
        <!-- Card Header -->
        <div class="flex items-center w-full">
            <div class="flex-1 text-xl text-blue-900 font-medium">ATL Hall</div>
            <div class="flex gap-1 mx-auto">
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
            </div>
        </div>
        
        <!-- Card Time -->
        <div class="text-2xl text-black font-semibold" id="ATLANTIC-votes">{{$atlVotes}}</div>

        <!-- Recent Section -->
        <div class="text-sm text-black leading-none">total voters </div>
    </div>	

</div>

<div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
    <!-- Image Section -->
    <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
        <img src="{{ asset('images/hall-logo/Supernuation.jpg') }}" alt="" class="w-16 h-16 rounded-lg  absolute -rotate-45 right-[-5px]" />
    </div>

    <!-- Card Description -->
    <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
        <!-- Card Header -->
        <div class="flex items-center w-full">
            <div class="flex-1 text-xl text-blue-900 font-medium">Supernuation Hall</div>
            <div class="flex gap-1 mx-auto">
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
            </div>
        </div>
        
        <!-- Card Time -->
        <div class="text-2xl text-black font-semibold" id="GUSSS-votes">{{$supernuationVotes}}</div>

        <!-- Recent Section -->
        <div class="text-sm text-black leading-none">total voters </div>
    </div>	

</div>


<div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
    <!-- Image Section -->
    <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
        <img src="{{ asset('images/hall-logo/src.jpg') }}" alt="" class="w-16 h-16 rounded-lg  absolute -rotate-45 right-[-5px]" />
    </div>

    <!-- Card Description -->
    <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
        <!-- Card Header -->
        <div class="flex items-center w-full">
            <div class="flex-1 text-xl text-blue-900 font-medium">SRC Hall</div>
            <div class="flex gap-1 mx-auto">
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
            </div>
        </div>
        
        <!-- Card Time -->
        <div class="text-2xl text-black font-semibold" id="SRC-votes">{{$srcVotes}}</div>

        <!-- Recent Section -->
        <div class="text-sm text-black leading-none">total voters </div>
    </div>	

</div>


<div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
    <!-- Image Section -->
    <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
        <img src="{{ asset('images/IMG_202411319_103428204.png') }}" alt="" class="w-16 h-16 rounded-lg  absolute -rotate-45 right-[-5px]" />
    </div>

    <!-- Card Description -->
    <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
        <!-- Card Header -->
        <div class="flex items-center w-full">
            <div class="flex-1 text-xl text-blue-900 font-medium">University Hall</div>
            <div class="flex gap-1 mx-auto">
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
            </div>
        </div>
        
        <!-- Card Time -->
        <div class="text-2xl text-black font-semibold" id="UHALL-votes">{{$uniVotes}}</div>

        <!-- Recent Section -->
        <div class="text-sm text-black leading-none">total voters </div>
    </div>	

</div>
<div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
    <!-- Image Section -->
    <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
        <img src="{{ asset('images/IMG_202411319_103428204.png') }}" alt="" class="w-16 h-16 rounded-lg  absolute -rotate-45 right-[-5px]" />
    </div>

    <!-- Card Description -->
    <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
        <!-- Card Header -->
        <div class="flex items-center w-full">
            <div class="flex-1 text-xl text-blue-900 font-medium">Valco Trust</div>
            <div class="flex gap-1 mx-auto">
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
            </div>
        </div>
        
        <!-- Card Time -->
        <div class="text-2xl font-semibold text-black" id="VTRUST-votes">{{$valcotrustVotes}}</div>

        <!-- Recent Section -->
        <div class="text-sm leading-none text-black">total voters </div>
    </div>	

</div>
</div>

<div class="my-2 py-2" >
<div class="max-w-4xl mx-auto p-8">
	<div class="group cursor-pointer">
		<div class="flex items-center">
			<!-- Left line -->
			<div class="flex-grow border-t-2 border-blue-30 mx-5 
					   transition-colors "></div>
			
			<!-- Title text -->
			<span class="text-2xl font-semibold uppercase tracking-wide 
						text-blue-900 transition-colors ">
				Special Election
			</span>
			
			<!-- Right line -->
			<div class="flex-grow border-t-2 border-blue-300 mx-5 
					   transition-colors "></div>
		</div>
	</div>
</div>
<div class="w-full overflow-x-auto pb-3">
    <div class="flex flex-nowrap justify-center gap-5 mx-auto mb-4 shadow-lg" style="max-width: fit-content;">
        {{-- card for staff election --}}
      
            
                <div class="card w-[330px] h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white flex-shrink-0">
                    <!-- Image Section -->
                    <div class="relative overflow-hidden transition-transform duration-200 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] bg-[#142482] rounded-t-[10px] transform translate-y-4 hover:translate-y-0">
                        <img src="{{ asset('images/IMG_202411319_103428204.png') }}" alt="" class="w-16 h-16 rounded-lg absolute -rotate-45 right-[-5px]" />
                    </div>

                    <!-- Card Description -->
                    <div class="bg-white p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
                        <!-- Card Header -->
                        <div class="flex items-center w-full">
                            <div class="flex-1 text-xl text-blue-900 font-medium whitespace-nowrap">Special Voting</div>
                            <div class="flex gap-1 mx-auto">
                                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                                <div class="w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            </div>
                        </div>
                        
                        <!-- Card Time -->
                        <div class="text-2xl font-semibold text-black" id="Special-votes">{{$specialVotesCount}}</div>

                        <!-- Recent Section -->
                        <div class="text-sm leading-none text-black">total voters </div>
                    </div>	
                </div>
     
    </div>
</div>


  
			<div class="flex items-center my-7 p-3 border-2 border-blue-700 shadow-lg">
				<p class="bg-blue-100 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded dark:bg-blue-200 dark:text-blue-800">8.7</p>
				<p class="ms-2 font-medium text-gray-900 dark:text-white">Non voters</p>
				<span class="w-1 h-1 mx-2 bg-gray-900 rounded-full dark:bg-gray-500"></span>
				<p class="text-sm font-medium text-gray-500 dark:text-gray-400">voters __</p>
				{{-- <a href="" class="ms-auto text-sm font-medium text-blue-600 hover:underline dark:text-blue-500 pr-3">Read all reviews</a> --}}
			</div>
			<div class="gap-8 sm:grid sm:grid-cols-2">
				<div>
					<dl  id="CASFORD-container" data-total-voters="{{ $casfordVoter}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Casford Hall</dt>
						<dd class="flex items-center mb-3">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="CASFORD-progress" class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="CASFORD-votes-1">00</div>/{{$casfordVoter}}</span>
						</dd>
					</dl>
					<dl id="VALCO-container" data-total-voters="{{ $valcoVoter}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Valco Hall</dt>
						<dd class="flex items-center mb-3">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="VALCO-progress"  class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="VALCO-votes-1">00</div>/{{$valcoVoter}}</span>
						</dd>
					</dl>
					<dl id="KNH-container" data-total-voters="{{ $KNHVoters}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">KNH Hall</dt>
						<dd class="flex items-center mb-3">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="KNH-progress" class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="KNH-votes-1">00</div>/{{$KNHVoters}}</span>
						</dd>
					</dl>
					<dl id="OGUAA-container" data-total-voters="{{ $oguaaVoters}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Oguaa Hall</dt>
						<dd class="flex items-center">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="OGUAA-progress" class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="OGUAA-votes-1">00</div>/{{$oguaaVoters}}</span>
						</dd>
					</dl>
					<dl id="VTRUST-container" data-total-voters="{{ $valcotrustVoters}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Valco Trust Hall</dt>
						<dd class="flex items-center">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="VTRUST-progress" class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="VTRUST-votes-1">00</div>/{{$valcotrustVoters}}</span>
						</dd>
					</dl>
				</div>
				<div>
					<dl id="ADEHYE-container" data-total-voters="{{ $adehyeVoters}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Adehye Hall</dt>
						<dd class="flex items-center mb-3">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div  id="ADEHYE-progress" class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="ADEHYE-votes-1">00</div>/{{$adehyeVoters}}</span>
						</dd>
					</dl>
					<dl id="ATLANTIC-container" data-total-voters="{{ $ATLVoters}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Atlantic Hall</dt>
						<dd class="flex items-center mb-3">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="ATLANTIC-progress" class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="ATLANTIC-votes-1">00</div>/{{$ATLVoters}}</span>
						</dd>
					</dl>
					<dl id="SRC-container" data-total-voters="{{ $SRCfordVoters}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SRC Hall</dt>
						<dd class="flex items-center">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="SRC-progress" class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><diiv id="SRC-votes-1">00</diiv>/{{$SRCfordVoters}}</span>
						</dd>
					</dl>
					<dl id="GUSSS-container" data-total-voters="{{ $supernuionfordVoters}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Supernuation Hall</dt>
						<dd class="flex items-center">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="GUSSS-progress" class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="GUSSS-votes-1">00</div>/{{$supernuionfordVoters}}</span>
						</dd>
					</dl>
					
					<dl id="UHALL-container" data-total-voters="{{ $universityVoters}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">University Hall</dt>
						<dd class="flex items-center">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="UHALL-progress"  class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="UHALL-votes-1">00</div>/{{$universityVoters}}</span>
						</dd>
					</dl>
					<dl id="Special-container" data-total-voters="{{ $specialVotesCount}}">
						<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Special Voting</dt>
						<dd class="flex items-center">
							<div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
								<div id="Special-progress"  class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 0%"></div>
							</div>
							<span class="text-sm font-medium text-gray-500 dark:text-gray-400"><div id="Special-votes-1">00</div>/{{$universityVoters}}</span>
						</dd>
					</dl>
				</div>
			</div>

		  
		</div>
	 </div>
    </div>
	<script>
	document.addEventListener('DOMContentLoaded', function () {
		Echo.channel('strongrooms')
			.listen('.voter.count.updated', (data) => {
				console.log(data);
				
				if (data.hall === 'CASFORD') {
				const element = document.getElementById('CASFORD-votes');
				const element2 = document.getElementById('CASFORD-votes-1');
				const progressBar = document.getElementById('CASFORD-progress');
				const totalVoters = document.getElementById('CASFORD-container').getAttribute('data-total-voters');

				if (element && element2 && progressBar) {
					element.textContent = data.voterCount;
					element2.textContent = data.voterCount;

					const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
					progressBar.style.width = ${percentage}%;
				} else {
					console.error('Some elements for CASFORD hall were not found');
				}
			}

				if (data.hall === 'VALCO') {
					const element = document.getElementById('VALCO-votes');
					const element2 = document.getElementById('VALCO-votes-1');
					const progressBar = document.getElementById('VALCO-progress');
					const totalVoters = document.getElementById('VALCO-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for valco hall were not found');
					}
				}
				if (data.hall === 'KNHALL') {
					const element = document.getElementById('KNH-votes');
					const element2 = document.getElementById('KNH-votes-1');
					const progressBar = document.getElementById('KNH-progress');
					const totalVoters = document.getElementById('KNH-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for KNH hall were not found');
					}
				}
				if (data.hall === 'ADEHYE') {
					const element = document.getElementById('ADEHYE-votes');
					const element2 = document.getElementById('ADEHYE-votes-1');
					const progressBar = document.getElementById('ADEHYE-progress');
					const totalVoters = document.getElementById('ADEHYE-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for ADEHYE hall were not found');
					}
				}
				if (data.hall === 'OGUAA') {
					const element = document.getElementById('OGUAA-votes');
					const element2 = document.getElementById('OGUAA-votes-1');
					const progressBar = document.getElementById('OGUAA-progress');
					const totalVoters = document.getElementById('OGUAA-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for OGUAA hall were not found');
					}
				}
				if (data.hall === 'ATLANTIC') {
					const element = document.getElementById('ATLANTIC-votes');
					const element2 = document.getElementById('ATLANTIC-votes-1');
					const progressBar = document.getElementById('ATLANTIC-progress');
					const totalVoters = document.getElementById('ATLANTIC-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for ATLANTIC hall were not found');
					}
				}
				if (data.hall === 'GUSSS') {
					const element = document.getElementById('GUSSS-votes');
					const element2 = document.getElementById('GUSSS-votes-1');
					const progressBar = document.getElementById('GUSSS-progress');
					const totalVoters = document.getElementById('GUSSS-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for ATLANTIC hall were not found');
					}
				}
				if (data.hall === 'SRC') {
					const element = document.getElementById('SRC-votes');
					const element2 = document.getElementById('SRC-votes-1');
					const progressBar = document.getElementById('SRC-progress');
					const totalVoters = document.getElementById('SRC-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for SRC hall were not found');
					}
				}
				if (data.hall === 'UHALL') {
					const element = document.getElementById('UHALL-votes');
					const element2 = document.getElementById('UHALL-votes-1');
					const progressBar = document.getElementById('UHALL-progress');
					const totalVoters = document.getElementById('UHALL-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for SRC hall were not found');
					}
				}
				if (data.hall === 'VTRUST') {
					const element = document.getElementById('VTRUST-votes');
					const element2 = document.getElementById('VTRUST-votes-1');
					const progressBar = document.getElementById('VTRUST-progress');
					const totalVoters = document.getElementById('VTRUST-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for SRC hall were not found');
					}
				}
				if (data.hall === 'SPECIAL') {
					const element = document.getElementById('Special-votes');
					const element2 = document.getElementById('Special-votes-1');
					const progressBar = document.getElementById('Special-progress');
					const totalVoters = document.getElementById('Special-container').getAttribute('data-total-voters');

					if (element && element2 && progressBar) {
						element.textContent = data.voterCount;
						element2.textContent = data.voterCount;

						const percentage = totalVoters > 0 ? (data.voterCount / totalVoters) * 100 : 0;
						progressBar.style.width = ${percentage}%;
					} else {
						console.error('Some elements for SPECIAL hall were not found');
					}
				}

				

			});
		});
		
		const beepSound = document.getElementById('beep-sound');
    
    // Initialize all countdown timers
    document.querySelectorAll('.countdown-timer').forEach((countdownElement) => {
        const startTime = parseInt(countdownElement.dataset.start);
        const endTime = parseInt(countdownElement.dataset.end);
        
        function updateTimer() {
            const now = Date.now();
            const totalDuration = endTime - startTime;
            const timePassed = now - startTime;
            const timeLeft = endTime - now;

            if (timeLeft > 0) {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                
                countdownElement.textContent = ${days}d ${hours}h ${minutes}m ${seconds}s;
                
                if (timeLeft < 10000) {
                    beepSound.play();
                }
            } else {
                countdownElement.textContent = 'Poll ended';
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

	const toggleAccordion = (button) => {
    const targetId = button.getAttribute("data-accordion-target");
    const targetEl = document.querySelector(targetId);
    const isExpanded = button.getAttribute("aria-expanded") === "true";

    // Collapse all siblings if needed
    const parent = button.closest("[data-accordion='collapse']");
    if (parent) {
      const allButtons = parent.querySelectorAll("[data-accordion-target]");
      allButtons.forEach((btn) => {
        const siblingId = btn.getAttribute("data-accordion-target");
        const siblingEl = document.querySelector(siblingId);
        const icon = btn.querySelector("[data-accordion-icon]");

        if (btn !== button) {
          btn.setAttribute("aria-expanded", "false");
          siblingEl?.classList.add("hidden");
          icon?.classList.remove("rotate-180");
        }
      });
    }

    // Toggle the current panel
    button.setAttribute("aria-expanded", String(!isExpanded));
    targetEl?.classList.toggle("hidden");
    button.querySelector("[data-accordion-icon]")?.classList.toggle("rotate-180");
  };

  const accordionButtons = document.querySelectorAll("[data-accordion-target]");
  accordionButtons.forEach((btn) => {
    btn.addEventListener("click", () => toggleAccordion(btn));
  });
		
	</script>
</x-admin-sidebar>
