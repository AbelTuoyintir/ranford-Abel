<x-admin-sidebar>
    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4 text-white">Update Student Email</h1>

        <!-- Search -->
        <form action="{{ route('students.search') }}" method="GET" class="mb-6">
            <input name="school_id" placeholder="Enter School ID" class="border p-2 rounded w-full" value="{{ request('school_id') }}">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">Search</button>
        </form>

        <!-- Flash Message -->
        @if(session('status'))
            <div class="mb-4 p-3 rounded 
                {{ session('status')['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ session('status')['message'] }}
            </div>
        @endif

        <!-- Student Info -->
        @if(isset($student))
<div class="p-6 border rounded-lg mb-6 bg-gray-50 shadow-sm">
    <div class="flex items-start space-x-4">
        <!-- Profile Icon/SVG -->
        <div class="flex-shrink-0">
            <img src="{{$student->image}}" alt="" class="h-16 w-16 text-gray-400">
        </div>
        
        <!-- Student Info -->
        <div class="space-y-2">
            <h3 class="text-lg font-semibold text-gray-900">
                {{ $student->firstName }} 
                @if($student->middleName) {{ $student->middleName }} @endif
                {{ $student->lastName }}
            </h3>
            
            <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                <div class="flex items-center">
                    <svg class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    <span class="font-medium">ID:</span> {{ $student->school_id }}
                </div>
                
                <div class="flex items-center">
                    <svg class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium">Email:</span> 
                    @if($student->email)
                        {{ $student->email }}
                    @else
                        <span class="text-yellow-600">No email registered</span>
                    @endif
                </div>
                
                <div class="flex items-center">
                    <svg class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="font-medium">Department:</span> {{ $student->Program }}
                </div>
                
                <div class="flex items-center">
                    <svg class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="font-medium">Level:</span> {{ $student->level ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Update Form -->
<form action="{{ route('students.update-email', $student->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                New Email Address
            </div>
        </label>
        <input 
            type="email" 
            name="email" 
            id="email" 
            value="{{ old('email', $student->email) }}" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
            placeholder="student@university.edu"
            required
        >
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Update Email
        </button>
    </div>
</form>
@endif
    </div>
</x-admin-sidebar>
