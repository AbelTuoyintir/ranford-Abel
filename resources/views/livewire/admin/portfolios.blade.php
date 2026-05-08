@auth
<x-admin-sidebar>
    <div class="bg-gray-800">
        <!-- Main Container -->
        <div class="container mx-auto p-8">
            
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
    
            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-bold text-white">Portfolio Management</h1>
                <p class="text-white">Manage election portfolios like President, Vice President, etc.</p>
            </div>
    
            <!-- Create Portfolio Form -->
            <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Create New Portfolio</h2>
                <p>Please note that you don't need to type the 'Department' or 'Poll Type'to the name manually, as the system will automatically handle this for you. </p>
                <form id="portfolio-form" class="space-y-4" action="{{ route('portfolios.create') }}" method="POST">
                    @csrf
                    <div>
                        <label for="portfolio-name" class="block text-gray-700">Portfolio Name</label>
                        <input type="text" name="name" id="portfolio-name" placeholder="Enter portfolio name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}">
                        @error('name')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="portfolio-description" class="block text-gray-700">Description</label>
                        <textarea id="portfolio-description" name="description" placeholder="Enter portfolio description" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3">{{ old('description') }}</textarea>
                        @error('description')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="portfolio-type" class="block text-gray-700">Type</label>
                        <select id="portfolio-type" name="type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="UCC GENERAL VOTING" {{ old('type') == 'UCC GENERAL VOTING' ? 'selected' : '' }}>General Election</option>
                            <option value="SPECIAL VOTING" {{ old('type') == 'SPECIAL VOTING' ? 'selected' : '' }}>Special Voting</option>
                            <option value="HALL" {{ old('type') == 'HALL' ? 'selected' : '' }}>HALL</option>
                            <option value="DEPARTMENT" {{ old('type') == 'DEPARTMENT' ? 'selected' : '' }}>DEPARTMENT</option>
                        </select>
                        @error('type')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Create Portfolio</button>
                </form>
            </div>
    
            <!-- Search Bar -->
            <div class="mb-4">
                <input type="text" id="search" placeholder="Search portfolios..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
    
            <!-- Portfolios Table -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Portfolios List</h2>
                <table class="min-w-full table-auto" id="portfolios-table">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-left text-gray-700">Name</th>
                            <th class="px-4 py-2 text-left text-gray-700">Description</th>
                            <th class="px-4 py-2 text-left text-gray-700">Type</th>
                            <th class="px-4 py-2 text-left text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($portfolios as $portfolio)
                            <tr>
                                <td class="px-4 py-2 text-gray-700">{{ $portfolio->name }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $portfolio->description }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $portfolio->type }}</td>
                                <td class="px-4 py-2 text-gray-700">
                                    <!-- Edit and Delete Actions -->
                                    <button onclick="openEditModal({{ $portfolio->id }}, '{{ $portfolio->name }}', '{{ $portfolio->description }}', '{{ $portfolio->type }}')" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Edit</button>
                                    <form action="{{ route('portfolios.destroy', $portfolio->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
                
            </div>
            <!-- Pagination -->
            <div class="mt-4 " >
                {{ $portfolios->links() }}
            </div>
        </div>
    </div>

    <!-- JavaScript for Table Search -->
    <script>
        const searchInput = document.getElementById('search');
        const tableRows = document.querySelectorAll('#portfolios-table tbody tr');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const columns = row.getElementsByTagName('td');
                let rowText = '';

                // Combine all column text for the row
                Array.from(columns).forEach(column => {
                    rowText += column.textContent.toLowerCase();
                });

                // Check if the row matches the search term
                if (rowText.includes(searchTerm)) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        });
    </script>

    <!-- Edit Portfolio Modal -->
    <div id="edit-modal" class="fixed ml-[650px] mt-[300px] inset-0 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Portfolio</h2>
            <form id="edit-form" class="space-y-4" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit-name" class="block text-gray-700">Portfolio Name</label>
                    <input type="text" id="edit-name" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="edit-description" class="block text-gray-700">Description</label>
                    <textarea id="edit-description" name="description" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                </div>
                <div>
                    <label for="edit-type" class="block text-gray-700">Type</label>
                    <select id="edit-type" name="type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="UCC GENERAL VOTING">General Election</option>
                        <option value="SPECIAL VOTING">Special Voting</option>
                        <option value="HALL">HALL</option>
                        <option value="DEPARTMENT">DEPARTMENT</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Save Changes</button>
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">Cancel</button>
            </form>
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function openEditModal(id, name, description, type) {
            document.getElementById('edit-modal').classList.remove('hidden');
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-type').value = type;
            document.getElementById('edit-form').action = '/portfolios/' + id;
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }
    </script>
</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth