@auth
<x-admin-sidebar>
    <div class="w-full h-full overflow-y-auto max-h-full bg-gray-500 flex flex-col mr-5">
        <nav class="sticky bg-gray-50 top-0 p-3">
            <h1 class="text-black font-bold text-3xl mb-6">Create Polls </h1>   
            @if(session('success'))
            <div class="fixed top-4 left-4 z-50">
                <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl transition-all duration-300 ease-in-out animate-bounce">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        
            <script>
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    const successMessage = document.querySelector('.bg-green-500');
                    if (successMessage) {
                        successMessage.classList.add('animate-fadeOut');
                        setTimeout(() => {
                            successMessage.remove();
                        }, 500);
                    }
                }, 5000);
            </script>
        @endif
            <div class="grid grid-cols-5 gap-5">
                <!-- Total Voters Card -->
                <div class="w-full h-40 bg-[#1C204B] text-white rounded-lg p-4 flex flex-col justify-center items-center">
                    <!-- Active Polls Card -->
                    <div class="w-10 h-10 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1h1zm10 0a1 1 0 011 1v12a1 1 0 01-1 1h-1a1 1 0 01-1-1V4a1 1 0 011-1h1zm-5 3a2 2 0 110 4 2 2 0 010-4z"/>
                        </svg>
                    </div>
                    <div class="text-4xl font-semibold mb-3">{{$activePolls}}</div>
                    <p class="text-sm">Active Polls</p>
                </div>
                
                <!-- Unactive Polls Card -->
                <div class="w-full h-40 bg-[#1C204B] text-white rounded-lg p-4 flex flex-col justify-center items-center">
                    <div class="w-10 h-10 mb-3">
                        <!-- Inactive Polls Icon (Lock) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v4H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2v-8a2 2 0 00-2-2h-2V6a4 4 0 00-4-4zm-2 4a2 2 0 114 0v4H8V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-4xl font-semibold mb-3">{{$inactivePolls}}</div>
                    <p class="text-sm">Unactive Polls</p>
                </div>

                <!-- Complete Polls Card -->
                <div class="w-full h-40 bg-[#1C204B] text-white rounded-lg p-4 flex flex-col justify-center items-center">
                  <div class="w-10 h-10 mb-3">
                    <!-- Complete Polls Icon (Checkmark) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M16.293 5.707a1 1 0 00-1.414 0L8 11.586 5.121 8.707a1 1 0 10-1.414 1.414l3.536 3.536a1 1 0 001.414 0l7-7a1 1 0 000-1.414z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <div class="text-4xl font-semibold mb-3">{{$completePolls}}</div>
                  <p class="text-sm">Complete Polls</p>
                </div>


                
                
                
                <!-- Total Polls Card -->
                <div class="w-full h-40 bg-[#1C204B] text-white rounded-lg p-4 flex flex-col justify-center items-center">
                    <div class="w-10 h-10 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM4 6h12v8H4V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-4xl font-semibold mb-3">{{$totalPolls}}</div>
                    <p class="text-sm">Total Polls</p>
                </div>
                

                <!-- Verify Voter Button -->
                <button onclick="openModal()" class="bg-[#1C204B] m-2 rounded-xl text-[#56C2E6] font-bold flex items-center justify-center flex-col p-4">
                    <div class="border-2 border-white p-3 rounded-full mb-4">
                        <h1 class="font-bold text-xl">+</h1>
                    </div>
                   create Poll
                </button>
            </div>
        </nav>



        <main class="flex-1 h-full max-h-full overflow-hidden flex flex-col p-3">
          <div class="sticky  bg-gray-50 top-0 flex items-center justify-between p-3">
            <h1 class="text-black font-bold">Created Poll</h1>   
            <select id="pollStatus" class="p-3 bg-gray-200 outline-none rounded-lg">
                <option value="">All</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="complete">Complete</option>
            </select>
        </div>

            <div class="relative  shadow-md sm:rounded-lg ">
                <div class="flex items-center  h-full max-h-full justify-center pt-3 px-2 pb-15 mb-25 mt-2 rounded  bg-gray-800">
                    <div class="relative  w-full pt-4 shadow-md sm:rounded-lg">
                        <div class="pb-4 pt-3  bg-gray-900 mb-2 flex items-center justify-between">
                            <!-- Search Bar -->
                      
                            <div class="px-2">
                              <label for="table-search" class="sr-only">Search</label>
                              <div class="relative mt-1">
                                  <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                      <svg class="w-4 h-4  text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                      </svg>
                                  </div>
                                  <input id="searchQuery" type="text" class="block pt-2 ps-10 text-sm  border  rounded-lg w-80   bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 " placeholder="Search for polls" />
                              </div>
                          </div>
                        </div>
                        

                        <div class="p-4 mt-3 h-[470px] overflow-x-auto max-w-full space-x-10 px-2 inline-block">
                          <div id="poll-container" class="grid grid-cols-4 gap-15 space-x-4">
                              @foreach ($Polls as $Poll)
                                  <div class="poll-card" data-location="{{ $Poll->poll_type }}" data-description="{{ $Poll->description }}" data-status="{{ $Poll->status }}">
                                      @if ($Poll->status == "inactive")
                                          <x-poll-card :poll="$Poll" class="bg-blue-500" />
                                      @elseif ($Poll->status == "active")
                                          <x-poll-card :poll="$Poll" class="bg-red-500" statusAnimation="animate-pulse" />
                                      @elseif ($Poll->status == "complete")
                                          <x-poll-card :poll="$Poll" class="bg-gray-500" />
                                      @endif
                                      
                                     
                                  </div>
                                  

                                  
                              @endforeach
                              
                          </div>

                         
                      </div>
                    </div>
                </div>
            </div>
        </main>

        <div id="pollModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 hidden ">
            <div class="bg-white p-6 rounded-xl w-11/12 md:w-1/2 lg:w-1/3">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Create a New Poll</h2>
              <form action="{{route('/create-poll')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Poll Name -->
                <div class="mb-4">
                    <label for="pollName" class="block text-sm font-medium text-gray-700">Poll Name</label>
                    <input type="text" id="pollName" class="mt-1 p-2 w-full border border-gray-300 rounded-md" placeholder="Enter Poll Name" name="title" value="{{ old('title') }}" />
                </div>
                @error('title')
                <div class="bg-red-500">{{ $message }}</div>
                @enderror
        
                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" class="mt-1 p-2 w-full border border-gray-300 rounded-md" placeholder="Enter Description">{{ old('description') }}</textarea>
                </div>
                @error('description')
                <div class="bg-red-500">{{ $message }}</div>
                @enderror
        
                <!-- Poll Image -->
                <div class="mb-4">
                    <label for="pollImage" class="block text-sm font-medium text-gray-700">Poll Image</label>
                    <input type="file" name="image" id="pollImage" class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
                </div>
                @error('pollImage')
                <div class="bg-red-500">{{ $message }}</div>
                @enderror
                <!-- Start Date & Time -->
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date"  id="start_date" class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
                </div>
                @error('start_date')
                <div class="bg-red-500">{{ $message }}</div>
                @enderror
        
                <!-- start Date & Time -->
                <div class="mb-4">
                  <label for="Time" class="block text-sm font-medium text-gray-700">Start Time</label>
                  <input type="time" id="start_time" name="start_time"   class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
              </div>
              @error('start_time')
              <div class="bg-red-500">{{ $message }}</div>
              @enderror
                
                
                <!-- End Date & Time -->
                <div class="mb-4">
                    <label for="Time" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" id="endTime" name="end_time"   class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
                </div>
                @error('end_time')
                <div class="bg-red-500">{{ $message }}</div>
                @enderror
        
                <!-- Poll Type Dropdown -->
                <div class="mb-4">
                    <label for="pollType" class="block text-sm font-medium text-gray-700">Poll Type</label>
                    <select id="pollType" name="poll_type" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                      <option value="UCC GENERAL VOTING" {{ old('poll_type') === 'UCC GENERAL VOTING' ? 'selected' : '' }}>Ucc General Voting</option>
                      <option value="DEPARTMENT" {{ old('poll_type') === 'DEPARTMENT' ? 'selected' : '' }}>Department</option>
                      <option value="HALL" {{ old('poll_type') === 'HALL' ? 'selected' : '' }}>Hall</option>
                      <option value="SPECIAL VOTING" {{ old('poll_type') === 'SPECIAL VOTING' ? 'selected' : '' }}>Special Voting</option>
                    </select>
                </div>
                @error('poll_type')
                <div class="bg-red-500">{{ $message }}</div>
                @enderror
        
                <!-- Modal Actions -->
                <div class="flex justify-between items-center mt-6">
                    <button onclick="closeModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-xl">Cancel</button>
                    <button type="submit" class="bg-[#1C204B] text-white px-4 py-2 rounded-xl">Create Poll</button>
                </div>
              </form>
            </div>
        </div>
           

        <!-- Popup Background Overlay -->
        <div class="fixed inset-0 bg-gray-900 flex items-center justify-center p-4 overflow-y-auto hidden "id="pollSettings">
          <!-- Popup Container -->
          <x-poll_settings_card />
        </div>

         <!-- Popup Background Overlay -->
        <div class="fixed inset-0 bg-gray-900 ml-4  flex items-center justify-center p-4 overflow-y-auto hidden "id="candidate-forms">
            <!-- Popup Container -->
            <x-candidate-forms />
        </div>
      
    




    

    <script>


        // Function to open modal
        function openModal() {
            document.getElementById('pollModal').classList.remove('hidden');
            // console.log(document.getElementById('candidate-forms'));
            // document.getElementById('candidate-forms').classList.remove('hidden');
        }
        
        // Function to display candidate settings
        function candidateSettings(id) {
            console.log(id); 
            const pollsIdElement = document.getElementById('polls_ids');
            console.log(pollsIdElement); 
            pollsIdElement.value = id;
            console.log(pollsIdElement);
            fetchCandidatePortfolios(id);
            
            document.getElementById('candidate-forms').classList.remove('hidden');
        }

        
      function toggleInputs() {
          const filterSelect = document.getElementById('filter-select');
          const specialVotingOptions = document.getElementById('special-voting-options');

          const departmentInput = document.getElementById('department-input');
          const hallInput = document.getElementById('hall-input');
          const verification_container = document.getElementById('verification-container');

         
          departmentInput.classList.add('hidden');
          hallInput.classList.add('hidden');
          specialVotingOptions.classList.add('hidden');

         if (filterSelect.value === 'department') {
            departmentInput.classList.remove('hidden');
            // verification_container.classList.remove('hidden')
          } else if (filterSelect.value === 'hall') {
            hallInput.classList.remove('hidden');
           
          }
          else if (filterSelect.value === 'SPECIAL VOTING') {
            specialVotingOptions.classList.remove('hidden');
          
           
          }
          
        }


        // Function to fetch portfolios based on the poll_id
        function fetchCandidatePortfolios(pollId) {
            fetch(`/portfolios-by-poll?poll_id=${pollId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data, "hello");  // Inspecting the fetched data
                const selectElement = document.getElementById('choose-portfolios');
                selectElement.innerHTML = '<option  value="">Select a Portfolio</option>'; // Clear the select options

      

            // Add new options from the fetched data
            if (Array.isArray(data)) {  // Ensure the data is an array
                data.forEach(portfolio => {
                    const option = document.createElement('option');
                    option.value = portfolio; // Set the value of the option
                    option.textContent = portfolio; // Set the text of the option
                    selectElement.appendChild(option);
                });
            } else {
                console.error("Fetched data is not an array:", data);
            }
            })
            .catch(error => {
            console.error('Error fetching portfolios:', error);
            alert('Failed to fetch portfolios. Please try again later.');
        });
}


        
        // Function to hide candidate settings
        function closeCandidateForm() {
            document.getElementById('candidate-forms').classList.add('hidden');
        }
        
        // Function to display poll settings
        function pollSettings(poll) {
            console.log(poll); 
        
            const poll_setting_id = document.getElementById('poll_setting_id');
            const title = document.getElementById('edit_title');
            const description = document.getElementById('edit_description');
            const poll_type = document.getElementById('select_poll_type');
        
            const start_date = document.getElementById('edit_start_date');
            const start_time = document.getElementById('edit_start_time');
            const end_time = document.getElementById('edit_end_time');
            const poll_id_poll_settings = document.getElementById('poll_id_poll_settings');
            
            // Setting values from poll object
            start_time.value = poll.start_time;
            end_time.value = poll.end_time;
            start_date.value = poll.start_date;
            poll_type.value = poll.poll_type;
            description.value = poll.description;
            title.value = poll.title;
            poll_setting_id.value = poll.id;
            poll_id_poll_settings.value = poll.id;
        
            document.getElementById('pollSettings').classList.remove('hidden');
        
            // Call the function to fetch portfolios
            fetchPortfolios(poll.poll_type);
            fetchCandidates(poll.id);
        }
        
        // Function to fetch portfolios based on poll type
        function fetchPortfolios(selectedPollType) {
            console.log('Selected Poll Type:', selectedPollType);
        
            fetch(`/get-portfolios?poll_type=${encodeURIComponent(selectedPollType)}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Portfolios:', data);
        
                let container = document.getElementById('portfoliosContainer');
                container.innerHTML = ''; // Clear existing content
        
                if (data.portfolios && data.portfolios.length > 0) {
                    data.portfolios.forEach(portfolio => {
                        let checkbox = `
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="portfolios[]" value="${portfolio.name}" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500 portfolio-checkbox">
                                <span class="text-sm text-gray-600">${portfolio.name}</span>
                            </label>
                        `;
                        container.innerHTML += checkbox;
                    });
                } else {
                    container.innerHTML = '<p class="text-gray-500">No portfolios available.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching portfolios:', error);
            });
        }
        
        // Event Listener for Poll Type Change
        document.getElementById('select_poll_type').addEventListener('change', function() {
            const selectedPollType = this.value;
            if (selectedPollType) {
                fetchPortfolios(selectedPollType);
               
            }
        });
        
        // Function to hide poll settings
        function hidePollsettings() {
            document.getElementById('pollSettings').classList.add('hidden');
        }
        
        // Function to close the modal
        function closeModal() {
            document.getElementById('pollModal').classList.add('hidden');
        }
        
        // Search functionality
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('searchQuery');
            const pollCards = document.querySelectorAll('.poll-card');
        
            searchInput.addEventListener('input', function () {
                const query = searchInput.value.toLowerCase(); 
        
                // Loop through all poll cards
                pollCards.forEach(card => {
                    const title = card.getAttribute('data-location').toLowerCase();
                    const description = card.getAttribute('data-description').toLowerCase();
                    console.log('title:',title,'description:',description,'query:',query);
                    // Check if query matches title or description
                    if (title.includes(query) || description.includes(query)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
        
        // Poll status filter
        document.addEventListener("DOMContentLoaded", function () {
            const pollStatusSelect = document.getElementById('pollStatus');
            const pollCards = document.querySelectorAll('.poll-card');
        
            pollStatusSelect.addEventListener('change', function() {
                const selectedStatus = this.value;
        
                pollCards.forEach(card => {
                    const cardStatus = card.getAttribute('data-status');
        
                    if (selectedStatus === "" || cardStatus === selectedStatus) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        });
        
        // Get pollId from hidden input

        
        // Fetch candidates for the specific poll
        function fetchCandidates(pollId) {
    fetch(`/get-candidates?pollId=${encodeURIComponent(pollId)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            const container = document.getElementById('candidateContainer');
            container.innerHTML = '';
    
            data.forEach(candidate => {
                let candidateHTML = `
                    <div class="p-4 flex items-center justify-between hover:bg-gray-100 transition-colors" id="candidate-${candidate.id}">
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-200">
                                 <img src="${assetBaseUrl}/${candidate.image_path}" alt="Candidate" class="h-full w-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">${candidate.team_name}</h4>
                                <p class="text-sm text-gray-500">Ballot #: ${candidate.ballot_number} | CGPA: ${candidate.cgpa} | ${candidate.portfolio_id} </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3"> 
                            <button type="button" class="text-red-600 hover:text-red-800" onclick="deleteCandidate(${candidate.id})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                container.innerHTML += candidateHTML;
            });
        })
        .catch(error => {
            console.error('Error fetching candidates:', error);
        });
}

document.getElementById('query_department').addEventListener('input', function (e) {
    const query = e.target.value; // Get the user's input
    const resultsContainer = document.getElementById('program-results');

    // Clear previous results if the input is empty
    if (query.length === 0) {
        resultsContainer.innerHTML = '';
        return;
    }

    // Send an AJAX request to fetch programs
    fetch(`/fetch-programs?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            // Clear previous results
            resultsContainer.innerHTML = '';
            console.log(data); // Debugging: Check the fetched data

            // Display fetched programs
            if (data.length > 0) {
                data.forEach(programName => { // Use programName directly
                    const programElement = document.createElement('div');
                    programElement.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                    programElement.textContent = programName; // Use programName directly
                    programElement.addEventListener('click', () => {
                        document.getElementById('query_department').value = programName; // Use programName directly
                        resultsContainer.innerHTML = ''; // Clear results after selection
                    });
                    resultsContainer.appendChild(programElement);
                });
            } else {
                resultsContainer.innerHTML = '<div class="text-gray-500">No programs found.</div>';
            }
        })
        .catch(error => {
            console.error('Error fetching programs:', error);
            resultsContainer.innerHTML = '<div class="text-red-500">Error fetching programs.</div>';
        });
});

// Delete candidate function
function deleteCandidate(candidateId) {
    if (confirm('Are you sure you want to delete this candidate?')) {
        // Send a DELETE request to the backend to remove the candidate
        fetch(`/delete-candidate/${candidateId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Failed to delete candidate');
            }
            return response.json();
        })
        .then((data) => {
            // Optionally, you can remove the candidate from the UI
            if (data.success) {
                alert('Candidate deleted successfully');
                // Remove the candidate from the DOM
                document.getElementById(`candidate-${candidateId}`).remove();
            }
        })
        .catch((error) => {
            console.error(error);
            alert('An error occurred while deleting the candidate');
        });
    }
}

        
       
       
        </script>
        
</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth