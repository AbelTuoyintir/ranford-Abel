@auth
<x-admin-sidebar>
    <div class=" bg-gray-800">
    
        <!-- Main Container -->
        <div class="container mx-auto p-8">
    
            <!-- Page Header -->
            <div class="mb-8 text-center">
                <p class="text-gray-300">Manage election portfolios, candidates, and voters.</p>
            </div>
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
    
            <!-- User Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Users Card -->
                <div class="p-6 rounded-lg shadow-lg text-center bg-[#2E3650]">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-white">Total Users</h2>
                    <p class="text-4xl font-bold text-blue-400" id="total-users">{{$users->count()}}</p>
                </div>
    
                <!-- Boys Card -->
                <div class="p-6 rounded-lg shadow-lg text-center bg-[#2E3650]">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 00-3-3.87" />
                            <path d="M16 3.13a4 4 0 010 7.75" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-white">MALES</h2>
                    <p class="text-4xl font-bold text-green-400" id="boys">{{$male}}</p>
                </div>
    
                <!-- Girls Card -->
                <div class="p-6 rounded-lg shadow-lg text-center bg-[#2E3650]">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-white">FEMALES</h2>
                    <p class="text-4xl font-bold text-pink-400" id="girls">{{$female}}</p>
                </div>
            </div>
    
            <!-- Fetch Data Buttons -->
            <div class="rounded-md flex items-center justify-center space-x-2" >
                <!-- Student Buttons -->
                <form id="fetch-students-form" action="{{ route('fetchStudents') }}" method="POST">
                    @csrf
                    <div class="text-center mb-8">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                            Fetch All Student Data
                        </button>
                    </div>
                </form>
                
                <div onclick="openStudentModal()" class="text-center mb-8">
                    <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Import Student Data</button>
                </div>
                
                <!-- Staff Buttons -->
                <form id="fetch-staff-form" action="{{ route('fetchStaff') }}" method="POST">
                    @csrf
                    <div class="text-center mb-8">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                            Fetch All Staff Data
                        </button>
                    </div>
                </form>
                
                <div onclick="openStaffModal()" class="text-center mb-8">
                    <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Import Staff Data</button>
                </div>
            </div>

            <!-- Student Import Modal -->
            <div id="studentModal" class="fixed inset-0 hidden justify-center items-center z-50 mt-[70px] ml-[600px]">
                <div class="bg-white p-8 rounded-lg w-96">
                    <h2 class="text-2xl font-bold mb-4">Import Student From Database</h2>
                    
                    <input type="text" name="index_no" id="studentVerifyInput" placeholder="Enter Index Number or Name" class="w-full mb-4 p-3 border border-gray-300 rounded-md" />
                    
                    <div id="studentVoterMessage" class="hidden text-red-500 mb-4"></div>
            
                    <div class="flex justify-end w-50">
                        <form action="{{ route('import') }}" method="POST" onsubmit="document.getElementById('student_index_no').value = document.getElementById('studentVerifyInput').value;">
                            @csrf
                            <input type="hidden" name="index_no" id="student_index_no" >
                            
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3z" />
                                </svg>
                                <span>Import Student</span>
                            </button>
                        </form>
            
                        <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Cancel</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Staff Import Modal -->
            <div id="staffModal" class="fixed inset-0 hidden justify-center items-center z-50 mt-[70px] ml-[600px]">
                <div class="bg-white p-8 rounded-lg w-96">
                    <h2 class="text-2xl font-bold mb-4">Import Staff From Database</h2>
                    
                    <input type="text" name="staff_id" id="staffVerifyInput" placeholder="Enter Staff ID or Name" class="w-full mb-4 p-3 border border-gray-300 rounded-md" />
                    
                    <div id="staffVoterMessage" class="hidden text-red-500 mb-4"></div>
            
                    <div class="flex justify-end w-50">
                        <form action="{{ route('importStaff') }}" method="POST" onsubmit="document.getElementById('staff_id').value = document.getElementById('staffVerifyInput').value;">
                            @csrf
                            <input type="hidden" name="staff_id" id="staff_id" >
                            
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3z" />
                                </svg>
                                <span>Import Staff</span>
                            </button>
                        </form>
            
                        <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Cancel</span>
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- Recent Updates Section -->
            
    
            <!-- Candidates Table Section -->
            <div class="bg-[#2E3650] p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-white mb-4">Voters List</h2>
    
                <!-- Search Bar -->
                <div class="mb-4">
                    <label for="searchInput" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input id="searchInput" type="text" class="w-full pl-10 pr-4 py-2 rounded-lg bg-[#1C204B] border border-gray-600 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Search for candidates..." oninput="searchCandidates()" />
                    </div>
                </div>
    
                <!-- Table Container -->
                <div class="overflow-x-auto max-h-96">
                    <div class="min-w-full inline-block align-middle">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs uppercase bg-[#1C204B] text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Role</th>
                                    <th scope="col" class="px-6 py-3">School ID</th>
                                </tr>
                            </thead>
                            <tbody id="candidates-table">
                                @foreach ($users as $user)
                                <tr class="border-b border-gray-700 hover:bg-[#1C204B]">
                                    <td class="px-6 py-4 font-medium whitespace-nowrap text-white">{{ $user->firstName }} {{ $user->lastName }}</td>
                                    <td class="px-6 py-4">{{ $user->role }}</td>
                                    <td class="px-6 py-4">{{ $user->school_id }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
     
        <script>
            function searchCandidates() {
                const searchValue = document.getElementById('searchInput').value.toLowerCase();
                const rows = document.querySelectorAll('#candidates-table tr');

                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            function openStudentModal() {
                document.getElementById('studentModal').classList.remove('hidden');
            }

            function openStaffModal() {
                document.getElementById('staffModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('studentModal').classList.add('hidden');
                document.getElementById('staffModal').classList.add('hidden');
            }
        </script>
    
    </div>
</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth