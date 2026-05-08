@auth
<x-admin-sidebar>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .ticket-password {
            font-family: 'Courier New', 'Consolas', monospace;
            letter-spacing: 1px;
        }
    </style>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">🎫 Ticket Management</h1>
            <p class="text-gray-300 mt-2">University of Cape Coast - Electronic Voting System</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Tickets</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Active Tickets</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Expired Tickets</p>
                        <p class="text-3xl font-bold text-red-600">{{ $stats['expired'] }}</p>
                    </div>
                    <div class="bg-red-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" id="searchInput" placeholder="🔍 Search by Voucher, Password, or School ID..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="expired">Expired</option>
                </select>
                <button onclick="window.print()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    🖨️ Print
                </button>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    📥 Export CSV
                </button>
            </div>
        </div>

        <!-- Tickets Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Voucher Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Password</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">School ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Expires At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="ticketsTableBody">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50 transition ticket-row" 
                            data-status="{{ $ticket->expire_at && $ticket->expire_at < now() ? 'expired' : 'active' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ticket->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm font-semibold text-blue-700">{{ $ticket->Voucher }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="ticket-password text-sm font-bold text-gray-800 bg-gray-100 px-2 py-1 rounded">
                                        {{ $ticket->readable_password ?? 'Unavailable' }}
                                    </span>
                                    <button onclick="copyToClipboard({{ json_encode($ticket->readable_password ?? '') }})" 
                                            class="text-gray-400 hover:text-blue-600 transition"
                                            title="Copy password">
                                        📋
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $ticket->school_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($ticket->expire_at)
                                    <span class="{{ $ticket->expire_at < now() ? 'text-red-600' : 'text-gray-600' }}">
                                        {{ \Carbon\Carbon::parse($ticket->expire_at)->format('M d, Y H:i') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Never</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $isExpired = $ticket->expire_at && $ticket->expire_at < now();
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full font-semibold 
                                    {{ $isExpired ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $isExpired ? 'Expired' : 'Active' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $ticket->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" 
                                       class="text-blue-600 hover:text-blue-800 transition" title="View">
                                        👁️
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                🎫 No tickets found. Generate some tickets to get started.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#ticketsTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function() {
            const status = this.value;
            const rows = document.querySelectorAll('.ticket-row');
            
            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                } else {
                    const rowStatus = row.getAttribute('data-status');
                    row.style.display = rowStatus === status ? '' : 'none';
                }
            });
        });
        
        // Copy password to clipboard
        function copyToClipboard(password) {
            navigator.clipboard.writeText(password).then(() => {
                // Optional: Show toast notification
                alert('Password copied: ' + password);
            });
        }
        
        // Delete ticket (confirm first)
        function deleteTicket(id) {
            if (confirm('Are you sure you want to delete this ticket?')) {
                // Submit form or AJAX request
                window.location.href = `/tickets/${id}/delete`;
            }
        }
    </script>
</body>
</x-admin-sidebar>
@else
<script>
    window.location.href = "{{ route('/student') }}";
</script>
@endauth

