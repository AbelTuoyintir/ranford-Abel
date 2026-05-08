@auth
<x-admin-sidebar>



   
    <style>
        * { font-family: 'Inter', sans-serif; }

        .ucc-blue { color: #003366; }
        .bg-ucc-blue { background-color: #003366; }
        .border-ucc-blue { border-color: #003366; }
        .text-ucc-blue { color: #003366; }
        .bg-ucc-gold { background-color: #C5A059; }
        .border-ucc-gold { border-color: #C5A059; }
        .text-ucc-gold { color: #C5A059; }

        .password-font {
            font-family: 'SF Mono', 'Consolas', 'Fira Code', 'Source Code Pro', 'Courier New', monospace;
            font-weight: 700;
            letter-spacing: 2px;
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; margin: 0; }
            .voucher-card { box-shadow: none; border: 2px solid #C5A059; }
        }

        .copy-btn {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .copy-btn:hover { transform: scale(1.1); color: #003366; }
        .copy-btn:active { transform: scale(0.95); }
    </style>
@php
    $expiresAt = $ticket->expire_at ? \Carbon\Carbon::parse($ticket->expire_at) : null;
    $isExpired = $expiresAt ? now()->greaterThan($expiresAt) : false;
    $displayName = $ticket->name ?? ($nominee->full_name ?? 'N/A');
    $displayTeam = $ticket->team ?? ($nominee->position ?? 'N/A');
    $displayPassword = session('new_password') ?? $ticket->readable_password ?? 'Unavailable';
@endphp
<body class="bg-gray-100">
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-4xl mx-auto">

            

            <div class="voucher-card bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-ucc-gold">
                @if(session('success'))
                    <div class="bg-green-100 border-b border-green-200 px-6 py-3 text-green-800 text-sm font-medium no-print">
                        {{ session('success') }}
                        @if(session('new_password'))
                            <span class="ml-2 font-bold">New Password: {{ session('new_password') }}</span>
                        @endif
                    </div>
                @endif
                <div class="bg-gradient-to-r from-ucc-blue to-blue-800 px-6 py-3 text-white">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium">OFFICIAL VOTING TICKET</span>
                        <span id="statusBadge" class="text-xs px-2 py-1 rounded-full {{ $isExpired ? 'bg-red-500' : 'bg-green-500' }}">
                            {{ $isExpired ? 'Expired' : 'Active' }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-ucc-blue uppercase tracking-wide">UCC-EVOTE Voucher</h2>
                        <div class="flex justify-center mt-2">
                            <div class="w-16 h-0.5 bg-ucc-gold"></div>
                        </div>
                    </div>

                   

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Issued To</p>
                            <p id="displayName" class="text-lg font-bold text-ucc-blue mt-1">{{ $displayName }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Registration ID</p>
                            <p id="displaySchoolId" class="text-lg font-bold text-ucc-blue mt-1">{{ $ticket->school_id }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Team / Position</p>
                            <p id="displayTeam" class="text-lg font-bold text-ucc-blue mt-1">{{ $displayTeam }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-200">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Voucher Code</p>
                            <div class="flex items-center justify-between">
                                <p id="voucherCode" class="text-xl font-bold text-ucc-blue tracking-wider font-mono break-all">{{ $ticket->Voucher }}</p>
                                <button onclick="copyToClipboard('voucherCode', 'Voucher code')" class="copy-btn text-gray-400 hover:text-ucc-blue transition ml-2" title="Copy voucher code">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                       
                    </div>

                    

                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-amber-800">Expires:</span>
                                <span id="expiryDate" class="text-sm font-bold text-amber-900">
                                    {{ $expiresAt ? $expiresAt->format('M d, Y h:i A') : 'No expiry set' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-amber-800">Generated:</span>
                                <span id="generatedDate" class="text-sm text-amber-900">{{ $ticket->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center text-xs text-gray-500 pt-4 border-t border-gray-200">
                        <p>This voucher is required for the UCC electronic voting process.</p>
                        <p class="mt-1">Keep this information secure and do not share with unauthorized persons.</p>
                        <p class="mt-3">&copy; {{ now()->year }} University of Cape Coast - Electoral Commission</p>
                    </div>
                </div>
            </div>

           
        </div>
    </div>

    <script>
        async function copyToClipboard(elementId, label) {
            const element = document.getElementById(elementId);
            const text = element.textContent;

            try {
                await navigator.clipboard.writeText(text);
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                toast.textContent = label + ' copied!';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 2000);
            } catch (err) {
                alert('Failed to copy. Please manually select the text.');
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
