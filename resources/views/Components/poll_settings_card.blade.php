<div>
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 w-[820px] ">
          <!-- Header -->
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Poll Settings</h2>
            <button class="text-gray-500 hover:text-gray-700" onclick="hidePollsettings()">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <!-- Form -->
          <div class="grid grid-cols-2 grid-rows-2">

          
          <div class="111 row-span-2">
          <form  action="{{route('pollsettings')}}" method="POST" enctype="multipart/form-data">
            <!-- Basic Information Section -->
            @csrf
            <input type="hidden" name="poll_id" value="" id="poll_setting_id">
            <div class="mb-6">
              <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Basic Information</h3>
              <div class="space-y-4">
                <!-- Poll Title -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Poll Title</label>
                  <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="" id="edit_title" name="title" >
                </div>

                <!-- Poll Description -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                  <textarea class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" id="edit_description" name="description"></textarea>
                </div>

                <!-- Poll Type -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Poll Type</label>
                  <select id="select_poll_type" name="poll_type" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="UCC GENERAL VOTING">UCC General Voting</option>
                    <option value="DEPARTMENT">Department</option>
                    <option value="HALL">Halls</option>
                    <option value="SPECIAL VOTING">Special Voting</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Date and Time Section -->
            <div class="mb-6">
              <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Schedule</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Start Date -->
                
                

                <!-- End Date -->
                
                <!-- Start Time -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                  <input type="time" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_start_time" name="start_time" >
                </div>

                <!-- End Time -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                  <input type="time" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_end_time" name="end_time" >
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                  <input type="date" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_start_date" name="start_date" >
                </div>

              </div>
            </div>
           

              <input type="hidden" name="poll_type" id="poll_type">
              <input type="hidden" name="query" id="query">
              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Select database</label>
              <select id="filter-select" class="w-full p-2 border border-gray-300 rounded-md" onchange="toggleInputs()">
                <option value="">Choose a filter...</option>
                <option value="year">Ucc General Election</option>
                <option value="department">Department</option>
                <option value="hall">Hall</option>
                <option value="SPECIAL VOTING">Special Voting</option>
              </select>
            </div>
          
            <!-- Special Voting Input (Hidden by default) -->
          <div id="special-voting-options" class="hidden mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Special Voting Categories</label>
            <div class="space-y-2">
              <label class="flex items-center space-x-2">
                <input type="checkbox" name="special_voting_groups[]" value="SM" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                <span class="text-sm text-gray-600">Senior Members</span>
              </label>
              <label class="flex items-center space-x-2">
                <input type="checkbox" name="special_voting_groups[]" value="SS" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                <span class="text-sm text-gray-600">Senior Staff</span>
              </label>
              <label class="flex items-center space-x-2">
                <input type="checkbox" name="special_voting_groups[]" value="JS" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                <span class="text-sm text-gray-600">Junior Staff</span>
              </label>
            </div>
          </div>

          
          
            <!-- Department Input (Hidden by default) -->
            <div id="department-input" class="hidden mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
              <input type="text" name="query_department" id="query_department" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter Department eg Computer Science">
              <!-- Container to display fetched programs -->
              <div id="program-results" class="mt-2"></div>
          </div>
            <!-- Hall Input (Hidden by default) -->
            <div id="hall-input" class="hidden mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Hall</label>
                <select name="query_hall" class="w-full p-2 border border-gray-300 rounded-md">
                <option value="">Select Hall</option>
                <option value="CASFORD">Casford Hall</option>
                <option value="ATLANTIC">Atlantic Hall</option>
                <option value="VALCO">Valco Hall</option>
                <option value="SRC">SRC Hall</option>
                <option value="VTRUST">Valco Trust Hall</option>
                <option value="GUSSS">Supernuation Hall</option>
                <option value="KNHALL">Kwame Nkrumah Hall</option>
                <option value="OGUAA">Oguaa Hall</option>
                <option value="UHALL">University Hall</option>
                <option value="ADEHYE">Adehye Hall</option>
                </select>
            </div>
            
            <!-- Features and Options Section -->
            <div class="mb-6">
              <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Features and Options</h3>
              <div class="space-y-3">
                <!-- Voter Options -->
                <div class="space-y-2">
                  <h4 class="font-medium text-gray-700">Voter Display Options</h4>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name="hash_voter_names_numbers" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Hash Voter Names by Numbers</span>
                  </label>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name=" hash_voter_names_Alphabet" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500" checked>
                    <span class="text-sm text-gray-600">Hash Voter Names by Alphabet</span>
                  </label>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name="hide_profile_pictures" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500" checked>
                    <span class="text-sm text-gray-600">Hide Profile Pictures</span>
                  </label>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name=" anonymous_voting" class=" rounded border-gray-300 text-blue-500 focus:ring-blue-500" checked>
                    <span class="text-sm text-gray-600">Anonymous Voting</span>
                  </label>
                </div>

                <!-- Candidate Options -->
                <div class="space-y-2">
                  <h4 class="font-medium text-gray-700">Candidate Options</h4>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name=" show_candidate_cgpa" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Show Candidate CGPA</span>
                  </label>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name="show_teaser" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Show Candidate Teaser</span>
                  </label>
                  
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name="display_ballot_numbers" class="   rounded border-gray-300 text-blue-500 focus:ring-blue-500" checked>
                    <span class="text-sm text-gray-600">Display Ballot Numbers</span>
                  </label>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name="allow_candidate_biographies" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Allow Candidate Biographies</span>
                  </label>
                </div>

                <!-- Results Options -->
                <div class="space-y-2">
                  <h4 class="font-medium text-gray-700">Results Options</h4>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name="show_live_results" class="selected rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Show Live Results</span>
                  </label>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name="display_vote_counts" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500" checked>
                    <span class="text-sm text-gray-600">Display Vote Counts</span>
                  </label>
                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name="show_percentage_results" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Show Percentage Results</span>
                  </label>

                  <label class="flex items-center space-x-2">
                    <input type="checkbox" name="send_result_slips" class=" rounded border-gray-300 text-blue-500 focus:ring-blue-500" checked >
                    <span class="text-sm text-gray-600">Send Voter Slip</span>
                  </label>
                </div>
              </div>
            </div>
            <!-- Submit Button -->
            <div class="flex justify-end">
              <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
            </div>
          </form>
          </div>
        
          <div class="mb-1">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Manage Candidates</h3>
            <div class="space-y-4">
              <!-- Candidates List -->
              <div class="bg-gray-50 rounded-lg divide-y divide-gray-200 h-[500px] overflow-y-auto" id="candidateContainer">
                <!-- Candidate 1 -->
          
              </div>
            </div>
          </div>
          

            <form method="POST" action="{{ route('portfolios.submit') }}" id="portfoliosForm" class="bg-white p-6 rounded-lg shadow-lg">
              @csrf
              <div>
                  <!-- Form Header -->
                  <h4 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Portfolios</h4>
                  <p class="text-gray-600 mb-4">Choose all the portfolios for this poll.</p>
          
                  <!-- Portfolios Grid -->
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-2" id="portfoliosContainer">
                      @if (!empty($portfolios))
                          @foreach ($portfolios as $portfolio)
                              <label class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200 cursor-pointer">
                                  <input 
                                      type="checkbox" 
                                      name="portfolios[]" 
                                      value="{{ $portfolio->name }}" 
                                      class="rounded border-gray-300 text-blue-500 focus:ring-blue-500 portfolio-checkbox"
                                  >
                                  <span class="ml-3 text-sm text-gray-700">{{ $portfolio->name }}</span>
                              </label>
                          @endforeach
                      @else
                          <p class="text-gray-500 col-span-2">No portfolios available.</p>
                      @endif
                  </div>
          
                  <!-- Submit Button -->
                  <div class="flex justify-end">
                      <button 
                          type="submit" 
                          id="submitBtn" 
                          class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-200"
                      >
                          Submit Selected
                      </button>
                  </div>
          
                  <!-- Hidden Input for Poll ID -->
                  <input type="hidden" name="poll_id" value="" id="poll_id_poll_settings">
              </div>
          </form>
            
            
          
        </div>
      </div>
      </div>
    </div>


</div>