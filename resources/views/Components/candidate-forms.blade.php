
 <!-- Candidates Modal -->
 <div>



 <div id="candidate-forms" class="fixed inset-0 w-full bg-gray-900 flex items-center justify-center ">
                    
   
        <form class="space-y-4" method="POST" action="{{route('add-candidate')}}" enctype="multipart/form-data">
            @csrf
            <main class="container mx-auto py-6 max-w-5/6 w-20/12 p-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h1 class="text-3xl font-bold mb-6 text-gray-800">Add Candidates</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Section -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-2xl font-bold mb-4 text-gray-800">Section 1</h2>
                            <p class="text-gray-600">
                                This is the first section. 
                            </p>
                            <!-- Add more content as needed -->
                            <input type="hidden" name="poll_id" value="" id="polls_ids">
                <div class="mb-1">
                    <label for="candidatePortfolios" class="block text-sm font-medium text-gray-900">Choose Portfolios</label>
                    <select id="choose-portfolios" name="portfolios" class="w-full p-2 border border-gray-300 rounded-md" >
                          
                    </select>
                    
                </div>
                <div class="mb-4 relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Candidate Password</label>
                    <div class="flex items-center relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500 pr-10" 
                            placeholder="Enter password for candidate..."
                            minlength="8"
                            onkeyup="checkPasswordStrength(this.value)"
                            required
                        />
                        <button 
                            type="button" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 flex items-center justify-center p-1" 
                            onclick="togglePasswordVisibility()"
                            aria-label="Toggle password visibility"
                        >
                            <svg id="eyeIcon" class="w-5 h-5 text-gray-500 hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="eyeSlashIcon" class="w-5 h-5 text-gray-500 hover:text-gray-700 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Password strength meter -->
                    <div class="mt-2">
                        <div class="flex justify-between mb-1">
                            <span class="text-xs text-gray-600">Password Strength:</span>
                            <span id="strengthText" class="text-xs">None</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="strengthMeter" class="h-2 rounded-full bg-gray-300" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <!-- Password requirements -->
                    <div class="mt-2 text-xs text-gray-600">
                        <p>Password must contain:</p>
                        <ul class="grid grid-cols-2 gap-x-2 mt-1">
                            <li id="length" class="flex items-center">
                                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                </svg>
                                At least 8 characters
                            </li>
                            <li id="uppercase" class="flex items-center">
                                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                </svg>
                                Uppercase letter
                            </li>
                            <li id="lowercase" class="flex items-center">
                                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                </svg>
                                Lowercase letter
                            </li>
                            <li id="number" class="flex items-center">
                                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                </svg>
                                Number
                            </li>
                            <li id="special" class="flex items-center">
                                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                </svg>
                                Special character
                            </li>
                        </ul>
                    </div>
                    
                    <div id="password-error" class="text-red-500 text-xs mt-1 hidden">
                        Please provide a valid password.
                    </div>
                </div>
                        </div>
        
                        <!-- Second Section -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-2xl font-bold mb-4 text-gray-800">Section 2</h2>
                            <p class="text-gray-600">
                                This is the second section. 
                            </p>
                            <!-- Scrollable forms container -->
                            <div id="candidateFormsContainer" class="overflow-y-auto max-h-[60vh] mb-4">
                                <!-- Initial candidate form -->
                                <div class="candidate-form mb-6 border-2 border-purple-500 rounded-lg p-4 "style="background-image: url('{{ asset('images/stu.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;opacity: 0.7;">
                                    <h3 class="text-lg font-bold mb-4">Candidate 1</h3>
                                    <!-- Dynamic Search for Index Number -->
                                    <div class="mb-4">
                                        <label for="candidateIndexNumber" class="block text-sm font-medium text-gray-900">Index Number</label>
                                        <input 
                                        type="text" 
                                        id="candidateIndexNumber" 
                                        name="candidates[0][index_number]" 
                                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" 
                                        placeholder="Enter index number..."
                                        oninput="searchUser(event, 0)" 
                                    />
                                    @error('candidates.0.index_number')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                        <div id="searchResults-0" class="mt-2 text-sm text-gray-600"></div>
                                    </div>
                                    <!-- First Name -->
                                    <div class="mb-4">
                                        <label for="candidateFirstName" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">
                                            First name
                                        </label>
                                        <input type="text" name="candidates[0][first_name]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" />
                                        @error('candidates.0.first_name')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                    
                                    <!-- Middle Name -->
                                    <div class="mb-4">
                                        <label for="candidateMiddleName" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Middle name</label>
                                        <input type="text" name="candidates[0][middle_name]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" />
                                        @error('candidates.0.middle_name')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                    </div>
                    
                                    <!-- Last Name -->
                                    <div class="mb-4">
                                        <label for="candidateLastName" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Last name</label>
                                        <input type="text" name="candidates[0][last_name]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" required />
                                        @error('candidates.0.last_name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Hall</label>
                                        <select name="candidates[0][hall]" class="w-full p-2 border border-gray-300 rounded-md">
                                        <option value="">Select Hall</option>
                                        <option value="CASFORD">Casford Hall</option>
                                        <option value="ATLANTIC">Atlantic Hall</option>
                                        <option value="VALCO">Valco Hall</option>
                                        <option value="SRC">SRC Hall</option>
                                        <option value="VTRUST">Valco Trust Hall</option>
                                        <option value="GUSSS">Supernuation Hall</option>
                                        <option value="KNHALL">Kwame Nkrumah Hall</option>
                                        <option value="OGUAA">Oguaa Hall</option>
                                        <option value="UHALL">PSI Hall</option>
                                        <option value="ADEHYE">Adehye Hall</option>
                                        <option value="SPECIAL">Special Hall</option>
                                        </select>
                                        @error('candidates.0.hall')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <!-- Team-name -->
                                    <div class="mb-4">
                                        <label for="candidateTeamName" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Team name</label>
                                        <input type="text" name="candidates[0][team_name]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" />
                                        @error('candidates.0.team_name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    </div>

                                    <!-- Teaser -->
                                    <div class="mb-4">
                                        <label for="candidateTeaser" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Teaser</label>
                                        <input type="text" name="candidates[0][teaser]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" />
                                        @error('candidates.0.teaser')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    
                                    <!-- Ballot Number -->
                                    <div class="mb-4">
                                        <label for="candidateBallotNumber" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Ballot number</label>
                                        <input type="text" name="candidates[0][ballot_number]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500"  />
                                        @error('candidates.0.ballot_number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="candidateCgpa" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">CGPA</label>
                                        <input type="text" name="candidates[0][cgpa]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500 disabled"  />
                                        @error('candidates.0.cgpa')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    </div>
                    
                                    <!-- Ghana Card ID -->
                                    <div class="mb-4">
                                        <label for="ghana-card-id-0" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Ghana Card ID</label>
                                        <input 
                                            type="text" 
                                            id="ghana-card-id-0" 
                                            name="candidates[0][ghana_card_id]"
                                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                            placeholder="GHA-000000000-0"
                                            maxlength="15"
                                            pattern="^GHA-\d{9}-\d{1}$" 
                                            title="Enter a valid Ghana Card ID in the format GHA-000000000-0"
                                            required
                                        >
                                        @error('candidates.0.ghana_card_id')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                        <small id="ghana-card-id-error-0" class="text-red-500 text-sm hidden">Please enter a valid Ghana Card ID in the format GHA-000000000-0.</small>
                                    
                                    </div>
                    
                                    <!-- Biography -->
                                    <div class="mb-4">
                                        <label for="candidateBiography" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Biography</label>
                                        <textarea name="candidates[0][biography]" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500"></textarea>
                                        @error('candidates.0.biography')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    </div>
                    
                                    <!-- Image Upload -->
                                    <div class="mb-4">
                                        <label class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Image</label>
                                        <div 
                                            class="file-upload border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition"
                                            onclick="document.getElementById('candidate-image-0').click()"
                                        >
                                            <div class="flex flex-col items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                                            </div>
                                            <input 
                                                type="file" 
                                                class="hidden" 
                                                accept="image/*" 
                                                name="candidates[0][image_path]" 
                                                id="candidate-image-0"
                                                onchange="previewImage(event, 0)"
                                            >
                                        </div>
                                        @error('candidates.0.image_path')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                        <div id="image-preview-0" class="mt-2 w-[420px] h-auto overflow-hidden rounded-lg"></div>
                                    </div>
                    
                                    <!-- Delete Button -->
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" class="px-4 py-2 text-sm text-gray-900 bg-gray-100 rounded-lg hover:bg-red-500 hover:text-white" onclick="deleteForm(this)" disabled>Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                       <!-- Form Controls -->
                    <div class="flex justify-between mt-4">
                        <button type="button" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700" onclick="addMoreCandidate()">Add More Candidate</button>
                        <div>
                            <button type="button" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200" onclick="closeCandidateForm()">Cancel</button>
                            <button type="submit" class="px-4 py-2 text-sm text-white bg-purple-600 rounded-lg hover:bg-purple-700">Submit All</button>
                        </div>
                    </div>
                </div>
             
            </main>
            
        </form>
    </div>

 
<script>
    function searchUser(event, candidateIndex) {
        const input = event.target;
        const specificForm = input.closest('.candidate-form');
        const resultsDiv = specificForm.querySelector('[id^="searchResults-"]');
        const searchValue = input.value;

        if (searchValue.length > 0) {
            fetch(`/search-user?search_value=${searchValue}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then((data) => {
                    
                    if (data.length > 0) {
                        resultsDiv.innerHTML = data
                            .map((user) => `
                                <div class="flex justify-between items-center bg-gray-100 p-2 rounded mb-1">
                                    <div>
                                        <span class="font-medium">${user.firstName} ${user.lastName}</span>
                                        <span class="text-gray-500 ml-2">(${user.schoolId})</span>
                                    </div>
                                    <button type="button" onclick="selectUser(this)"
                                        data-user='${JSON.stringify(user).replace(/'/g, '&#39;')}'
                                        class="text-blue-600 hover:bg-blue-100 px-2 py-1 rounded">
                                        Select
                                    </button>
                                </div>
                            `)
                            .join('');
                    } else {
                        resultsDiv.innerHTML = '<p class="text-red-500">No results found</p>';
                    }
                })
                .catch((error) => {
                    console.error('Error fetching user:', error);
                    resultsDiv.innerHTML = '<p class="text-red-500">Search failed. Please try again.</p>';
                });
        } else {
            resultsDiv.innerHTML = '';
        }
    }

    function selectUser(button) {
        // Find the specific candidate form
        const specificForm = button.closest('.candidate-form');
        const user = JSON.parse(button.getAttribute('data-user'));
        console.log(user);
        // Create a mapping of inputs specific to this form
        const inputs = {
            indexNumber: specificForm.querySelector('input[name$="[index_number]"]'),
            firstName: specificForm.querySelector('input[name$="[first_name]"]'),
            middleName: specificForm.querySelector('input[name$="[middle_name]"]'),
            lastName: specificForm.querySelector('input[name$="[last_name]"]'),
            teamName: specificForm.querySelector('input[name$="[team_name]"]'),
            Portfolios: specificForm.querySelector('select[name$="[portfolios]"]'),
            cgpa: specificForm.querySelector('input[name$="[cgpa]"]'),
            hall: specificForm.querySelector('select[name$="[hall]"]'),

            cgpa: specificForm.querySelector('input[name$="[cgpa]"]'),
            ghanaCardId: specificForm.querySelector('input[name$="[ghana_card_id]"]'),
            biography: specificForm.querySelector('textarea[name$="[biography]"]')
        };

        // Populate form fields
        inputs.indexNumber.value = user.schoolId;
        inputs.firstName.value = user.firstName;
        inputs.middleName.value = user.middleName || '';
        inputs.lastName.value = user.lastName;
        inputs.cgpa.value = user.cgpa || '';
        inputs.hall.value = user.hall || '';
        inputs.ghanaCardId.value = user.ghanaCardId || '';
        inputs.biography.value = user.biography || '';

        
        if (inputs.hall && user.hall) {
            inputs.hall.value = user.hall;
        }
        // Handle portfolios selection
        if (inputs.Portfolios) {
            const portfolioValue = user.portfolio || ''; // Assuming `portfolio` exists in user data
            inputs.Portfolios.value = portfolioValue;
        }

        // Set background if user image exists
        if (user.image) {
            specificForm.style.backgroundImage = `url('${user.image}')`;
            specificForm.style.backgroundSize = 'cover';
            specificForm.style.backgroundPosition = 'center';
            specificForm.style.opacity = '0.7';
        }

        // Clear search results
        const resultsDiv = specificForm.querySelector('[id^="searchResults-"]');
        resultsDiv.innerHTML = '';
    }

    function syncPollSelection(selectElement) {
        const selectedPollId = selectElement.value;
        document.querySelectorAll('input[name="poll_id"]').forEach(input => {
            input.value = selectedPollId;
        });
    }

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    }
    
    function checkPasswordStrength(password) {
        // Initialize variables
        const strengthMeter = document.getElementById('strengthMeter');
        const strengthText = document.getElementById('strengthText');
        
        // Clear previous strength meter
        strengthMeter.style.width = '0%';
        strengthMeter.className = 'h-2 rounded-full bg-gray-300';
        strengthText.textContent = 'None';
        strengthText.className = 'text-xs';
        
        // If password is empty, don't calculate strength
        if (!password) {
            return;
        }
        
        // Check requirements
        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumbers = /[0-9]/.test(password);
        const hasSpecialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
        
        // Update requirement indicators
        updateRequirement('length', hasLength);
        updateRequirement('uppercase', hasUppercase);
        updateRequirement('lowercase', hasLowercase);
        updateRequirement('number', hasNumbers);
        updateRequirement('special', hasSpecialChars);
        
        // Calculate strength score (0-100)
        let strength = 0;
        
        // Basic length check
        if (password.length >= 8) strength += 20;
        if (password.length >= 12) strength += 10;
        
        // Character variety checks
        if (hasUppercase) strength += 20;
        if (hasLowercase) strength += 20;
        if (hasNumbers) strength += 20;
        if (hasSpecialChars) strength += 20;
        
        // Entropy bonus for length
        strength += Math.min(10, password.length / 2);
        
        // Cap strength at 100
        strength = Math.min(100, strength);
        
        // Update strength meter
        strengthMeter.style.width = strength + '%';
        
        // Set color and text based on strength
        if (strength < 30) {
            strengthMeter.className = 'h-2 rounded-full bg-red-500';
            strengthText.textContent = 'Weak';
            strengthText.className = 'text-xs text-red-500';
        } else if (strength < 60) {
            strengthMeter.className = 'h-2 rounded-full bg-yellow-500';
            strengthText.textContent = 'Medium';
            strengthText.className = 'text-xs text-yellow-500';
        } else if (strength < 80) {
            strengthMeter.className = 'h-2 rounded-full bg-blue-500';
            strengthText.textContent = 'Strong';
            strengthText.className = 'text-xs text-blue-500';
        } else {
            strengthMeter.className = 'h-2 rounded-full bg-green-500';
            strengthText.textContent = 'Very Strong';
            strengthText.className = 'text-xs text-green-500';
        }
    }
    
    function updateRequirement(id, isMet) {
        const element = document.getElementById(id);
        const icon = element.querySelector('svg');
        
        if (isMet) {
            element.classList.add('text-green-600');
            icon.classList.remove('text-gray-400');
            icon.classList.add('text-green-600');
            icon.innerHTML = '<circle cx="12" cy="12" r="10" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>';
        } else {
            element.classList.remove('text-green-600');
            icon.classList.add('text-gray-400');
            icon.classList.remove('text-green-600');
            icon.innerHTML = '<circle cx="12" cy="12" r="10" stroke-width="2"/>';
        }
    }
    
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const passwordError = document.getElementById('password-error');
        
        if (passwordInput) {
            passwordInput.addEventListener('blur', function() {
                if (passwordInput.value && passwordInput.value.length < 8) {
                    passwordError.classList.remove('hidden');
                } else {
                    passwordError.classList.add('hidden');
                }
            });
            
            // If the input is in a form, add form validation
            const form = passwordInput.closest('form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (passwordInput.value && passwordInput.value.length < 8) {
                        event.preventDefault();
                        passwordError.classList.remove('hidden');
                    }
                });
            }
        }
    });

    

    

    let formCounter = 1;

    function addMoreCandidate() {
        formCounter++;
        const formsContainer = document.getElementById('candidateFormsContainer');
        const originalForm = formsContainer.querySelector('.candidate-form');
        const newForm = originalForm.cloneNode(true);

        // Update candidate number in header
        const headerElement = newForm.querySelector('h3');
        headerElement.textContent = `Candidate ${formCounter}`;

        // Update all input names and IDs in the new form
        newForm.querySelectorAll('input,textarea,select').forEach(input => {
            // Clear the value
            input.value = '';

            // Update name attribute to use the new index
            if (input.name && input.name.includes('candidates[')) {
                input.name = input.name.replace(/candidates\[\d+\]/, `candidates[${formCounter - 1}]`);
            }

            // Update ID if it exists
            if (input.id) {
                input.id = input.id.replace(/\d+$/, formCounter - 1);
            }
        });

        // Update portfolio select element
        const portfolioSelect = newForm.querySelector('select[name$="[portfolios]"]');
        if (portfolioSelect) {
            portfolioSelect.value = ''; // Clear the selected value for new form
        }

        // Update file upload related elements
        const fileUploadDiv = newForm.querySelector('.file-upload');
        if (fileUploadDiv) {
            fileUploadDiv.onclick = () => document.getElementById(`candidate-image-${formCounter - 1}`).click();
        }

        // Update file input specifically
        const fileInput = newForm.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.id = `candidate-image-${formCounter - 1}`;
            fileInput.name = `candidates[${formCounter - 1}][image_path]`;
            fileInput.onchange = (event) => previewImage(event, formCounter - 1);
        }

        // Update image preview container
        const previewDiv = newForm.querySelector('[id^="image-preview-"]');
        if (previewDiv) {
            previewDiv.id = `image-preview-${formCounter - 1}`;
            previewDiv.innerHTML = ''; // Clear any existing preview
        }

        // Enable the delete button
        const deleteButton = newForm.querySelector('button[onclick="deleteForm(this)"]');
        deleteButton.disabled = false;

        // Add the new form to the container
        formsContainer.appendChild(newForm);

        // Scroll to the new form
        newForm.scrollIntoView({ behavior: 'smooth' });

        updateFormNumbers();
    }

    function deleteForm(button) {
        const allForms = document.querySelectorAll('.candidate-form');

        if (allForms.length > 1) {
            const form = button.closest('.candidate-form');
            form.remove();
            formCounter--;
            updateFormNumbers();
        } else {
            alert("You need at least one candidate form.");
        }
    }

    function updateFormNumbers() {
        const allForms = document.querySelectorAll('.candidate-form');
        allForms.forEach((form, index) => {
            // Update candidate number
            const headerElement = form.querySelector('h3');
            headerElement.textContent = `Candidate ${index + 1}`;

            // Update all input names
            form.querySelectorAll('input, textarea').forEach(input => {
                if (input.name && input.name.includes('candidates[')) {
                    input.name = input.name.replace(/candidates\[\d+\]/, `candidates[${index}]`);
                }
                if (input.id && input.id.match(/\d+$/)) {
                    input.id = input.id.replace(/\d+$/, index);
                }
            });

            // Update file upload related elements
            const fileUploadDiv = form.querySelector('.file-upload');
            if (fileUploadDiv) {
                fileUploadDiv.onclick = () => document.getElementById(`candidate-image-${index}`).click();
            }

            // Update preview container ID
            const previewDiv = form.querySelector('[id^="image-preview-"]');
            if (previewDiv) {
                previewDiv.id = `image-preview-${index}`;
            }

            // Enable/disable delete button
            const deleteButton = form.querySelector('button[onclick="deleteForm(this)"]');
            deleteButton.disabled = allForms.length === 1;
        });
    }

    function previewImage(event, formIndex) {
        const input = event.target;
        const previewContainer = document.getElementById(`image-preview-${formIndex}`);

        if (previewContainer) {
            previewContainer.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-full', 'h-auto', 'rounded-lg', 'mt-2');
                    previewContainer.appendChild(img);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    // Optional: Add Ghana Card ID validation
    document.addEventListener('DOMContentLoaded', function () {
        const validateGhanaCardId = (input) => {
            const pattern = /^GHA-\d{9}-\d{1}$/;
            const errorElement = document.getElementById(`ghana-card-id-error-${input.id.split('-').pop()}`);

            if (!pattern.test(input.value)) {
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else {
                errorElement.classList.add('hidden');
                input.classList.remove('border-red-500');
                return true;
            }
        };

        // Add validation to initial form
        document.getElementById('ghana-card-id-0').addEventListener('input', function () {
            validateGhanaCardId(this);
        });
    });
</script>
