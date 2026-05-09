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
    
        <!-- Disqualification Modal -->
        <div id="disqualifyModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Disqualify Nominee</h3>
                    <div class="mt-2 px-7 py-3">
                        <form action="{{ route('nominees.disqualify', $nominee->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mb-4">
                                <label for="rejection_reason" class="block text-sm font-medium text-gray-700 text-left mb-1">Reason for disqualification:</label>
                                <textarea id="rejection_reason" name="rejection_reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></textarea>
                            </div>
                            <div class="items-center px-4 py-3">
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                    Confirm Disqualification
                                </button>
                                <button type="button" onclick="closeDisqualifyModal()" class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <script>
            // Auto-dismiss for success prompt
            setTimeout(() => {
                const successMessage = document.querySelector('.success-prompt');
                if (successMessage) {
                    successMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }
            }, 5000);
    
            // Auto-dismiss for error prompt
            setTimeout(() => {
                const errorMessage = document.querySelector('.error-prompt');
                if (errorMessage) {
                    errorMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
                    setTimeout(() => {
                        errorMessage.remove();
                    }, 500);
                }
            }, 5000);
    
            // Disqualification modal functions
            function openDisqualifyModal() {
                document.getElementById('disqualifyModal').classList.remove('hidden');
            }
    
            function closeDisqualifyModal() {
                document.getElementById('disqualifyModal').classList.add('hidden');
            }
        </script>
    </div>
    
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Status Banner -->
                <div class="bg-{{ $nominee->status === 'approved' ? 'green' : ($nominee->status === 'rejected' ? 'red' : 'blue') }}-500 px-4 py-2">
                    <div class="flex items-center justify-between">
                        <span class="text-white font-medium">
                            Status: {{ ucfirst($nominee->status) }}
                        </span>
                        <span class="text-white text-sm">
                            Applied: {{ $nominee->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
    
                <!-- Rejection Reason (if rejected) -->
                @if($nominee->status === 'rejected' && $nominee->rejection_reason)
                <div class="bg-red-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-red-800 mb-2">Disqualification Reason</h3>
                    <p class="text-red-600">{{ $nominee->rejection_reason }}</p>
                </div>
                @endif
    
                <!-- Profile Section -->
                <div class="px-6 py-4 border-b">
                    <div class="flex flex-col md:flex-row">
                        <!-- Photo Column -->
                        <div class="md:w-1/4 flex flex-col items-center">
                            <div class="relative mb-4">
                                <img src="{{ $nominee->photo_path ?? '/images/default-profile.png' }}" 
                                     alt="{{ $nominee->full_name }}" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white shadow">
                                <span class="absolute bottom-2 right-2 w-5 h-5 bg-{{ $nominee->verified ? 'green' : 'red' }}-500 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="text-center">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                    {{ ucfirst($nominee->role) }}
                                </span>
                            </div>
                        </div>
    
                        <!-- Details Column -->
                        <div class="md:w-3/4 md:pl-8 mt-4 md:mt-0">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $nominee->full_name }}</h2>
                            <p class="text-gray-600">{{ $nominee->position }}</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Registration Number</h3>
                                    <p class="mt-1 text-gray-900">{{ $nominee->reg_number }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">CGPA</h3>
                                    <p class="mt-1 text-gray-900">{{ $nominee->nominee_cgpa }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Hall</h3>
                                    <p class="mt-1 text-gray-900">{{ $nominee->hall }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Program</h3>
                                    <p class="mt-1 text-gray-900">{{ $nominee->program }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                                    <p class="mt-1 text-gray-900">{{ $nominee->phone }}</p>
                                </div>
                                {{-- <div>
                                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                                    <p class="mt-1 text-gray-900">{{ $nominee->email ?? 'Not provided' }}</p>
                                </div> --}}
                            </div>
                            <div>
                                    <label for="portfolio" class="text-xs font-medium text-gray-500">Change Portfolio</label>
                                    <form action="{{ route('nominees.updatePortfolio', $nominee->id) }}" method="POST" class="mt-1">
                                        @csrf
                                        @method('PATCH')
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Portfolio:</label>
                                            <select name="position" id="portfolio" class="w-full p-2 border border-gray-300 rounded-md" required>
                                                <option value="">Select Portfolio</option>
                                                <optgroup label="SRC Positions">
                                                    <option value="SRC President" {{ $nominee->position == 'SRC President' ? 'selected' : '' }}>SRC President</option>
                                                    <option value="SRC Secretary" {{ $nominee->position == 'SRC Secretary' ? 'selected' : '' }}>SRC Secretary</option>
                                                    <option value="SRC Treasurer" {{ $nominee->position == 'SRC Treasurer' ? 'selected' : '' }}>SRC Treasurer</option>
                                                    <option value="SRC General Sports Secretary" {{ $nominee->position == 'SRC General Sports Secretary' ? 'selected' : '' }}>SRC General Sports Secretary</option>
                                                    <option value="SRC Coordinating Secretary" {{ $nominee->position == 'SRC Coordinating Secretary' ? 'selected' : '' }}>SRC Coordinating Secretary</option>
                                                    <option value="SRC Public Relations Officer" {{ $nominee->position == 'SRC Public Relations Officer' ? 'selected' : '' }}>SRC Public Relations Officer</option>
                                                    <option value="SRC Women's Commissioner" {{ $nominee->position == "SRC Women's Commissioner" ? 'selected' : '' }}>SRC Women's Commissioner</option>
                                                </optgroup>

                                                <optgroup label="Local NUGS Positions">
                                                    <option value="Local NUGS President" {{ $nominee->position == 'Local NUGS President' ? 'selected' : '' }}>Local NUGS President</option>
                                                    <option value="Local NUGS Secretary" {{ $nominee->position == 'Local NUGS Secretary' ? 'selected' : '' }}>Local NUGS Secretary</option>
                                                </optgroup>

                                                <optgroup label="JCRC Positions">
                                                    <option value="JCRC President" {{ $nominee->position == 'JCRC President' ? 'selected' : '' }}>JCRC President</option>
                                                    <option value="JCRC Secretary" {{ $nominee->position == 'JCRC Secretary' ? 'selected' : '' }}>JCRC Secretary</option>
                                                    <option value="JCRC Treasurer" {{ $nominee->position == 'JCRC Treasurer' ? 'selected' : '' }}>JCRC Treasurer</option>
                                                    <option value="JCRC Welfare Chairperson" {{ $nominee->position == 'JCRC Welfare Chairperson' ? 'selected' : '' }}>JCRC Welfare Chairperson</option>
                                                    <option value="JCRC Sport Secretary" {{ $nominee->position == 'JCRC Sport Secretary' ? 'selected' : '' }}>JCRC Sport Secretary</option>
                                                    <option value="JCRC Library Chairperson" {{ $nominee->position == 'JCRC Library Chairperson' ? 'selected' : '' }}>JCRC Library Chairperson</option>
                                                    <option value="JCRC SRC Representative(s)" {{ $nominee->position == 'JCRC SRC Representative(s)' ? 'selected' : '' }}>JCRC SRC Representative(s)</option>
                                                </optgroup>

                                                <optgroup label="GRASAG Positions">
                                                    <option value="GRASAG President" {{ $nominee->position == 'GRASAG President' ? 'selected' : '' }}>GRASAG President</option>
                                                    <option value="GRASAG Secretary" {{ $nominee->position == 'GRASAG Secretary' ? 'selected' : '' }}>GRASAG Secretary</option>
                                                    <option value="GRASAG Treasurer" {{ $nominee->position == 'GRASAG Treasurer' ? 'selected' : '' }}>GRASAG Treasurer</option>
                                                    <option value="GRASAG Financial Secretary" {{ $nominee->position == 'GRASAG Financial Secretary' ? 'selected' : '' }}>GRASAG Financial Secretary</option>
                                                    <option value="GRASAG Organising Secretary" {{ $nominee->position == 'GRASAG Organising Secretary' ? 'selected' : '' }}>GRASAG Organising Secretary</option>
                                                    <option value="GRASAG Women's Commissioner" {{ $nominee->position == "GRASAG Women's Commissioner" ? 'selected' : '' }}>GRASAG Women's Commissioner</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                            Change Portfolio
                                        </button>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
    
                <!-- Running Mate Section -->
                @if($nominee->runningMate)
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Running Mate</h3>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <img src="{{ $nominee->runningMate->running_mates_photo_path ?? '/images/default-profile.png' }}" 
                                 alt="{{ $nominee->runningMate->running_mates_full_name }}" 
                                 class="w-16 h-16 rounded-full object-cover border-2 border-white shadow mr-4">
                            <div>
                                <h4 class="font-semibold">{{ $nominee->runningMate->running_mates_full_name }}</h4>
                                <p class="text-sm text-gray-600">{{ $nominee->runningMate->running_mates_reg_number }}</p>
                                <p class="text-sm text-gray-600">{{ $nominee->runningMate->running_mates_program }}</p>
                                <p class="text-sm text-gray-600">cgpa • {{ $nominee->runningMate->running_mates_cgpa }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <h5 class="text-xs font-medium text-gray-500">Hall</h5>
                                <p>{{ $nominee->runningMate->running_mates_hall }}</p>
                            </div>
                            <div>
                                <h5 class="text-xs font-medium text-gray-500">Phone</h5>
                                <p>{{ $nominee->runningMate->running_mates_phone }}</p>
                            </div>

                            
                        </div>
                        
                    </div>
                </div>
                @endif
    
                <!-- Supporters Section -->
                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">GUARANTORS ({{ $nominee->supporters->count() }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($nominee->supporters as $supporter)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <img src="{{ $supporter->id_copy_path ?? '/images/default-profile.png' }}" 
                                     alt="{{ $supporter->name }}" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-white shadow mr-3">
                                <div>
                                    <h4 class="font-semibold">{{ $supporter->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $supporter->reg_number }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                                <div>
                                    <h5 class="text-xs font-medium text-gray-500">Department</h5>
                                    <p>{{ $supporter->program }}</p>
                                </div>
                                <div>
                                    <h5 class="text-xs font-medium text-gray-500">Phone</h5>
                                    <p>{{ $supporter->phone }}</p>
                                </div>
                                <div>
                                    <h5 class="text-xs font-medium text-gray-500">Verified</h5>
                                    <p class="{{ $supporter->verified ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $supporter->verified ? 'Yes' : 'No' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 text-center py-8 text-gray-500">
                            No supporters registered yet
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Submitted Documents</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6" >
                    @foreach($nominee->documents as $document)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium capitalize">{{ str_replace('_', ' ', $document->type) }}</h4>
                            <span class="text-xs px-2 py-1 rounded-full {{ $document->verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $document->verified ? 'Verified' : 'Pending' }}
                            </span>
                        </div>
                        
                        @if(in_array($document->type, ['passport_photo', 'medical_report']))
                            <!-- Image preview -->
                            <div class="mt-2">
                                <img src="{{ route('secure.document', $document) }}" 
                                     alt="{{ str_replace('_', ' ', $document->type) }}"
                                     class="w-full h-auto rounded border border-gray-300 cursor-pointer hover:shadow-md transition"
                                     onclick="openModal('{{ route('secure.document', $document) }}', '{{ str_replace('_', ' ', $document->type) }}')">
                            </div>
                        @else
                            <!-- Document download -->
                            <div class="mt-2">
                                <a href="{{ route('secure.document', $document) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download {{ ucfirst(str_replace('_', ' ', $document->type)) }}
                                </a>
                            </div>
                        @endif
                        
                        @if(!$document->verified && auth()->user()->role== 'admin')
                            <div class="mt-3 flex space-x-2">
                                <form action="{{ route('documents.verify', $document->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded hover:bg-green-200">
                                        Verify
                                    </button>
                                </form>
                                <form action="{{ route('documents.reject', $document->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            


<!-- Image Preview Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-4xl max-h-screen overflow-auto">
        <div class="flex justify-between items-center border-b p-4">
            <h3 id="modalTitle" class="text-lg font-medium"></h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[70vh] mx-auto">
        </div>
    </div>
</div>

   
    
            <!-- Action Buttons -->
            <div class="mt-6 flex flex-col sm:flex-row gap-2">
                @if($nominee->status == 'rejected')
                <form action="{{ route('nominees.requalify', $nominee->id) }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="status" value="saved">
                    <button type="submit" class=" h-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-md shadow flex items-center justify-center">
                        Reapprove {{ ucfirst($nominee->role) }}
                    </button>
                </form>
                @endif
            
                @if($nominee->status !== 'rejected')
                <button onclick="openDisqualifyModal()" class="h-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-md shadow flex items-center justify-center">
                    Disqualify
                </button>
                @endif
            
                <a href="{{ route('nomination-management') }}" class="h-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow flex items-center justify-center">
                    Back to List
                </a>
            </div>
        </div>
    </div>
    <script>
        // Image modal functions
        function openModal(imageSrc, title) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>
</x-admin-sidebar>

@else
<script>
    window.location.href = "{{ route('student') }}";
</script>
@endauth