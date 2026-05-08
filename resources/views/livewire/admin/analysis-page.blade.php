@auth
<x-admin-sidebar>

    <div x-data="accordionComponent()" class="container mx-auto p-4">
        <div class="accordion space-y-2">
            <div 
                x-data="{ isOpen: false }" 
                class="border rounded-lg overflow-hidden"
            >
                <button 
                    @click="isOpen = !isOpen" 
                    class="w-full text-left p-4 bg-gray-100 flex justify-between items-center"
                >
                    <span>UCC Elections Overview</span>
                    <svg 
                        :class="{ 'rotate-180': isOpen }" 
                        class="w-5 h-5 transition-transform"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24" 
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div 
                    x-show="isOpen" 
                    x-collapse 
                    class="p-4 bg-white"
                >
                <div class="grid grid-cols-3 gap-4">    
                <!-- Overview Content -->
                    <div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
                      <!-- Image Section -->
                      <div class="img-section transition-transform duration-200 ease-in-out bg-[hsl(195,74%,62%)] rounded-t-[10px] hover:translate-y-4"></div>
                   
                      <!-- Card Description -->
                      <div class="card-desc bg-[#1C204B] p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
                      <!-- Card Header -->
                      <div class="card-header flex items-center w-full">
                         <div class="card-title flex-1 text-sm font-medium">Voters</div>
                         <div class="card-menu flex gap-1 mx-auto">
                            <div class="dot w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            <div class="dot w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            <div class="dot w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                         </div>
                      </div>
                   
                      <!-- Card Time -->
                      <div class="card-time text-2xl font-semibold">6354</div>
                   
                      <!-- Recent Section -->
                      <div class="recent text-sm leading-none">UCC Elections</div>
                      </div>
                   </div>
                   <div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
                      <!-- Image Section -->
                      <div class="img-section transition-transform duration-200 ease-in-out bg-[hsl(195,74%,62%)] rounded-t-[10px] hover:translate-y-4"></div>
                   
                      <!-- Card Description -->
                      <div class="card-desc bg-[#1C204B] p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
                      <!-- Card Header -->
                      <div class="card-header flex items-center w-full">
                         <div class="card-title flex-1 text-sm font-medium">Non voters</div>
                         <div class="card-menu flex gap-1 mx-auto">
                            <div class="dot w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            <div class="dot w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            <div class="dot w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                         </div>
                      </div>
                   
                      <!-- Card Time -->
                      <div class="card-time text-2xl font-semibold">3210</div>
                   
                      <!-- Recent Section -->
                      <div class="recent text-sm leading-none">UCC Elections</div>
                      </div>
                   </div>
                   <div class="card w-full h-[170px] rounded-[10px] grid grid-rows-[50px_1fr] cursor-pointer font-sans text-white">
                      <!-- Image Section -->
                      <div class="img-section transition-transform duration-200 ease-in-out bg-[hsl(195,74%,62%)] rounded-t-[10px] hover:translate-y-4"></div>
                   
                      <!-- Card Description -->
                      <div class="card-desc bg-[#1C204B] p-4 relative -top-[10px] grid gap-2 rounded-[10px]">
                      <!-- Card Header -->
                      <div class="card-header flex items-center w-full">
                         <div class="card-title flex-1 text-sm font-medium">Total population</div>
                         <div class="card-menu flex gap-1 mx-auto">
                            <div class="dot w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            <div class="dot w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                            <div class="dot w-1.5 h-1.5 bg-[#BBC0FF] rounded-full"></div>
                         </div>
                      </div>
                   
                      <!-- Card Time -->
                      <div class="card-time text-2xl font-semibold">75614</div>
                   
                      <!-- Recent Section -->
                      <div class="recent text-sm leading-none">Students Population</div>
                      </div>
                   </div>

                   <div class="flex items-center mb-5">
                    <p class="bg-blue-100 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded dark:bg-blue-200 dark:text-blue-800">8.7</p>
                    <p class="ms-2 font-medium text-gray-900 dark:text-white">Total voter</p>
                    <span class="w-1 h-1 mx-2 bg-gray-900 rounded-full dark:bg-gray-500"></span>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">376 Votes</p>
              </div>
            </div>
            <h2>Vote Tally for each hall</h2>
            <div class="gap-8 sm:grid sm:grid-cols-2">
                  <div>
                     <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Casford</dt>
                        <dd class="flex items-center mb-3">
                              <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                                 <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 88%"></div>
                              </div>
                              <span class="text-sm font-medium text-gray-500 dark:text-gray-400">8.8</span>
                        </dd>
                     </dl>
                     <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Valco</dt>
                        <dd class="flex items-center mb-3">
                              <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                                 <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 89%"></div>
                              </div>
                              <span class="text-sm font-medium text-gray-500 dark:text-gray-400">8.9</span>
                        </dd>
                     </dl>
                     <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">KNH</dt>
                        <dd class="flex items-center mb-3">
                              <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                                 <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 88%"></div>
                              </div>
                              <span class="text-sm font-medium text-gray-500 dark:text-gray-400">8.8</span>
                        </dd>
                     </dl>
                     <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Oguaa</dt>
                        <dd class="flex items-center">
                              <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                                 <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 54%"></div>
                              </div>
                              <span class="text-sm font-medium text-gray-500 dark:text-gray-400">5.4</span>
                        </dd>
                     </dl>
                     <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">PSI</dt>
                        <dd class="flex items-center">
                           <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                              <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 54%"></div>
                           </div>
                           <span class="text-sm font-medium text-gray-500 dark:text-gray-400">5.4</span>
                        </dd>
                  </dl>
                  </div>
                  <div>
                     <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Adehye</dt>
                        <dd class="flex items-center mb-3">
                              <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                                 <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 89%"></div>
                              </div>
                              <span class="text-sm font-medium text-gray-500 dark:text-gray-400">8.9</span>
                        </dd>
                     </dl>
                     <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ATL</dt>
                        <dd class="flex items-center mb-3">
                              <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                                 <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 70%"></div>
                              </div>
                              <span class="text-sm font-medium text-gray-500 dark:text-gray-400">7.0</span>
                        </dd>
                     </dl>
                     <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SRC</dt>
                        <dd class="flex items-center">
                              <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                                 <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 89%"></div>
                              </div>
                              <span class="text-sm font-medium text-gray-500 dark:text-gray-400">8.9</span>
                        </dd>
                     </dl>
                     <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Supernuation</dt>
                        <dd class="flex items-center">
                           <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                              <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 89%"></div>
                           </div>
                           <span class="text-sm font-medium text-gray-500 dark:text-gray-400">8.9</span>
                        </dd>
                  </dl>
                  <dl>
                     <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">University Hall</dt>
                     <dd class="flex items-center">
                        <div class="w-full bg-gray-200 rounded h-2.5 dark:bg-gray-700 me-2">
                           <div class="bg-blue-600 h-2.5 rounded dark:bg-blue-500" style="width: 54%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">5.4</span>
                     </dd>
               </dl>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-4 py-6">
                  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                     <!-- Section Heading -->
                     <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                        Votes Recorded In Each Hall
                     </h4>
                        
                     <!-- Chart Container -->
                     <div class="py-6">
                     <div class="relative w-full h-75">
                        <canvas id="pieChartCanvas" class="w-full h-full"></canvas>
                     </div>
                     </div>
                     </div>
                     <div class="w-full max-w-4xl mx-auto p-4 h-full">
                      <div class="w-full mx-auto bg-white rounded-lg shadow dark:bg-gray-800 md:p-6">
                      <div class="flex justify-between border-b pb-3 mb-3">
                         <dl>
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Gender Distribution</dt>
                            <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">Total: 5405</dd>
                         </dl>
                      </div>
    
                      <div class="grid grid-cols-1 py-3 content-center" style="display: flex;">
                         <!-- Male -->
                         <dl class="flex items-center justify-center">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">
                            <img src="https://api.dicebear.com/7.x/personas/svg?seed=alex" alt="Male Avatar" width="65" height="65">
                            </dt>
                            <dd class="leading-none text-xl font-bold text-green-500 dark:text-green-400">Male: 23,63554</dd>
                         </dl>
    
                         <!-- Female -->
                         <dl class="flex items-center justify-center">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1 pl-6">
                            <img src="https://api.dicebear.com/7.x/personas/svg?seed=female_avatar" alt="Female Avatar" width="65" height="65">
                            </dt>
                            <dd class="leading-none text-xl font-bold text-red-600 dark:text-red-500 pl-6">Female: 18,23013</dd>
                         </dl>
                      </div>
                      <canvas id="myBarChart"></canvas>
                    </div>
                </div>
              </div>
              
           </div>
          </div> 
                  </div> 
              
              </div>
              </div>
            </div>

            <div 
                x-data="{ isOpen: false }" 
                class="border rounded-lg overflow-hidden"
            >
                <button 
                    @click="isOpen = !isOpen" 
                    class="w-full text-left p-4 bg-gray-100 flex justify-between items-center"
                >
                    <span>UCC SRC General Elections</span>
                    <svg 
                        :class="{ 'rotate-180': isOpen }" 
                        class="w-5 h-5 transition-transform"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24" 
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div 
                    x-show="isOpen" 
                    x-collapse 
                    class="p-4 bg-white"
                >
                    <!-- SRC Elections Content -->
                    <div id="default-carousel" class="relative w-50" data-carousel="slide">
                      <div class="relative overflow-hidden rounded-lg w-23 py-5">
                        <!-- Item 1 --> 
                        <div data-carousel-item class="w-45 flex justify-center items-center ">
                          <img src="img/passport.jpeg" class="block w-full h-full object-cover" alt="Image 1" style="width: 250px; height: 250px; align-items: center;">
                          <div class="flex justify-between w-full absolute top-4 left-0 right-0 px-5 py-5 text-white">
                            <p class="text-left bg-blue-700 rounded-sm p-1" >SRC president</p>
                            <p class="text-right bg-blue-700 rounded-sm p-1">Maxwell lartey</p>
                          </div>
                          <div class="flex justify-between w-full absolute bottom-4 left-0 right-0 px-5 py-5 text-white">
                            <p class="text-left bg-black rounded-sm p-1" >Votes : <span>654</span></p>
                            <p class="text-right bg-red-600 rounded-sm p-1">Skipped votes : <span>654</span></p>
                          </div>
                        </div>
                        <!-- Item 2 -->
                        <div data-carousel-item class="w-45 h-75 flex justify-center items-center">
                          <img src="{{asset('images/hall-logo/casford.jpg')}}" class="block w-full h-full object-cover" alt="Image 2" style="width: 250px; height: 250px;">
                      
                          <div class="flex justify-between w-full absolute top-4 left-0 right-0 px-5 py-5 text-white">
                            <p class="text-left bg-blue-700 rounded-sm p-1" >LNUGS president</p>
                            <p class="text-right text-bold text-black rounded-sm p-1">Samuel Opare</p>
                          </div>
                          <div class="flex justify-between w-75 absolute bottom-4 left-0 right-0 px-5 py-5 text-white">
                            <p class="text-left bg-black rounded-sm p-1" >Votes : <span>654</span></p>
                            <p class="text-right bg-red-600 rounded-sm p-1">Skipped votes : <span>654</span></p>
                          </div>
                          <div class="flex justify-between w-75 absolute bottom-4 left-0 right-0 px-6 py-5 text-white">
                            <p class="text-left bg-black rounded-sm p-1" >Votes : <span>654</span></p>
                            <p class="text-right bg-red-600 rounded-sm p-1">Skipped votes : <span>654</span></p>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Carousel Controls -->
                      <button data-carousel-prev class="absolute top-1/2 left-0 transform -translate-y-1/2 text-red-600 px-6 rounded-full">
                        Prev
                      </button>
                      <button data-carousel-next class="absolute top-1/2 right-0 transform -translate-y-1/2 text-blue-700 px-6 rounded-full">
                        Next
                      </button>
                    </div>
                    <div class="container mx-auto bg-white rounded-lg shadow-md p-6">
                      <h2 class="text-2xl font-bold mb-6 text-center">Candidate Votes by Gender</h2>
                      <canvas id="candidateVotesChart"></canvas>
                  </div>





                </div>
            </div>
        </div>
    </div>

    <script>
       // Get carousel elements
  const prevButton = document.querySelector('[data-carousel-prev]');
  const nextButton = document.querySelector('[data-carousel-next]');
  const items = document.querySelectorAll('[data-carousel-item]');
  let currentIndex = 0;

  // Hide all items except the current one
  function hideAllItems() {
    items.forEach((item) => item.classList.add('hidden'));
  }

  // Show the current item
  function showCurrentItem() {
    hideAllItems();
    items[currentIndex].classList.remove('hidden');
  }

  // Show the next item
  function showNextItem() {
    currentIndex = (currentIndex + 1) % items.length; // Loop back to the first item
    showCurrentItem();
  }

  // Show the previous item
  function showPrevItem() {
    currentIndex = (currentIndex - 1 + items.length) % items.length; // Loop back to the last item
    showCurrentItem();
  }

  // Initialize the carousel
  showCurrentItem();

  // Add event listeners for buttons
  nextButton.addEventListener('click', showNextItem);
  prevButton.addEventListener('click', showPrevItem);

  // Automatically change item every 5 seconds
  setInterval(showNextItem, 5000); // 5000 milliseconds = 5 seconds

      var ctx = document.getElementById('candidateVotesChart').getContext('2d');
        var candidateVotesChart = new Chart(ctx, {
            type: 'bar',  // Type of chart (bar chart)
            data: {
                labels: ['Candidate A', 'Candidate B', 'Candidate C', 'Candidate D'], // X-axis labels (candidates)
                datasets: [{
                    label: 'Votes',  // Label for the dataset
                    data: [1200, 1500, 1000, 800],  // Data for each candidate's votes (you can replace these numbers)
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',  // Color for Candidate A's bar (Red)
                        'rgba(54, 162, 235, 0.7)',  // Color for Candidate B's bar (Blue)
                        'rgba(75, 192, 192, 0.7)',  // Color for Candidate C's bar (Green)
                        'rgba(153, 102, 255, 0.7)'  // Color for Candidate D's bar (Purple)
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',  // Border color for Candidate A's bar (Red)
                        'rgba(54, 162, 235, 1)',  // Border color for Candidate B's bar (Blue)
                        'rgba(75, 192, 192, 1)',  // Border color for Candidate C's bar (Green)
                        'rgba(153, 102, 255, 1)'  // Border color for Candidate D's bar (Purple)
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true  // Y-axis will start from 0
                    }
                },
                responsive: true  // Makes the chart responsive to different screen sizes
            }
        });
      

      

       var ctxPie = document.getElementById('pieChartCanvas').getContext('2d');
        var myPieChart = new Chart(ctxPie, {
            type: 'pie',  // Chart type (pie chart)
            data: {
                labels: ['Red', 'Blue', 'Yellow'],  // Pie chart slices
                datasets: [{
                    label: 'My Pie Dataset',
                    data: [300, 50, 100],  // Values for each slice
                    backgroundColor: [   // Slice colors
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 205, 86, 0.2)'
                    ],
                    borderColor: [   // Border colors for each slice
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 205, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,  // Makes the chart responsive
            }
        });
         
          // Bar Chart
          var ctxBar = document.getElementById('myBarChart').getContext('2d');
        var myBarChart = new Chart(ctxBar, {
            type: 'bar',  // Chart type (bar chart)
            data: {
                labels: ['Group 1'],  // X-axis label for the group (e.g., one thing you're comparing)
                datasets: [
                    {
                        label: 'Female',  // Label for the female dataset
                        data: [50],  // Data value for Female (adjust as necessary)
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',  // Color for Female bar
                        borderColor: 'rgba(255, 99, 132, 1)',  // Border color for Female bar
                        borderWidth: 1
                    },
                    {
                        label: 'Male',  // Label for the male dataset
                        data: [70],  // Data value for Male (adjust as necessary)
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',  // Color for Male bar
                        borderColor: 'rgba(75, 192, 192, 1)',  // Border color for Male bar
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true  // Ensure Y-axis starts from 0
                    }
                },
                responsive: true,  // Make the chart responsive
                barThickness: 50,  // Control the thickness of the bars
                layout: {
                    padding: {
                        left: 50,
                        right: 50,
                        top: 10,
                        bottom: 10
                    }
                }
            }
        });


        function candidateCarousel() {
            return {
                currentIndex: 0,
                candidates: [
                    { 
                        name: 'Maxwell Lartey', 
                        position: 'SRC President', 
                        image: 'path/to/image1.jpg', 
                        votes: 654 
                    },
                    { 
                        name: 'Samuel Opare', 
                        position: 'LNUGS President', 
                        image: 'path/to/image2.jpg', 
                        votes: 542 
                    }
                ],
                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.candidates.length;
                },
                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.candidates.length) % this.candidates.length;
                }
            };
        }
    </script>

</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth