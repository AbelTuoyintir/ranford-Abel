@auth
<x-admin-sidebar>

    <div class="container mx-auto my-8 px-4">
        <h1 class="text-3xl font-bold text-center text-gray-100 mb-6">Election App Log Table</h1>
        
        <!-- Search Bar, Select Dropdown, and Download Button -->
        <div class="mb-4 flex justify-center items-center space-x-4">
            <!-- Search Bar -->
            <input type="text" id="search" placeholder="Search logs..." 
                class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                onkeyup="filterLogs()">
            
            <!-- Select Dropdown for Event Type -->
            <select id="eventFilter" class="px-5 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="filterLogs()">
                <option value="">All</option>
                <option value="Vote Submitted">Vote Submitted</option>
                <option value="login">login</option>
                <option value="logout">logout</option>
            </select>

            <!-- Download Logs Button -->
            <button onclick="downloadLogs()" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Download Logs
            </button>
        </div>

        <!-- Log Table -->
        <div class="overflow-x-auto text-gray-500 dark:text-gray-900 shadow-md rounded-lg">
            <table class="min-w-full table-auto" id="logTable">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">User ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">User School ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Session ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Action</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Details</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Created AT</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Update AT</th>
                    </tr>
                </thead>
                <tbody id="logTableBody">
                    @foreach($user_activities as $user_activitie)
                    <!-- Example Log Entries -->
                    <tr class="border-t border-gray-100 hover:bg-gray-600">
                        <td class="px-6 py-4 text-sm text-white">{{$user_activitie->id}}</td>
                        <td class="px-6 py-4 text-sm text-green-600">{{$user_activitie->user_id}}</td>
                        <td class="px-6 py-4 text-sm text-white">{{$user_activitie->school_id}}</td>
                        <td class="px-6 py-4 text-sm text-white">{{$user_activitie->session_id}}</td>
                        <td class="px-6 py-4 text-sm text-white">{{$user_activitie->action}}</td>
                        <td class="px-6 py-4 text-sm text-white">{{$user_activitie->details}}</td>
                        <td class="px-6 py-4 text-sm text-white">{{$user_activitie->created_at}}</td>
                        <td class="px-6 py-4 text-sm text-white">{{$user_activitie->updated_at}}</td>
                    </tr>
                   @endforeach
                </tbody>
            </table>
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
                // const eventType = cells[1].innerText.toLowerCase();
                // const details = cells[2].innerText.toLowerCase();
                // const user = cells[3].innerText.toLowerCase();
                // const ip = cells[4].innerText.toLowerCase();
                const school_id = cells[2].innerText.toLowerCase();
                const session_id = cells[3].innerText.toLowerCase();
                const action = cells[4].innerText.toLowerCase();
                const details = cells[5].innerText.toLowerCase();

                // Check if the row matches either the search input or the selected event type
                if (
                    (action.includes(eventFilter) || eventFilter === '') &&
                    (action.includes(searchInput) || details.includes(searchInput) || session_id.includes(searchInput) || school_id.includes(searchInput))
                ) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Function to download the log table data as a CSV file
        function downloadLogs() {
            const table = document.getElementById('logTable');
            const rows = Array.from(table.querySelectorAll('tr'));
            const csv = rows.map(row => {
                const cells = Array.from(row.querySelectorAll('td, th'));
                return cells.map(cell => cell.innerText).join(',');
            }).join('\n');

            const csvBlob = new Blob([csv], { type: 'text/csv' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(csvBlob);
            link.download = 'election_logs.csv';
            link.click();
        }
    </script>

</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth