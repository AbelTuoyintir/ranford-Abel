@auth
<x-admin-sidebar>
    <div class="container">
        @if ($errors->any())
            <div class="fixed top-4 right-4 z-50 error-prompt" role="alert">
                <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl transition-transform duration-300 ease-in-out animate-bounce">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                        </svg>
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    
        @if(session('success'))
            <div class="fixed top-4 left-4 z-50 success-prompt" role="alert">
                <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl transition-transform duration-300 ease-in-out animate-bounce">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
    
        <script>
            // Auto-dismiss for success prompt
            setTimeout(() => {
                const successMessage = document.querySelector('.success-prompt');
                if (successMessage) {
                    successMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500); // Matches the transition duration
                }
            }, 5000);
    
            // Auto-dismiss for error prompt
            setTimeout(() => {
                const errorMessage = document.querySelector('.error-prompt');
                if (errorMessage) {
                    errorMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
                    setTimeout(() => {
                        errorMessage.remove();
                    }, 500); // Matches the transition duration
                }
            }, 5000);
        </script>
    </div>
    
    
    <div class="w-full h-full overflow-y-auto max-h-full bg-gray-500 flex flex-col">
        <nav class="sticky bg-gray-50 top-0 p-3">
            <h1 class="text-black font-bold text-3xl mb-6">VERIFICATION ROOM </h1>   
            <div class="grid grid-cols-6 gap-5">
                <!-- Total number of Voters Card -->
                <div class="w-full h-40 bg-[#1C204B] text-white rounded-lg p-4 flex flex-col justify-center items-center">
                    <div class="w-10 h-10 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2 10a8 8 0 1116 0A8 8 0 012 10zm8-6a6 6 0 106 6 6 6 0 00-6-6zm0 10a4 4 0 11-4-4 4 4 0 014 4z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="text-4xl font-semibold mb-3">{{$voters->count()}}</div>
                    <p class="text-sm">TOTAL VOTERS</p>
                </div>

                <!-- Total Voters Card -->
                <div class="w-full h-40 bg-[#1C204B] text-white rounded-lg p-4 flex flex-col justify-center items-center">
                    <div class="w-10 h-10 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2 10a8 8 0 1116 0A8 8 0 012 10zm8-6a6 6 0 106 6 6 6 0 00-6-6zm0 10a4 4 0 11-4-4 4 4 0 014 4z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="text-4xl font-semibold mb-3">{{$votes->count()}}</div>
                    <p class="text-sm">TOTAL VOTES</p>
                </div>
                
                <!-- Verified Voters Card -->
                <div class="w-full h-40 bg-[#1C204B] text-white rounded-lg p-4 flex flex-col justify-center items-center">
                    <div class="w-10 h-10 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.293 9.293a1 1 0 011.414 0L14 13.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0L8.293 9.293zM4 10a6 6 0 1112 0 6 6 0 01-12 0z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="text-4xl font-semibold mb-3">{{$voters_verify->count()}}</div>
                    <p class="text-sm">VERIFIED VOTERS</p>
                </div>

                <!-- Unverified Voters Card -->
                <div class="w-full h-40 bg-[#1C204B] text-white rounded-lg p-4 flex flex-col justify-center items-center">
                    <div class="w-10 h-10 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a8 8 0 00-8 8 8 8 0 0015.796 3.003l2.65 2.651A10.01 10.01 0 1110 2z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="text-4xl font-semibold mb-3">{{$voters_unverify->count()}}</div>
                    <p class="text-sm">UNVERIFIED VOTERS</p>
                </div>

                <!-- Verify Voter Button -->
                <button onclick="openModal()" class="bg-[#1C204B] m-2 rounded-xl text-[#56C2E6] font-bold flex items-center justify-center flex-col p-4">
                    <div class="border-2 border-white p-3 rounded-full mb-4">
                        <h1 class="font-bold text-xl">+</h1>
                    </div>
                    EMAIL VERIFY VOTER
                </button>

                <!-- Verify Voter Button -->
                <button onclick="PortalModal()" class="bg-[#1C204B] m-2 rounded-xl text-[#56C2E6] font-bold flex items-center justify-center flex-col p-4">
                    <div class="border-2 border-white p-3 rounded-full mb-4">
                        <h1 class="font-bold text-xl">+</h1>
                    </div>
                    PORTAL VERIFY VOTER
                </button>
            </div>
        </nav>

        <main class="flex-1 h-full max-h-full overflow-hidden flex flex-col p-3">
            <div class="sticky bg-gray-50 top-0 flex items-center justify-between p-3">
                <h1 class="text-black font-bold">VERIFICATION TABLE</h1>
                <select id="voterFilter" class="p-3 bg-gray-200 outline-none rounded-lg">
                    <option value="">All</option>
                    {{-- <option value="verified">Verified</option> --}}
                    <option value="unverified">Unverified</option>
                </select>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="flex items-center justify-center pt-3 px-2 pb-2 mb-3 mt-2 rounded  bg-gray-800">
                    <div class="relative overflow-x-auto w-full pt-6 shadow-md sm:rounded-lg">
                        <div class="pb-4 pt-3  bg-gray-900 mb-2 flex items-center justify-between">
                            <!-- Search Bar -->
                            <div class="px-2">
                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4  text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input id="searchInput" type="text" class="block pt-2 ps-10 text-sm  border  rounded-lg w-80  bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search for voters" oninput="searchVoters()" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col p-4 mt-3">
                            <!-- Scrollable Table Container -->
                            <div class="overflow-y-auto max-h-96"> <!-- Adjust height with max-h-* -->
                                <table class="w-full text-sm text-left rtl:text-right  text-gray-400">
                                    <thead class="text-xs  uppercase  bg-gray-700 text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Name</th>
                                            <th scope="col" class="px-6 py-3">School ID</th>
                                            <th scope="col" class="px-6 py-3">Hall</th>
                                            <th scope="col" class="px-6 py-3">Gender</th>
                                            <th scope="col" class="px-6 py-3">Program</th>
                                            <th scope="col" class="px-6 py-3 text-right">Action</th>
                                            <th scope="col" class="px-6 py-3 hidden">image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($voters as $voter)
                                            <tr class=" border-b  border-gray-700  hover:bg-gray-600">
                                                <td class="px-6 py-4 font-medium  whitespace-nowrap text-white">
                                                    {{ $voter->firstName }} {{ $voter->lastName }}
                                                </td>
                                                <td class="px-6 py-4">{{ $voter->school_id }}</td>
                                                <td class="px-6 py-4">{{ $voter->hall }}</td>
                                                <td class="px-6 py-4">{{ $voter->gender }}</td>
                                                <td class="px-6 py-4">{{ $voter->Programs}}</td>
                                               
                                                <td class="px-6 py-4 text-right font-medium">
                                                    <a href="#" 
                                                       class="{{ $voter->action === 'verified' ? 'text-green-600' : 'text-red-600' }} hover:underline">
                                                        {{ $voter->action }}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 hidden">{{ $voter->image }}</td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal for Verify Voter -->
   
    <div id="PortalModal" class="fixed inset-0 hidden justify-center items-center z-50 mt-[70px] ml-[600px]">
        <div class="bg-white p-8 rounded-lg w-96">
            <h2 class="text-2xl font-bold mb-4">Verify Voter via Portal</h2>
    
            <!-- Profile Picture -->
            <div class="flex justify-center mb-4">
                <img id="profilePicturePortal" src="https://via.placeholder.com/150" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover" />
            </div>
    
            <!-- Input for Index Number -->
            <input type="text" id="VerifyInputPortal" placeholder="Enter Index Number or Name" class="w-full mb-4 p-3 border border-gray-300 rounded-md" />
    
            <!-- Message Section -->
            <div id="voterMessagePortal" class="hidden text-red-500 mb-4"></div>
    
            <!-- Voter Details -->
            <div id="voterDetailsPortal" class="mb-4 hidden">
                <p><strong>Hall Name:</strong> <span id="hallNamePortal"></span></p>
                <p><strong>Program:</strong> <span id="coursePortal"></span></p>
                <p><strong>Gender:</strong> <span id="genderPortal"></span></p>
    
                <!-- New Input Field for Date of Birth -->
                <label for="dobPortalInput" class="block mt-2"><strong>Date of Birth:</strong></label>
                <input type="date" id="dobPortalInput" class="w-full p-2 border border-gray-300 rounded-md" oninput="validateDOB()" />
            </div>
    
            <!-- Action Buttons -->
            <div class="flex justify-end">
                <!-- Verify Button -->
                <form action="{{ route('voter.verify') }}" method="POST" onsubmit="showLoading()">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="schoolId" id="schoolIdPortal" value="">
                    <input type="hidden" name="DOB" id="DobPortal" value="">
                    <button id="submitButtonPortal" type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="checkIconPortal">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="buttonTextPortal">Verify</span>
                    </button>
                </form>
    
                <!-- Cancel Button -->
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Cancel</span>
                </button>
            </div>
        </div>
    </div>
   

    <!-- Modal for Verify Voter -->
   
    <div id="verifyModal" class="fixed inset-0 hidden justify-center items-center z-50 mt-[70px] ml-[600px]">
        <div class="bg-white p-8 rounded-lg w-96">
            <h2 class="text-2xl font-bold mb-4">Verify Voter via Email</h2>
            
            <!-- Profile Picture -->
            <div class="flex justify-center mb-4">
                <img id="profilePicture" src="https://via.placeholder.com/150" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover" />
            </div>
            
            <!-- Input for Index Number -->
            <input type="text" id="VerifyInput" placeholder="Enter Index Number or Name" class="w-full mb-4 p-3 border border-gray-300 rounded-md" />
            
            <!-- Message Section -->
            <div id="voterMessage" class="hidden text-red-500 mb-4"></div>
    
            <!-- Voter Details -->
            <div id="voterDetails" class="mb-4 hidden">
                <p><strong>Hall Name:</strong> <span id="hallName"></span></p>
                <p><strong>Program:</strong> <span id="course"></span></p>
                <p><strong>Gender:</strong> <span id="gender"></span></p>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-end">
                <!-- Verify Button with Icon -->
                <form action="{{ route('voter.update') }}" method="POST" onsubmit="showLoading()">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="schoolId" id="schoolId" value="">
                    <button id="submitButton" type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="checkIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="buttonText">Verify</span>
                    </button>
                </form>
    
                <!-- Cancel Button with Icon -->
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Cancel</span>
                </button>
            </div>
        </div>
    </div>
    
</div>
    

    

    <script>

        

function showLoading() {
        const button = document.getElementById('submitButton');
        const checkIcon = document.getElementById('checkIcon');
        const buttonText = document.getElementById('buttonText');

        // Disable the button
        button.disabled = true;

        // Replace the icon with a spinner
        checkIcon.outerHTML = '<i class="fas fa-spinner fa-spin w-5 h-5"></i>';

        // Change the button text to "Loading..."
        buttonText.textContent = 'Loading...';
    }
    
    const VerifyInputPortal = document.getElementById('VerifyInputPortal');
const voterDetailsPortal = document.getElementById('voterDetailsPortal');
const voterMessagePortal = document.getElementById('voterMessagePortal');
const dobInput = document.getElementById('dobPortalInput');
const DOB = document.getElementById('DobPortal');
const submitButton = document.getElementById('submitButtonPortal');
const profilePicturePortal = document.getElementById('profilePicturePortal');

VerifyInputPortal.addEventListener('input', () => {
    let query = VerifyInputPortal.value.toLowerCase().trim();
    let rows = document.querySelectorAll('table tbody tr');
    let userFound = false;

    rows.forEach(row => {
        let name = row.cells[0].textContent.toLowerCase().trim();
        let schoolId = row.cells[1].textContent.toLowerCase().trim();
        let hall = row.cells[2].textContent.toLowerCase().trim();
        let program = row.cells[4].textContent.toLowerCase().trim();
        let gender = row.cells[3].textContent.toLowerCase().trim();
        let action = row.cells[5].textContent.toLowerCase().trim();
        let image = row.cells[6].textContent.trim();

        if ((name === query || schoolId === query)) {
            userFound = true;

            if (action !== 'verified') {
                row.style.display = '';

                // Show voter details
                voterDetailsPortal.classList.remove('hidden');
                profilePicturePortal.src = image || 'default.jpg';
                document.getElementById('hallNamePortal').textContent = hall;
                document.getElementById('coursePortal').textContent = program;
                document.getElementById('genderPortal').textContent = gender;
                document.getElementById('schoolIdPortal').value = name === query ? name : schoolId;
               
                // Show message if not verified
                voterMessagePortal.classList.add('hidden');

                // Reset and disable verify button
                dobInput.value = '';
                submitButton.disabled = true;

            } else {
                voterMessagePortal.classList.remove('hidden');
                voterMessagePortal.textContent = 'User is already verified.';
                row.style.display = 'none';
                voterDetailsPortal.classList.add('hidden');
            }

            VerifyInputPortal.value = '';
        } else if (query === '') {
            row.style.display = '';
            voterDetailsPortal.classList.add('hidden');
            voterMessagePortal.classList.add('hidden');
        } else {
            row.style.display = 'none';
        }
    });

    if (!userFound && query !== '') {
        voterMessagePortal.classList.remove('hidden');
        voterMessagePortal.textContent = 'No matching user found.';
        voterDetailsPortal.classList.add('hidden');
    }
});

function validateDOB() {
    // Get the required elements
    const dobInput = document.getElementById('dobPortalInput');
    const DOB = document.getElementById('DobPortal');
    const submitButton = document.getElementById('submitButtonPortal');
    
    // Get the date of birth from the input and trim any extra spaces
    const dobInputValue = dobInput.value.trim();
    
    // Regex pattern for YYYY-MM-DD (e.g., 2002-08-16)
    const pattern = /^\d{4}-\d{2}-\d{2}$/;
    
    // Check if a date is provided and matches the required format
    if (dobInputValue !== '' && pattern.test(dobInputValue)) {
        // Assign the valid date to the hidden input field
        DOB.value = dobInputValue;
        // Enable the submit button
        submitButton.disabled = false;
    } else {
        // Disable the submit button if no date or invalid format is provided
        submitButton.disabled = true;
    }
}

    
    const VerifyInput = document.getElementById('VerifyInput');
VerifyInput.addEventListener('input', () => {
    let query = VerifyInput.value.toLowerCase().trim(); // Trim input
    let rows = document.querySelectorAll('table tbody tr');
    let userFound = false;

    rows.forEach(row => {
        // Get text content from cells and trim whitespace
        let name = row.cells[0].textContent.toLowerCase().trim();
        let schoolId = row.cells[1].textContent.toLowerCase().trim();
        let hall = row.cells[2].textContent.toLowerCase().trim();
        let program = row.cells[4].textContent.toLowerCase().trim();
        let gender = row.cells[3].textContent.toLowerCase().trim();
        let action = row.cells[5].textContent.toLowerCase().trim();
        let image = row.cells[6].textContent.trim(); // Use `data-value` for hidden data

        // If query matches name or school ID
        if ((name === query || schoolId === query)) {
            userFound = true;

            if (action !== 'verified') {
                row.style.display = ''; // Show the matching row

                // Display voter details
                document.getElementById('voterDetails').classList.remove('hidden');
                document.getElementById('hallName').textContent = hall;
                document.getElementById('course').textContent = program;
                document.getElementById('gender').textContent = gender;

                // Update profile picture
                document.getElementById('profilePicture').src = image || 'default.jpg';

                // Update schoolId input with the matched value
                document.getElementById('schoolId').value = name === query ? name : schoolId;

                // Hide the message if it was displayed
                document.getElementById('voterMessage').classList.add('hidden');
            } else {
                // If already verified, show a message
                document.getElementById('voterMessage').classList.remove('hidden');
                document.getElementById('voterMessage').textContent = 'User is already verified.';
                row.style.display = 'none'; // Hide the row
            }

            // Clear input after match
            VerifyInput.value = '';
        } else if (query === '') {
            row.style.display = ''; // Show all rows when the query is cleared
            document.getElementById('voterDetails').classList.add('hidden');
            document.getElementById('voterMessage').classList.add('hidden');
        } else {
            row.style.display = 'none'; // Hide non-matching rows
        }
    });

    // If no user is found, show a message
    if (!userFound && query !== '') {
        document.getElementById('voterMessage').classList.remove('hidden');
        document.getElementById('voterMessage').textContent = 'No matching user found.';
    }
});


    

    
   
    // Event listener to trigger filter function when selection changes
    document.getElementById('voterFilter').addEventListener('change', filterVoters);


function filterVoters() {
    // Get the selected filter value (either "verified", "unverified", or "")
    let filter = document.getElementById('voterFilter').value.toLowerCase().trim();
    let rows = document.querySelectorAll('table tbody tr');
    console.log('Filter applied:', filter);

    // Loop through each row and check the status
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let status = cells[5].innerText.toLowerCase().trim(); // Make sure to trim and convert to lower case
        console.log('Status:', status);
        
        // If the filter is empty or status matches the filter, show the row
        if (filter === "" || status.includes(filter)) {
            row.style.display = ''; // Show row
        } else {
            row.style.display = 'none'; // Hide row
        }
    });
}






function searchVoters() {
    // Get the search query
    let query = document.getElementById('searchInput').value.toLowerCase();

    // Get all the table rows
    let rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        // Get the text content from each column
        let name = row.cells[0].textContent.toLowerCase();
        let schoolId = row.cells[1].textContent.toLowerCase();
        let hall = row.cells[2].textContent.toLowerCase();
        let gender = row.cells[3].textContent.toLowerCase();
        let action = row.cells[5].textContent.toLowerCase();
        
        // Check if the query matches any of the fields (name, gender, action, school id)
        if (name.includes(query) || schoolId.includes(query) || gender.includes(query) || action.includes(query)) {
            row.style.display = ''; // Show row
        } else {
            row.style.display = 'none'; // Hide row
        }
    });
}

        
        function openModal() {
            document.getElementById('verifyModal').classList.remove('hidden');
        }
        function PortalModal() {
            document.getElementById('PortalModal').classList.remove('hidden');
            voterDetailsPortal.classList.add('hidden')
            document.getElementById('hallNamePortal').textContent = '';
                document.getElementById('coursePortal').textContent = '';
                document.getElementById('genderPortal').textContent = '';
                document.getElementById('schoolIdPortal').value = '';
        }

        function closeModal() {
            let rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                row.style.display = '';
            })

            
            document.getElementById('hallName').textContent = '';
            document.getElementById('course').textContent = '';
            document.getElementById('gender').textContent = '';

            // Update profile picture
            document.getElementById('profilePicture').src = '';

            // Update schoolId input with the matched value
            document.getElementById('schoolId').value = '';
            document.getElementById('verifyModal').classList.add('hidden');
            document.getElementById('PortalModal').classList.add('hidden');
            // document.getElementById('voterDetails').classList.remove('hidden');
            
        }

       
    </script>
</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth
