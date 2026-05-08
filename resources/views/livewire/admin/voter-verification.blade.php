@auth
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Voter Verification</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class=" rounded-full w-16 h-16">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        /* Full-page overlay for login form */
        #login-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5) url('https://your-background-image-url.jpg') no-repeat center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        #login-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 8px;
       
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans bg-gray-50">

    <!-- Full-page overlay for login -->
    <div id="login-overlay">
        <div class="h-screen w-full flex items-center justify-center bg-gray-50">
            <img src="{{ asset('images/vecteezy_united-states-election-vote-box-png_11222113.png') }}" alt="" class="absolute h-full opacity-5" />
            <div class="w-[70%] md:w-[30%] relative">
                <div class="bg-[#22296F] text-white p-4 rounded-md mb-3 flex items-start gap-3">
                    <img src="{{ asset('images/IMG_202411319_103428204.png') }}" alt="" class="h-10 w-10 rounded-lg" />
                    <div>
                        <h1 class="text-lg">UNIVERSITY OF CAPE COAST</h1>
                        <h1 class="text-sm font-semibold text-gray-300">VOTING SYSTEM</h1>
                    </div>
                </div>    
                <form id="login-form" action="" class="p-6 bg-white rounded-md shadow-xl">
                    <h1 class="text-sm text-center text-gray-500">Please log in to access the page.</h1>
                    <input
                        id="username"
                        type="text"
                        class="border border-gray-400 p-3 outline-none rounded-md w-full mb-4"
                        placeholder="Your id*"
                    />
                    <input
                        id="password"
                        type="password"
                        placeholder="Password"
                        class="border border-gray-400 p-3 outline-none rounded-md w-full mb-10"
                    />
                    <button id="login-button" type="button" class="w-full p-3 bg-[#22296F] rounded-md text-white hover:bg-[#1A1F56]">
                        Login
                    </button>
                </form>
                
            </div>
        </div>
    </div>

    <div id="page-content" class="hidden">
        <!-- The rest of your content goes here -->
        <div class="grid grid-cols-3 gap-2 space-x-2 m-5 ">
            <div class="w-full h-[80px] bg-[#1C204B] rounded-lg cursor-pointer overflow-hidden grid grid-rows-[50px_1fr]">
                <div class="p-4 rounded-lg relative -top-2 grid gap-1">
                    <div class="text-4xl font-semibold mb-0 text-white">0000</div>
                    <p class="text-sm text-gray-200"> Voters</p>
                </div>
            </div>
            <div class="w-full h-[80px] bg-[#1C204B] rounded-lg cursor-pointer overflow-hidden grid grid-rows-[50px_1fr]">
                <div class="p-4 rounded-lg relative -top-2 grid gap-1">
                    <div class="text-4xl font-semibold mb-0 text-white">0000</div>
                    <p class="text-sm text-gray-200">Non Voters</p>
                </div>
            </div>
            <div class="w-full h-[80px] bg-[#1C204B] rounded-lg cursor-pointer overflow-hidden grid grid-rows-[50px_1fr]">
                <div class="p-4 rounded-lg relative -top-2 grid gap-1">
                    <div class="text-4xl font-semibold mb-0 text-white">0000</div>
                    <p class="text-sm text-gray-200">Total candidate</p>
                </div>
            </div>
      
            
            
            
            <!-- Your existing cards and content goes here -->
            
        </div>

        <div class="w-full h-full overflow-y-auto max-h-full bg-gray-50">
            <!-- Your existing page content goes here -->
            <nav class="sticky bg-gray-50 top-0 flex items-center justify-between p-3">
                <h1 class="text-[#000] font-bold text-3xl">
                    <i class="fa-solid fa-hotel"> </i>
                    Valco Hall
                </h1>
                <select class="p-3 bg-gray-200 outline-none rounded-lg">
                    <option value="">Src Presidency</option>
                    <option value="">Local Nugs</option>
                    <option value="">Other</option>
                </select>
            </nav>

            <div class="flex gap-5">
                <!-- First div: Current Voters -->
                <div class="p-4 bg-white rounded-lg shadow-xl my-6 mx-3 mb-4 w-1/2">
                    <h1 class="text-xl font-bold text-gray-600 mb-4">Current Voters</h1>
                    
                    <div class="grid grid-cols-5 gap-3">
                        <!-- Current Voters Cards -->
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-red-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0001
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-green-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0002
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-red-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0001
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-green-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0002
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-red-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0001
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-green-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0002
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-red-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0001
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-green-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0002
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-red-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0001
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-green-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0002
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-red-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0001
                            </h1>
                        </div>
                        <div class="w-full flex flex-col gap-3 p-3 bg-slate-200 rounded-2xl h-[200px] border-4 border-green-500">
                            <div class="flex-1 h-[240px] bg-white rounded-md">
                                <img src="{{ asset('images/stu.png') }}" alt="" class="w-full h-[140px] object-contain" />
                            </div>
                            <h1 class="text-white p-3 bg-[#22296F] rounded-lg">
                                ET/CSC/20/0002
                            </h1>
                        </div>
                        
                        

                        <!-- Repeat for other cards ... -->

                  
                </div>
                </div>

                <!-- Second div: Other Content -->
                <div class="p-4 bg-white rounded-lg shadow-xl my-6 mx-3 mb-4 w-1/2">
                    <h1 class="text-xl font-bold text-gray-600 mb-4">SRC PRESIDENT</h1>

                    <!-- Alpine.js for Carousel -->
                    <div x-data="{ activeIndex: 0 }" class="relative w-full" x-init="setInterval(() => { activeIndex = (activeIndex + 1) % 3 }, 3000)">
                        <!-- Carousel Items (Charts) -->
                        <div :class="activeIndex === 0 ? 'block' : 'hidden'">
                            <div id="chart1"></div>
                        </div>
                        <div :class="activeIndex === 1 ? 'block' : 'hidden'">
                            <div id="chart2"></div>
                        </div>
                        <div :class="activeIndex === 2 ? 'block' : 'hidden'">
                            <div id="chart3"></div>
                        </div>

                        <!-- Carousel Controls -->
                        <button @click="activeIndex = (activeIndex > 0 ? activeIndex - 1 : 2)" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                <svg class="w-4 h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button @click="activeIndex = (activeIndex < 2 ? activeIndex + 1 : 0)" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                <svg class="w-4 h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
           document.addEventListener("DOMContentLoaded", function () {
            // Chart 1 - Pie Chart (Increased size)
            var options1 = {
                chart: {
                    type: 'pie',
                    height: 500 // Increase the height for a larger chart
                },
                series: [12, 19, 3, 5, 2, 3],
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            };
            var chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
            chart1.render();
    
            // Chart 2 - Pie Chart (Increased size)
            var options2 = {
                chart: {
                    type: 'pie',
                    height: 500 // Increase the height for a larger chart
                },
                series: [65, 59, 80, 81, 56],
                labels: ['January', 'February', 'March', 'April', 'May'],
            };
            var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
            chart2.render();
    
            // Chart 3 - Pie Chart (Increased size)
            var options3 = {
                chart: {
                    type: 'pie',
                    height: 500 // Increase the height for a larger chart
                },
                series: [12, 19, 3],
                labels: ['Red', 'Blue', 'Yellow'],
            };
            var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
            chart3.render();
        });


        document.addEventListener("DOMContentLoaded", function () {
            const loginOverlay = document.getElementById('login-overlay');
            const pageContent = document.getElementById('page-content');
            const loginButton = document.getElementById('login-button');

            // Check if username and password are valid (this is just a demo check)
            loginButton.addEventListener('click', function () {
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;

                // In a real application, you would check against a server-side database
                if (username === 'admin' && password === 'password') {
                    // Hide the login overlay and show the page content
                    loginOverlay.style.display = 'none';
                    pageContent.classList.remove('hidden');
                } else {
                    alert('Invalid username or password');
                }
            });
        });
    </script>

</body>
</html>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth