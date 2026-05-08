<div class="h-auto rounded overflow-hidden shadow-lg bg-white  space-x-2 gab-5">
    <!-- Poll Image and Details -->
    <figure class="relative z-0 border-4 border-gradient-to-r from-blue-500 to-green-500 rounded-lg">
      <img src="{{ asset('storage/' . $poll->image) }}" alt="election-image" class="w-full h-48 object-cover rounded-t-lg z-0" />
      <div class="absolute top-2 left-2 flex items-center bg-white p-2 rounded-lg shadow-md z-10">
        <!-- Location Icon -->
        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="text-sm text-gray-800">{{ $poll->poll_type }}</span>
      </div>
    </figure>
  
    <!-- Poll Content -->
    <div class="p-4">
      <!-- Poll Title and Status -->
      <h2 class="text-xl font-semibold text-gray-800 whitespace-nowrap overflow-hidden text-ellipsis">
        {{ $poll->title }}
        <span class="{{ $class }} text-white text-xs px-2 py-1 rounded-full ml-2 {{ $statusAnimation ?? '' }}">
          {{ $poll->status }}
        </span>
      </h2>
  
      <!-- Poll Description -->
      <p class="text-gray-600 mt-2 flex items-center break-words">
        <!-- Document Icon -->
        <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span class="">Description: {{ $poll->description }} </span>
      </p>
  
      <!-- Poll Start Date -->
      <p class="text-gray-600 mt-2 flex items-center">
        <!-- Calendar Icon -->
        <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>Start Date: {{ $poll->start_date }}</span>
      </p>
  
      <!-- Poll Start Time -->
      <p class="text-gray-600 mt-2 flex items-center">
        <!-- Clock Icon -->
        <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Start Time: {{ $poll->start_time }}</span>
      </p>

      <!-- Poll end Time -->
      <p class="text-gray-600 mt-2 flex items-center">
        <!-- Clock Icon -->
        <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>End Time: {{ $poll->end_time }}</span>
      </p>
  
      <!-- Action Buttons -->
      <div class="flex justify-end mt-2 mb-2">
        <!-- Settings Button -->
        <span class="bg-gray-200 text-gray-800 text-xs py-1 px-3 rounded-full mr-2 flex items-center hover:bg-gray-300 cursor-pointer">
          <!-- Settings Icon -->
          <svg class="w-4 h-4 text-gray-800 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <button onclick="pollSettings({{ $poll }})">Settings</button>
        </span>
  
        <!-- Add Candidate Button -->
        <span class="bg-gray-200 text-gray-800 text-xs py-1 px-3 rounded-full flex items-center hover:bg-gray-300 cursor-pointer">
          <!-- Add Icon -->
          <svg class="w-5 h-5 text-gray-800 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          <button onclick="candidateSettings({{ $poll->id }})">Add Candidate</button>
        </span>
      </div>
    </div>
  </div>