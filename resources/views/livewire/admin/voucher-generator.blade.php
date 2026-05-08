@auth
<x-admin-sidebar>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        .ucc-blue {
            background-color: #1480ec;
        }
        .ucc-gold {
            background-color: #FFCC00;
        }
        .text-ucc-blue {
            color: #1480ec;
        }
        .text-ucc-gold {
            color: #FFCC00;
        }
        .border-ucc-blue {
            border-color: #003366;
        }
        .border-ucc-gold {
            border-color: #FFCC00;
        }

        /* Animation classes */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }
        .animate-bounce {
            animation: bounce 1s infinite;
        }
        .animate-fadeOut {
            animation: fadeOut 0.5s forwards;
        }

        /* Print-specific styles */
        @media print {
            body * {
                visibility: hidden;
            }
            #printableVoucher, #printableVoucher * {
                visibility: visible;
            }
            #printableVoucher {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: white;
                padding: 20px;
                box-sizing: border-box;
            }
            .no-print {
                display: none !important;
            }
            .print-logo {
                display: block !important;
            }
        }

        .print-logo {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100">
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

    <div class="min-h-screen flex flex-col items-center py-12 px-4">
        <div class="w-full max-w-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-ucc-blue">UCC-EVOTE Voucher Generator</h1>
                <p class="text-gray-600 mt-2">Generate unique voting vouchers with passwords for your team members</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('vouchers.store') }}" id="voucherForm">
                @csrf
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="school_id" class="block text-sm font-medium text-gray-700 mb-1">Index Number</label>
                            <input type="text" id="school_id" name="school_id" value="{{ old('school_id') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ucc-blue focus:border-ucc-blue" required>
                        </div>
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Person's Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ucc-blue focus:border-ucc-blue" required>
                        </div>
                        <div>
                            <label for="team" class="block text-sm font-medium text-gray-700 mb-1">Team Name</label>
                            <input type="text" id="team" name="team" value="{{ old('team') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ucc-blue focus:border-ucc-blue" required>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" id="generateBtn" class="w-full ucc-blue text-white py-3 px-6 rounded-md font-medium hover:bg-blue-800 transition duration-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Generate Voucher
                        </button>
                    </div>
                </div>
            </form>

                <!-- Voucher Display -->
                <div id="voucherContainer" class="hidden bg-white rounded-lg shadow-md p-6 mb-8 border-2 border-ucc-gold">
                    <div class="text-center">
                        <h2 class="text-xl font-bold text-ucc-blue mb-2">UCC-EVOTE Voucher</h2>
                        {{-- <h4 class="text-xl font-bold text-red-600 mb-2">"website link: vote.ucc.edu.gh"</h4> --}}
                        <p class="text-xl font-bold text-red-600 mb-2">FILL THE NOMINATION FORM USING THIS LINK: vote.ucc.edu.gh <br>
                            PLEASE BE ON UCC NETWORK TO ACCESS THIS WEBSITE</p>
                        <div class="mb-6">
                            <p class="text-gray-600">Generated for:</p>
                            <p id="displayName" class="text-lg font-semibold text-ucc-blue"></p>
                            <p class="text-gray-600 mt-1">REGISTRATION ID:</p>
                            <p id="displaySchoolId" class="text-lg font-semibold text-ucc-blue"></p>
                            <p class="text-gray-600 mt-1">Team:</p>
                            <p id="displayTeam" class="text-lg font-semibold text-ucc-blue"></p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-md mb-4">
                            <p class="text-sm text-gray-500 mb-1">Voucher Code</p>
                            <p id="voucherCode" class="text-2xl font-bold text-ucc-blue tracking-wider"></p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-md mb-6">
                            <p class="text-sm text-gray-500 mb-1">Voucher Password</p>
                            <p id="voucherPassword" class="text-2xl font-extrabold text-ucc-blue tracking-widest" style="font-family: 'Consolas', 'Fira Code', 'Source Code Pro', 'Courier New', monospace;">
                            </p>
                            <p class="text-xs text-gray-500 mt-2">(This password is required to use the voucher)</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-center gap-4 no-print">
                            <button type="button" id="printBtn" class="bg-white border border-ucc-blue text-ucc-blue py-2 px-6 rounded-md font-medium hover:bg-gray-50 transition duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Voucher
                            </button>
                        </div>
                    </div>
                </div>
        </div>

        <footer class="mt-auto text-center text-gray-500 text-sm py-4">
            &copy; {{ date('Y') }} University of Cape Coast - eVote System
        </footer>
    </div>

    <!-- Printable Voucher Template -->
    <div id="printableVoucher" class="hidden">
        <div class="p-8 max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <img src="{{ asset('images/ucc.png') }}" alt="UCC Logo" class="h-16 print-logo">
                <div class="text-right">
                    <h1 class="text-2xl font-bold text-ucc-blue">UCC-EVOTE</h1>
                    <p class="text-sm text-gray-600">Official Voting Voucher</p>
                </div>
            </div>
            
            <div class="border-t-2 border-b-2 border-ucc-gold py-6 my-6">
                <h2 class="text-xl font-bold text-center text-ucc-blue mb-6">VOTING VOUCHER</h2>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600">Issued To:</p>
                        <p id="printName" class="text-lg font-semibold text-ucc-blue"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">index number:</p>
                        <p id="printSchoolId" class="text-lg font-semibold text-ucc-blue"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Team/Position:</p>
                        <p id="printTeam" class="text-lg font-semibold text-ucc-blue"></p>
                    </div>
                </div>
                
                <div class="bg-gray-100 p-4 rounded-md mb-4">
                    <p class="text-sm text-gray-600 mb-1">VOUCHER CODE</p>
                    <p id="printCode" class="text-2xl font-bold text-ucc-blue tracking-wider"></p>
                </div>
                
                <div class="bg-gray-100 p-4 rounded-md">
                    <p class="text-sm text-gray-600 mb-1">SECRET PASSWORD</p>
                    <p id="printPassword" class="text-2xl font-extrabold text-ucc-blue tracking-widest" style="font-family: 'Roboto';">
                    </p>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <p class="text-sm text-gray-600">This voucher is required for the UCC electronic voting process.</p>
                <p class="text-sm text-gray-600 mt-2">Keep this information secure and do not share with unauthorized persons.</p>
                
                <div class="mt-8 pt-4 border-t border-gray-300">
                    <p class="text-xs text-gray-500">Generated on: <span id="printDate"></span></p>
                    <p class="text-xs text-gray-500 mt-1">© University of Cape Coast - Electoral Commission</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const generateBtn = document.getElementById('generateBtn');
            const voucherContainer = document.getElementById('voucherContainer');
            const displayName = document.getElementById('displayName');
            const displaySchoolId = document.getElementById('displaySchoolId');
            const displayTeam = document.getElementById('displayTeam');
            const voucherCode = document.getElementById('voucherCode');
            const voucherPassword = document.getElementById('voucherPassword');
            const printBtn = document.getElementById('printBtn');
            const nameInput = document.getElementById('name');
            const teamInput = document.getElementById('team');
            const schoolIdInput = document.getElementById('school_id');
            const form = document.getElementById('voucherForm');
            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                const name = nameInput.value.trim();
                const team = teamInput.value.trim();
                const schoolId = schoolIdInput.value.trim();

                if (!name || !team || !schoolId) {
                    alert('Please enter name, team, and school ID');
                    return;
                }

                try {
                    generateBtn.disabled = true;
                    // Send data to the server
                    const response = await fetch("{{ route('vouchers.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            name: name,
                            team: team,
                            school_id: schoolId
                        })
                    });

                    const result = await response.json().catch(() => ({}));

                    if (!response.ok || !result.success) {
                        throw new Error(result.message || 'Failed to store voucher information.');
                    }

                    const voucherData = result.data;

                    // Display values
                    displayName.textContent = voucherData.name;
                    displaySchoolId.textContent = voucherData.school_id;
                    displayTeam.textContent = voucherData.team;
                    voucherCode.textContent = voucherData.voucher_code;
                    voucherPassword.textContent = voucherData.password;

                    voucherContainer.classList.remove('hidden');
                } catch (error) {
                    alert(error.message);
                } finally {
                    generateBtn.disabled = false;
                }
            });

            printBtn.addEventListener('click', function() {
                if (!voucherContainer.classList.contains('hidden')) {
                    // Update printable voucher content
                    document.getElementById('printName').textContent = displayName.textContent;
                    document.getElementById('printSchoolId').textContent = displaySchoolId.textContent;
                    document.getElementById('printTeam').textContent = displayTeam.textContent;
                    document.getElementById('printCode').textContent = voucherCode.textContent;
                    document.getElementById('printPassword').textContent = voucherPassword.textContent;
                    document.getElementById('printDate').textContent = new Date().toLocaleString();

                    // Show printable voucher and hide everything else
                    document.getElementById('printableVoucher').classList.remove('hidden');

                    // Print only the voucher content
                    window.print();

                    // Hide printable voucher again
                    document.getElementById('printableVoucher').classList.add('hidden');
                }
            });

        });
    </script>
</body>

</x-admin-sidebar>
@else
<script>
    window.location.href = "{{ route('/student') }}";
</script>
@endauth
