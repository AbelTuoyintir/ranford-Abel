@auth
<x-admin-sidebar>
  <style>
      @keyframes fadeIn {
          from { opacity: 0; transform: translateY(10px); }
          to { opacity: 1; transform: translateY(0); }
      }
      .fade-in {
          animation: fadeIn 0.3s ease-in-out;
      }
      .ip-card:hover {
          transform: translateY(-3px);
          box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      }
      .edit-form {
          display: none; /* Hide the edit form by default */
      }
  </style>
  <body class="bg-gray-100 min-h-screen">
      <div class="container mx-auto px-4 py-8">
          <!-- Flash Error Message -->
          @if(session('success') || session('error'))
              <div class="fixed top-4 left-4 z-50">
                  @if(session('success'))
                      <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl transition-all duration-300 ease-in-out animate-bounce mb-2">
                          <div class="flex items-center">
                              <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                              </svg>
                              <span>{{ session('success') }}</span>
                          </div>
                      </div>
                  @endif
                  @if(session('error'))
                      <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl transition-all duration-300 ease-in-out animate-bounce">
                          <div class="flex items-center">
                              <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                              </svg>
                              <span>{{ session('error') }}</span>
                          </div>
                      </div>
                  @endif
              </div>
              <script>
                  // Auto-dismiss messages after 5 seconds
                  setTimeout(() => {
                      document.querySelectorAll('.bg-green-500, .bg-red-500').forEach((message) => {
                          message.classList.add('animate-fadeOut');
                          setTimeout(() => message.remove(), 500);
                      });
                  }, 5000);
              </script>
          @endif

          <!-- Header Section -->
          <div class="flex justify-between items-center mb-8">
              <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 mr-3" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                  </svg>
                  <h1 class="text-3xl font-bold text-white">IP Address Manager</h1>
              </div>
              <div class="flex space-x-2">
                  <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                      </svg>
                      <span id="activeCount">{{$activeCount }} " </span>  Active IPs
                  </span>
                  <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Network Healthy
                  </span>
              </div>
          </div>

          <!-- Add New IP Form -->
          <div class="bg-white rounded-lg shadow-md p-6 mb-8">
              <div class="flex items-center mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                  </svg>
                  <h2 class="text-xl font-semibold text-gray-800">Add New IP Address</h2>
              </div>
              <form action="{{ route('ip-addresses.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                  @csrf
                  <div class="md:col-span-2">
                      <label for="ipAddress" class="block text-sm font-medium text-gray-700 mb-1">IP Address</label>
                      <input type="text" id="ipAddress" name="address" placeholder="192.168.1.1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <div class="md:col-span-2">
                      <label for="ipLabel" class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                      <input type="text" id="ipLabel" name="label" placeholder="Web Server" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <div class="md:col-span-1 flex items-end">
                      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center justify-center">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                          </svg>
                          Add
                      </button>
                  </div>
              </form>
          </div>

          <!-- IP Address List -->
          <div id="ipList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              @foreach($ipAddresses as $ip)
                  <div id="ip-{{ $ip->id }}" class="bg-white rounded-lg shadow-md overflow-hidden ip-card transition duration-200 fade-in">
                      <div class="p-6">
                          <!-- Display IP Details -->
                          <div class="ip-details">
                              <div class="flex justify-between items-start mb-4">
                                  <div>
                                      <h3 class="text-lg font-semibold text-gray-800">{{ $ip->address }}</h3>
                                      <p class="text-gray-600">{{ $ip->label }}</p>
                                  </div>
                                  <span id="status-{{ $ip->id }}" class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                      {{ $ip->active ? 'Active' : 'Inactive' }}
                                  </span>
                              </div>
                              <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                  <div class="flex items-center">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                      </svg>
                                      Added: {{ $ip->date_added }}
                                  </div>
                                  <div class="flex items-center">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                      </svg>
                                      Secure
                                  </div>
                              </div>
                              <div class="flex justify-between">
                                  <form action="{{ route('ip-addresses.toggle', $ip->id) }}" method="POST" class="inline">
                                      @csrf
                                      @method('PUT')
                                      <button type="submit" class="text-purple-600 hover:text-purple-800 font-medium text-sm flex items-center transition duration-200">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                          </svg>
                                          Toggle
                                      </button>
                                  </form>
                                  <button onclick="showEditForm('{{ $ip->id }}', '{{ $ip->address }}', '{{ $ip->label }}')" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center transition duration-200">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                      </svg>
                                      Edit
                                  </button>
                                  <form action="{{ route('ip-addresses.destroy', $ip->id) }}" method="POST" class="inline">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm flex items-center transition duration-200">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                          </svg>
                                          Delete
                                      </button>
                                  </form>
                              </div>
                          </div>

                          <!-- Edit Form (Hidden by Default) -->
                          <div id="edit-form-{{ $ip->id }}" class="edit-form">
                              <form action="{{ route('ip-addresses.update', $ip->id) }}" method="POST" class="space-y-4">
                                  @csrf
                                  @method('PUT')
                                  <div>
                                      <label for="edit-address-{{ $ip->id }}" class="block text-sm font-medium text-gray-700 mb-1">IP Address</label>
                                      <input type="text" id="edit-address-{{ $ip->id }}" name="address" value="{{ $ip->address }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                  </div>
                                  <div>
                                      <label for="edit-label-{{ $ip->id }}" class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                                      <input type="text" id="edit-label-{{ $ip->id }}" name="label" value="{{ $ip->label }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                  </div>
                                  <div class="flex justify-end">
                                      <button type="button" onclick="hideEditForm('{{ $ip->id }}')" class="mr-2 bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">Cancel</button>
                                      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Save Changes</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                      <div class="bg-gray-50 px-6 py-3">
                          <div class="flex justify-between items-center">
                              <div class="flex items-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                  </svg>
                                  <span class="text-sm text-gray-600">Last Active: {{ $ip->last_active }}</span>
                              </div>
                              <div class="flex items-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                  </svg>
                                  <span class="text-sm text-gray-600">Ping: 0ms</span>
                              </div>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
      </div>

      <script>
          function showEditForm(ipId, address, label) {
              // Hide the IP details
              document.querySelector(`#ip-${ipId} .ip-details`).style.display = 'none';
              // Show the edit form
              document.querySelector(`#edit-form-${ipId}`).style.display = 'block';
              // Pre-fill the form fields
              document.querySelector(`#edit-address-${ipId}`).value = address;
              document.querySelector(`#edit-label-${ipId}`).value = label;
          }

          function hideEditForm(ipId) {
              // Hide the edit form
              document.querySelector(`#edit-form-${ipId}`).style.display = 'none';
              // Show the IP details
              document.querySelector(`#ip-${ipId} .ip-details`).style.display = 'block';
          }
      </script>
  </body>
</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth