@auth('candidates')
<x-candidate-sidebar>
    <div x-data="{ showForm: true, resetForm: false }" class="max-w-4xl mx-auto p-7 bg-white rounded-lg shadow-md m-10">
        <h1 class="text-2xl font-semibold text-gray-700">Edit Profile</h1>
        
        <template x-if="showForm">
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display Error Messages -->
            @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('profile.candidate.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-7" x-show="showForm" :class="{'hidden': !showForm}">
                @csrf
                <!-- Profile Picture Section -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img class="w-24 h-24 rounded-full object-cover" src="{{ asset('storage/' . auth('candidates')->user()->image_path) }}" alt="Profile Picture">
                        <label for="profile-picture" class="absolute bottom-0 right-0 p-1 bg-blue-500 rounded-full text-white cursor-pointer hover:bg-blue-600">
                            <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path d="M16 12a4 4 0 1 0-8 0 4 4 0 1 0 8 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M10 6v4m0 4v4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </label>
                        <input id="profile-picture" type="file" name="image" class="hidden" accept="image/*">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Upload Profile Picture</label>
                        <p class="text-xs text-gray-500">Recommended size: 150x150px</p>
                    </div>
                </div>

                

               

                <!-- Password Section -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" class="mt-1 block w-full px-4 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="••••••••">
                </div>
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Password Confirmation Section -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="mt-1 block w-full px-4 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="••••••••">
                </div>
                @error('password_confirmation')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                
                

                <!-- Bio Section -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Biography</label>
                    <textarea id="bio" name="biography" rows="4" class="mt-1 block w-full px-4 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="{{ auth('candidates')->user()->biography }}">{{ old('biography', auth('candidates')->user()->biography) }}</textarea>
                </div>
                @error('biography')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Save and Cancel Buttons -->
                <div class="flex justify-end space-x-4">
                    <!-- Cancel Button -->
                    <button type="button" @click="showForm = false" class="px-6 py-2 bg-gray-400 text-white text-sm font-medium rounded-md hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <!-- Save Button -->
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </template>
    </div>
</x-candidate-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth 



