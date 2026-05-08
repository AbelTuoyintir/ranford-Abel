@auth
<x-admin-sidebar>
    <div>
        <h1 class="text-2xl md:text-4xl font-bold text-center text-white mt-6 mb-4">
            EC Staff Record
          </h1>
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
        <div class="flex items-center justify-center pt-3 px-2 pb-2 mb-3 mt-2 rounded  bg-gray-800">
            <div class="relative overflow-x-auto w-full pt-6 shadow-md sm:rounded-lg">
                <div class="pb-4 pt-4  bg-gray-900 mb-2 flex items-center justify-between">
                    <!-- Search Bar -->
                    <div class=" px-2">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4  text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items" oninput="filterTable()" />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-2 pr-2">
                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="openModal('moderatorModal')">
                            Add Moderators
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" onclick="openModal('verificationModal')">
                            Add Verification Officers
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2" onclick="openModal('candidateModal')">
                            Add Candidate
                        </button>
                    </div>
                </div>
                
                <!-- Moderators Modal -->
                <div id="moderatorModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                        <h3 class="text-lg font-bold mb-4">Add Moderator</h3>
                        <form method="POST" action="{{ route('/add-moderator') }}" enctype="multipart/form-data" id="moderatorForm">
                            @csrf
                            <div class="mb-4">
                                <label for="firstName" class="block text-sm font-medium text-gray-900">First name</label>
                                <input type="text" name="firstName" id="firstName" class="mt-1 block w-full border text-gray-900 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" required />
                            </div>
                            
                            <div class="mb-4">
                                <label for="lastName" class="block text-sm font-medium text-gray-700">Last name</label>
                                <input type="text" name="lastName" id="lastName" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" required />
                            </div>
                            
                            <div class="mb-4">
                                <label for="school_id" class="block text-sm font-medium text-gray-700">Staff number</label>
                                <input type="text" name="school_id" id="school_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" required />
                            </div>
                            
                            <div class="mb-4">
                                <label for="programs" class="block text-sm font-medium text-gray-700">Occupation</label>
                                <input type="text" name="programs" id="programs" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" required />
                            </div>
                            
                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone number</label>
                                <input type="tel" name="phone" id="phone" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" required />
                            </div>
                            
                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" name="image" id="image" class="mt-1 p-2 w-full border border-gray-300 rounded-md" accept="image/*" />
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" required />
                            </div>
                            
                            <div class="mb-4">
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <select name="gender" id="gender" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" id="role" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" required>
                                    <option value="" disabled selected>Select Role</option>
                                    <option value="moderator">Moderator</option>
                                    <option value="super_moderator">Super Moderator</option>
                                </select>
                            </div>
                            
                            <div class="mb-4" id="hallContainer">
                                <label for="hall" class="block text-sm font-medium text-gray-700">Hall</label>
                                <select name="hall" id="hall" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500">
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
                                </select>
                                <span id="hallError" class="text-red-500 text-sm hidden">Hall is required for moderators</span>
                            </div>
                            
                            <div class="flex justify-end space-x-2">
                                <button type="button" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200" onclick="closeModal('moderatorModal')">Cancel</button>
                                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Verification Officers Modal -->
                <div id="verificationModal" class="fixed inset-0 bg-gray-900 flex items-center justify-center hidden">
                    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                        <h3 class="text-lg font-bold mb-4">Add Moderator</h3>
                        <form method="POST" action="{{route('/add-verification-officer')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="verificationName" class="block text-sm font-medium text-gray-900">First name </label>
                                <input type="text" name='firstName'  class="mt-1 block w-full border text-gray-900 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500"  />
                            </div>
                            
                            <div class="mb-4">
                                <label for="verificationName" class="block text-sm font-medium text-gray-700">last name </label>
                                <input type="text"  name='lastName' class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" />
                            </div>
                            <div class="mb-4">
                                <label for="verificationName" class="block text-sm font-medium text-gray-700">Staff number </label>
                                <input type="text"  name='school_id' class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" />
                            </div>
                            <div class="mb-4">
                                <label for="verificationName" class="block text-sm font-medium text-gray-700">Occupation </label>
                                <input type="text"  name='programs' class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" />
                            </div>
                            <div class="mb-4">
                                <label for="verificationName" class="block text-sm font-medium text-gray-700">Phone number </label>
                                <input type="tel"  name='phone' class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" />
                            </div>
                            <div class="mb-4">
                                <label for="pollImage" class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" name="image"  class="mt-1 p-2 w-full border border-gray-300 rounded-md" />
                            </div>
                            <div class="mb-4">
                                <label for="verificationName" class="block text-sm font-medium text-gray-700">Email </label>
                                <input type="text"  name='email' class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" />
                            </div>

                            
                            <div class="mb-4">
                                <label for="verificationMale" class="block text-sm font-medium text-gray-700">Gender</label>
                                <select  name='gender' class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" >
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="verificationHall" class="block text-sm font-medium text-gray-700">Hall</label>
                                <select  name='hall' class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-green-500 focus:border-green-500" >
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
                                </select>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200" onclick="closeModal('verificationModal')">Cancel</button>
                                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                
              
                <!-- Candidates Modal -->
                <div id="candidateModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
                    
                        <!-- Main Content -->
                    <form class="space-y-4" method="POST" action="{{ route('add-candidate') }}" enctype="multipart/form-data">
                        @csrf
                    <main class="container mx-auto py-6">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- First Section -->
                                <div class="bg-white rounded-lg shadow-md p-6">
                                    <h2 class="text-2xl font-bold mb-4 text-gray-800">Add Candidates </h2>
                                    <p class="text-gray-600">
                                        This is the first section.
                                    </p>
                                    <label for="pollSelect" class="block text-sm font-medium text-gray-700">Select Poll</label>
                                        <select name="poll_id" class="poll-select mt-1 block w-full border border-black rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" onchange="syncPollSelection(this)">
                                            <option value="" disabled selected>Select Poll</option>
                                            @foreach ($all_polls as $all_poll)
                                                <option value="{{ $all_poll->id }}">{{ $all_poll->title }}</option>
                                            @endforeach
                                        </select>
                                        <label for="candidatePortfolios" class="block text-sm font-medium text-gray-900">Choose Portfolios</label>
                                    <select id="choose-portfolios" name="portfolios" class="w-full p-2 border border-gray-300 rounded-md">
                                        @foreach ($portfolios as $portfolio)
                                            <option value="{{ $portfolio->name }}">{{ $portfolio->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('portfolios')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                        
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
                                        This is the second section. You can add any content here, such as text, images, or forms.
                                    </p>
                                    <div id="candidateFormsContainer" class="overflow-y-auto max-h-[60vh] mb-4 ">
                                        <!-- Initial candidate form -->
                                        <div class="candidate-form mb-6 border-2 border-purple-500 rounded-lg p-4" style="background-image: url('{{ asset('images/stu.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; opacity: 0.7;">
                                            <h3 class="text-lg font-bold mb-4">Candidate 1</h3>
                        
                                            <!-- Dynamic Search for Index Number -->
                                            <div class="mb-4">
                                                <label for="candidateIndexNumber" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Index Number</label>
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
                                                <label for="candidateFirstName" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">First Name</label>
                                                <input 
                                                    type="text" 
                                                    name="candidates[0][first_name]" 
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500"
                                                />
                                                @error('candidates.0.first_name')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                        
                                            <!-- Middle Name -->
                                            <div class="mb-4">
                                                <label for="candidateMiddleName" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Middle Name</label>
                                                <input 
                                                    type="text" 
                                                    name="candidates[0][middle_name]" 
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500"
                                                />
                                                @error('candidates.0.middle_name')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                        
                                            <!-- Last Name -->
                                            <div class="mb-4">
                                                <label for="candidateLastName" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Last Name</label>
                                                <input 
                                                    type="text" 
                                                    name="candidates[0][last_name]" 
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500"
                                                    required 
                                                />
                                                @error('candidates.0.last_name')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <!-- Hall -->
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
                                                </select>
                                                @error('candidates.0.hall')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                        
                                            <!-- Teaser -->
                                            <div class="mb-4">
                                                <label for="candidateTeaser" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Teaser</label>
                                                <input 
                                                    type="text" 
                                                    name="candidates[0][teaser]" 
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" 
                                                />
                                                @error('candidates.0.teaser')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                        
                                            <!-- Team Name -->
                                            <div class="mb-4">
                                                <label for="candidateTeamName" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Team Name</label>
                                                <input 
                                                    type="text" 
                                                    name="candidates[0][team_name]" 
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" 
                                                />
                                                @error('candidates.0.team_name')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                        
                                            <!-- Ballot Number -->
                                            <div class="mb-4">
                                                <label for="candidateBallotNumber" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Ballot Number</label>
                                                <input 
                                                    type="text" 
                                                    name="candidates[0][ballot_number]" 
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" 
                                                    required 
                                                />
                                                @error('candidates.0.ballot_number')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                        
                                            <!-- CGPA -->
                                            <div class="mb-4">
                                                <label for="candidateCgpa" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">CGPA</label>
                                                <input 
                                                    type="text" 
                                                    name="candidates[0][cgpa]" 
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500" 
                                                    required 
                                                />
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
                                                <small id="ghana-card-id-error-0" class="text-red-500 text-sm hidden">
                                                    Please enter a valid Ghana Card ID in the format GHA-000000000-0.
                                                </small>
                                            </div>
                        
                                            <!-- Biography -->
                                            <div class="mb-4">
                                                <label for="candidateBiography" class="inline-block text-sm font-medium text-gray-900 bg-white px-2 rounded">Biography</label>
                                                <textarea 
                                                    name="candidates[0][biography]" 
                                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500"
                                                ></textarea>
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
                                                <div id="image-preview-0" class="mt-2 w-[420px] h-auto overflow-hidden rounded-lg"></div>
                                                @error('candidates.0.image_path')
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                        
                                            <!-- Delete Button -->
                                            <div class="flex justify-end space-x-2">
                                                <button type="button" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-red-500 hover:text-white" onclick="deleteForm(this)" disabled>
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Form Controls -->
                                <div class="flex justify-between mt-4">
                                    <button type="button" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700" onclick="addMoreCandidate()">
                                        Add More Candidate
                                    </button>
                                    <div>
                                        <button type="button" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200" onclick="closeModal('candidateModal')">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-4 py-2 text-sm text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                                            Submit All
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    </form>
                </div>


                    

    
        
        
              
                <div class="flex flex-col p-4 mt-3">
                    <!-- Moderator and Verification Officer Table -->
                    <h1 class="text-white">MODERATOR AND VERIFICATION OFFICER TABLE</h1>
                    <div class="overflow-y-auto max-h-70">
                      <table class="w-full text-sm text-left rtl:text-right text-gray-400">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                          <tr>
                            <th scope="col" class="px-6 py-3">Full Name</th>
                            <th scope="col" class="px-6 py-3">Staff ID</th>
                            <th scope="col" class="px-6 py-3">Hall</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            <th scope="col" class="px-6 py-3 text-right"><span>Edit</span></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($moderator as $moderators)
                            <tr class="border-b bg-gray-800 border-gray-700 hover:bg-gray-600">
                              <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
                                {{ $moderators->firstName }} {{ $moderators->lastName }}
                              </th>
                              <td class="px-6 py-4">{{ $moderators->school_id }}</td>
                              <td class="px-6 py-4">{{ $moderators->hall ?? 'N/A' }}</td>
                              <td class="px-6 py-4">{{ $moderators->email ?? 'N/A' }}</td>
                              <td class="px-6 py-4">{{ $moderators->role }}</td>
                              <td class="px-6 py-4 text-right">
                                <button onclick="openEditModal('moderator', {{ json_encode($moderators) }})" class="font-medium text-blue-500 hover:underline">Edit</button>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  
                    <!-- Candidate Table -->
                    <h1 class="text-white mt-10">CANDIDATE TABLE</h1>
                    <div class="overflow-y-auto max-h-80">
                      <table class="w-full text-sm text-left rtl:text-right text-gray-400">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                          <tr>
                            <th scope="col" class="px-6 py-3">Candidate Name</th>
                            <th scope="col" class="px-6 py-3">Team Name</th>
                            <th scope="col" class="px-6 py-3">Ballot Number</th>
                            <th scope="col" class="px-6 py-3">Teaser</th>
                            <th scope="col" class="px-6 py-3">Ghana Card ID</th>
                            <th scope="col" class="px-6 py-3 text-right"><span>Edit</span></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($candidate as $candidates)
                            <tr class="border-b border-gray-700 hover:bg-gray-600">
                              <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
                                {{ $candidates->first_name }} {{ $candidates->middle_name }} {{ $candidates->last_name }}
                              </th>
                              <td class="px-6 py-4">{{ $candidates->team_name}}</td>
                              <td class="px-6 py-4">{{ $candidates->ballot_number }}</td>
                              <td class="px-6 py-4">{{ $candidates->teaser }}</td>
                              <td class="px-6 py-4">{{ $candidates->ghana_card_id }}</td>
                              <td class="px-6 py-4 text-right">
                                <button onclick="openEditModal('candidate', {{ json_encode($candidates) }})" class="font-medium text-blue-500 hover:underline">Edit</button>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  
                  <!-- Edit Modal -->
                  <div id="editModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
                    <div class="flex items-center justify-center min-h-screen">
                      <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                        <h2 id="modalTitle" class="text-xl font-semibold text-white mb-4">Edit</h2>
                        <form id="editForm" method="POST">
                          @csrf
                          @method('PUT')
                          <div id="modalFields" class="space-y-4">
                            <!-- Fields will be dynamically populated here -->
                          </div>
                          <div class="flex justify-end mt-6 space-x-4">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
                            <button type="button" onclick="deleteEntity()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  
                  
                

                               
            </div>
            
        </div>
        </div>

        
        </div>

    </div>
    <script>
                    
                    
                    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const hallContainer = document.getElementById('hallContainer');
        const hallSelect = document.getElementById('hall');
        const hallError = document.getElementById('hallError');
        const form = document.getElementById('moderatorForm');

        // Initialize visibility
        toggleHallVisibility();
        
        // Role change event listener
        roleSelect.addEventListener('change', toggleHallVisibility);
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            if (roleSelect.value === 'moderator' && !hallSelect.value) {
                e.preventDefault();
                hallError.classList.remove('hidden');
                hallContainer.scrollIntoView({ behavior: 'smooth' });
            }
        });

        function toggleHallVisibility() {
            if (roleSelect.value === 'super_moderator') {
                hallContainer.classList.add('hidden');
                hallSelect.removeAttribute('required');
                hallSelect.value = '';
                hallError.classList.add('hidden');
            } else {
                hallContainer.classList.remove('hidden');
                hallSelect.setAttribute('required', 'required');
            }
        }
    });

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
                    
                    
                    
                    function openEditModal(type, data) {
                      const modal = document.getElementById('editModal');
                      const modalTitle = document.getElementById('modalTitle');
                      const modalFields = document.getElementById('modalFields');
                      const editForm = document.getElementById('editForm');
                  
                      // Clear previous fields
                      modalFields.innerHTML = '';
                  
                      // Set form action and title based on type
                      if (type === 'moderator') {
                        modalTitle.textContent = 'Edit Moderator';
                        editForm.action = `/moderators/${data.id}`; // Update with your route
                  
                        // Add fields for moderator
                        modalFields.innerHTML = `
                          <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-300">First Name</label>
                            <input type="text"  name="first_name" value="${data.firstName}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-300">Last Name</label>
                            <input type="text"  name="last_name" value="${data.lastName}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="staffId" class="block text-sm font-medium text-gray-300">Staff ID</label>
                            <input type="text"  name="school_id" value="${data.school_id}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="hall" class="block text-sm font-medium text-gray-300">Hall</label>
                            <input type="text"  name="hall" value="${data.hall}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                            <input type="text"  name="email" value="${data.email}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="role" class="block text-sm font-medium text-gray-300">Role</label>
                            <input type="text"  name="role" value="${data.role}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                        `;
                      } else if (type === 'candidate') {
                        modalTitle.textContent = 'Edit Candidate';
                        editForm.action = `/candidates/${data.id}`; // Update with your route
                  
                        // Add fields for candidate
                        modalFields.innerHTML = `
                          <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-300">First Name</label>
                            <input type="text" id="firstName" name="first_name" value="${data.first_name}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="middleName" class="block text-sm font-medium text-gray-300">Middle Name</label>
                            <input type="text" id="middleName" name="middle_name" value="${data.middle_name}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-300">Last Name</label>
                            <input type="text" id="lastName" name="last_name" value="${data.last_name}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="schoolId" class="block text-sm font-medium text-gray-300">School ID</label>
                            <input type="text" id="schoolId" name="school_id" value="${data.school_id}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="ballotNumber" class="block text-sm font-medium text-gray-300">Ballot Number</label>
                            <input type="text" id="ballotNumber" name="ballot_number" value="${data.ballot_number}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="teaser" class="block text-sm font-medium text-gray-300">Teaser</label>
                            <input type="text" id="teaser" name="teaser" value="${data.teaser}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                          <div>
                            <label for="ghanaCardId" class="block text-sm font-medium text-gray-300">Ghana Card ID</label>
                            <input type="text" id="ghanaCardId" name="ghana_card_id" value="${data.ghana_card_id}" class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg">
                          </div>
                        `;
                      }
                  
                      // Show the modal
                      modal.classList.remove('hidden');
                    }
                  
                    function closeEditModal() {
                      const modal = document.getElementById('editModal');
                      modal.classList.add('hidden');
                    }
                  
                    function deleteEntity() {
                      if (confirm('Are you sure you want to delete this record?')) {
                        const form = document.getElementById('editForm');
                        form.action = form.action + '/delete'; // Update with your delete route
                        form.submit();
                      }
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


                  
                    function filterTable() {
                            const searchInput = document.getElementById('table-search').value.toLowerCase();
                            const moderatorRows = document.querySelectorAll('table tbody tr');
                            
                            moderatorRows.forEach(row => {
                                const name = row.querySelector('th').textContent.toLowerCase();
                                const schoolId = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                                const hall = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                                const email = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                                const role = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                                
                                if (name.includes(searchInput) || schoolId.includes(searchInput) || hall.includes(searchInput) || email.includes(searchInput) || role.includes(searchInput)) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            });
                        }

       function searchUser(event, candidateIndex) {
    const input = event.target;
    const specificForm = input.closest('.candidate-form');
    const resultsDiv = specificForm.querySelector('[id^="searchResults-"]');
    const searchValue = input.value;
     
    if (searchValue.length > 0) { 
        fetch(`/search-user?search_value=${searchValue}`, { 
            headers: { 
                'X-Requested-With': 'XMLHttpRequest', 
                'Accept': 'application/json', 
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

    // Create a mapping of inputs specific to this form
    const inputs = {
        indexNumber: specificForm.querySelector('input[name$="[index_number]"]'),
        firstName: specificForm.querySelector('input[name$="[first_name]"]'),
        middleName: specificForm.querySelector('input[name$="[middle_name]"]'),
        lastName: specificForm.querySelector('input[name$="[last_name]"]'),
        cgpa: specificForm.querySelector('input[name$="[cgpa]"]'),
        hall: specificForm.querySelector('select[name$="[hall]"]'),
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
    // Set background
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

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
    
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

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
    
    // Update Ghana Card ID related elements
    const ghanaCardInput = newForm.querySelector('[id^="ghana-card-id-"]');
    if (ghanaCardInput) {
        ghanaCardInput.id = `ghana-card-id-${formCounter - 1}`;
        ghanaCardInput.name = `candidates[${formCounter - 1}][ghana_card_id]`;
    }
    
    const ghanaCardError = newForm.querySelector('[id^="ghana-card-id-error-"]');
    if (ghanaCardError) {
        ghanaCardError.id = `ghana-card-id-error-${formCounter - 1}`;
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
            
            reader.onload = function(e) {
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
document.addEventListener('DOMContentLoaded', function() {
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
    document.getElementById('ghana-card-id-0').addEventListener('input', function() {
        validateGhanaCardId(this);
    });
});
    </script>



</x-admin-sidebar>@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth
