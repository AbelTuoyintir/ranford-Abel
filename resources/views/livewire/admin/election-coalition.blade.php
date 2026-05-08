@auth
<x-admin-sidebar>

    <style>
        .candidate-card {
            transition: all 0.3s ease;
        }
        .candidate-card:hover {
            transform: translateY(-5px);
        }
    </style>


<body class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-green-800 text-white shadow-md">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">UCC Election Tracker</h1>
                    <p class="text-lg mt-2">University of Cape Coast Student Representative Council Elections</p>
                </div>
                <div class="hidden md:block">
                    <img src="{{asset('images/logo.png')}}" alt="UCC Logo" class="h-16 w-16 rounded-full bg-white p-1"/>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-9 py-8">
        <div class="space-y-6">
            @foreach ($Archievepolls as $Archievepoll)
                <x-coalition-accordion :poll="$Archievepoll" />
            @endforeach
        </div>
    </main>
    

</body>
  
</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth
