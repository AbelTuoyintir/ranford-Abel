@auth
<x-admin-sidebar>
  <style>
    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .status-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 2px 8px;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 500;
    }
  </style>
  
  <div class="container">
    @if ($errors->any())
        <div class="fixed top-4 right-4 z-50 error-prompt" role="alert">
            <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl transition-transform duration-300 ease-in-out animate-bounce">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                    </svg>
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="fixed top-4 left-4 z-50 success-prompt" role="alert">
            <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl transition-transform duration-300 ease-in-out animate-bounce">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif
  </div>

  <!-- Disqualification Modal -->
  <div id="disqualifyModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Disqualify Nominee</h3>
            <div class="mt-2 px-7 py-3">
                <form id="disqualifyForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700 text-left mb-1">Reason for disqualification:</label>
                        <textarea id="reason" name="reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></textarea>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Confirm Disqualification
                        </button>
                        <button type="button" onclick="closeDisqualifyModal()" class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>

  <body class="bg-gray-50 text-gray-800 min-h-screen">
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold flex items-center gap-2 text-blue-600">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Nominee Management System
          </h1>
          <div class="flex items-center gap-4">
            <div class="relative">
              <input type="text" id="search" placeholder="Search nominees..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
              <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="container mx-auto px-4 py-8">
      <div class="mb-8 flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Manage Nominees by Position</h2>
          <p class="text-gray-500">Grouped by their assigned position (e.g., President, Secretary)</p>
        </div>
        <div class="flex items-center gap-3">
          <div class="flex items-center space-x-2">
            <label for="filter" class="text-sm font-medium text-gray-700">Filter by:</label>
            <select id="filter" class="border border-gray-300 rounded-md px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option>All Status</option>
              <option>Nominee</option>
              <option>Aspirant</option>
              <option>Candidate</option>
            </select>
          </div>
          <div class="flex items-center space-x-2">
            <label for="sort" class="text-sm font-medium text-gray-700">Sort by:</label>
            <select id="sort" class="border border-gray-300 rounded-md px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option>Name</option>
              <option>Status</option>
              <option>Level</option>
              <option>Department</option>
            </select>
          </div>
        </div>
      </div>

      @php
        // Group nominees by their 'position' field
        $groupedByPosition = $nominees->groupBy('position')->sortKeys();
      @endphp

      @foreach($groupedByPosition as $position => $nomineesInPosition)
        <div class="mb-12 position-group">
          <div class="mb-4 pb-2 border-b-2 border-gray-200 flex justify-between items-end">
            <div>
              <h2 class="text-2xl font-bold capitalize text-gray-800 inline-block px-4 py-1 rounded-lg bg-indigo-100 text-indigo-800">
                {{ $position ?: 'No Position Assigned' }}
              </h2>
              <p class="text-gray-500 mt-1 ml-1">{{ $nomineesInPosition->count() }} nominee(s)</p>
            </div>
          </div>
          
          <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($nomineesInPosition as $nominee)
            <div class="bg-white rounded-lg shadow-md p-6 relative card-hover transition-all duration-300">
              <!-- Status Badge (based on role) -->
              <span class="status-badge bg-{{ $nominee->role === 'candidate' ? 'blue' : ($nominee->role === 'aspirant' ? 'yellow' : ($nominee->role === 'nominee' ? 'green' : 'gray')) }}-100 text-{{ $nominee->role === 'candidate' ? 'blue' : ($nominee->role === 'aspirant' ? 'yellow' : ($nominee->role === 'nominee' ? 'green' : 'gray')) }}-800">
                  {{ ucfirst($nominee->role) }}
              </span>
              
              <div class="flex items-center gap-4 mb-4">
                  <!-- Profile Image -->
                  <div class="relative">
                      <img src="{{ $nominee->photo_path ?? '/api/placeholder/80/80' }}" 
                           alt="{{ $nominee->full_name }}" 
                           class="w-16 h-16 rounded-full object-cover border-2 border-blue-500" />
                      <span class="absolute bottom-0 right-0 w-4 h-4 bg-{{ $nominee->verified ? 'green' : 'red' }}-500 rounded-full border-2 border-white"></span>
                  </div>
                  
                  <!-- Nominee Info -->
                  <div>
                      <h2 class="text-lg font-semibold">{{ $nominee->full_name }}</h2>
                      <p class="text-sm text-gray-500">
                        {{ $nominee->program }} • 
                        <span class="{{ $nominee->status === 'rejected' ? 'text-red-500' : 'text-green-500' }}">
                            {{ $nominee->status }}
                        </span>
                      </p>
                      
                      <!-- Rating Stars (example using CGPA) -->
                      <div class="flex items-center mt-1 text-yellow-500">
                          @php
                              $rating = min(5, max(1, round($nominee->nominee_cgpa ?? 3)));
                          @endphp
                          
                          @for($i = 1; $i <= 4; $i++)
                              <svg class="w-4 h-4" fill="{{ $i <= $rating ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 20 20">
                                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                              </svg>
                          @endfor
                      </div>
                  </div>
              </div>
              
              <!-- Progress Bar (based on role) -->
              <div class="mb-4">
                  <div class="flex justify-between text-xs text-gray-500 mb-1">
                      <span>Progress to Candidate</span>
                      <span>
                          @php
                              $progress = match($nominee->role) {
                                  'candidate' => 100,
                                  'aspirant' => 75,
                                  'nominee' => 50,
                                  'applicant' => 25,
                                  default => 10,
                              };
                          @endphp
                          {{ $progress }}%
                      </span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2">
                      <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                  </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="space-y-2">
                @if ($nominee->status == 'draft' || $nominee->status == 'rejected')
                      <a href="{{ route('nominees.show', $nominee->id) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md transition-colors duration-200">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
                          View Profile
                      </a>
                @else
                    @if($nominee->role != 'aspirant')
                    <form action="{{ route('nominees.promote', $nominee->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="aspirant">
                        <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Promote to Aspirant
                        </button>
                    </form>
                    @endif
                    
                    @if($nominee->role != 'candidate')
                    <form action="{{ route('nominees.promote', $nominee->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="candidate">
                        <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Promote to Candidate
                        </button>
                    </form>
                    @endif
                    
                    <a href="{{ route('nominees.show', $nominee->id) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View Profile
                    </a>
                    
                    <button onclick="openDisqualifyModal('{{ $nominee->id }}')" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Disqualify
                    </button>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>

    <script>
      // Mobile menu toggle
      const mobileBtn = document.getElementById('mobile-menu-button');
      if (mobileBtn) {
          mobileBtn.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
          });
      }

      // Disqualification modal functions
      function openDisqualifyModal(nomineeId) {
          const form = document.getElementById('disqualifyForm');
          form.action = `/nominees/${nomineeId}`;
          document.getElementById('disqualifyModal').classList.remove('hidden');
      }

      function closeDisqualifyModal() {
          document.getElementById('disqualifyModal').classList.add('hidden');
      }

      // Search functionality (filters cards across all position groups)
      const searchInput = document.getElementById('search');
      if (searchInput) {
          searchInput.addEventListener('input', function(e) {
              const searchValue = e.target.value.toLowerCase();
              const cards = document.querySelectorAll('.card-hover');
              
              cards.forEach(card => {
                  const text = card.textContent.toLowerCase();
                  const parentGroup = card.closest('.position-group');
                  if (text.includes(searchValue)) {
                      card.style.display = '';
                      if (parentGroup) parentGroup.style.display = '';
                  } else {
                      card.style.display = 'none';
                  }
              });
              
              // Hide empty groups
              document.querySelectorAll('.position-group').forEach(group => {
                  const visibleCards = group.querySelectorAll('.card-hover[style="display: none;"]');
                  const totalCards = group.querySelectorAll('.card-hover').length;
                  if (visibleCards.length === totalCards) {
                      group.style.display = 'none';
                  } else {
                      group.style.display = '';
                  }
              });
          });
      }

      // Filter by role (status badge)
      const filterSelect = document.getElementById('filter');
      if (filterSelect) {
          filterSelect.addEventListener('change', function(e) {
              const filterValue = e.target.value;
              const cards = document.querySelectorAll('.card-hover');
              
              cards.forEach(card => {
                  const statusBadge = card.querySelector('.status-badge');
                  if (!statusBadge) return;
                  const statusText = statusBadge.textContent.trim();
                  
                  if (filterValue === 'All Status' || statusText === filterValue) {
                      card.style.display = '';
                  } else {
                      card.style.display = 'none';
                  }
              });
              
              // Hide empty groups
              document.querySelectorAll('.position-group').forEach(group => {
                  const visibleCards = group.querySelectorAll('.card-hover[style="display: none;"]');
                  const totalCards = group.querySelectorAll('.card-hover').length;
                  if (visibleCards.length === totalCards) {
                      group.style.display = 'none';
                  } else {
                      group.style.display = '';
                  }
              });
          });
      }

      // Auto-dismiss alerts
      setTimeout(() => {
          const successMessage = document.querySelector('.success-prompt');
          if (successMessage) {
              successMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
              setTimeout(() => {
                  successMessage.remove();
              }, 500);
          }
      }, 5000);

      setTimeout(() => {
          const errorMessage = document.querySelector('.error-prompt');
          if (errorMessage) {
              errorMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
              setTimeout(() => {
                  errorMessage.remove();
              }, 500);
          }
      }, 5000);
    </script>
  </body>
</x-admin-sidebar>
@else
<script>
    window.location.href = "{{ route('/student') }}";
</script>
@endauth