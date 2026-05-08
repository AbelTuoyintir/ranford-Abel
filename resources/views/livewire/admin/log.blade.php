@auth
<x-admin-sidebar>
    <div class="container mx-auto my-8 px-4">
        <h1 class="text-3xl font-bold text-center text-gray-100 mb-6">Election App Log Table</h1>
        
        <!-- Search Bar and Select Dropdown in Same Line -->
        <div class="mb-4 flex justify-center items-center space-x-4">
            <!-- Search Bar -->
            <input type="text" id="search" placeholder="Search logs..." 
                class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                onkeyup="filterLogs()">
            
            <!-- Select Dropdown for Event Type -->
            <select id="eventFilter" class="px-5 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="filterLogs()">
                <option value="">All</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>

            </select>
        </div>

        <!-- Log Table -->
        <div class="overflow-x-auto text-gray-500 dark:text-gray-900 shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Session ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">User ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">IP Address</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">User Agent</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Payload</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Last Activity</th>
                    </tr>
                </thead>
                <tbody id="logTableBody">
                    @foreach($sessions as $session)
                    <tr class="border-t border-gray-100 hover:bg-gray-600">
                        <td class="px-6 py-4 text-sm text-white break-words">{{$session->id}}</td>
                        <td class="px-6 py-4 text-sm text-green-600 break-words">{{$session->user_id}}</td>
                        <td class="px-6 py-4 text-sm text-green-600 break-words">{{$session->ip_address}}</td>
                        <td class="px-6 py-4 text-sm text-white break-words">{{$session->user_agent}}</td>
                        <td class="px-6 py-4 text-sm text-white break-words word-wrap">{{ Str::words($session->payload,5)}}</td>
                        <td class="px-6 py-4 text-sm text-white break-words">{{$session->status}}</td>
                        <td class="px-6 py-4 text-sm text-white break-words">{{$session->last_activity}} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        </div>
    </div>

    <script>
        // Function to filter the logs based on search input and selected event type
        function filterLogs() {
            const searchInput = document.getElementById('search').value.toLowerCase();
            const eventFilter = document.getElementById('eventFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#logTableBody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const id = cells[0].innerText.toLowerCase();
                const user_id = cells[1].innerText.toLowerCase();
                const ip = cells[3].innerText.toLowerCase();
                const status = cells[5].innerText.toLowerCase();
           
                // const user = cells[5].innerText.toLowerCase();
                // const ip = cells[6].innerText.toLowerCase();

                // Check if the row matches either the search input or the selected event type
                if (
                    (id.includes(eventFilter) || eventFilter === '') &&
                    (id.includes(searchInput) || user_id.includes(searchInput) || status.includes(searchInput) || ip.includes(searchInput))
                ) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth