<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2024 Election Results</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        @keyframes gradientBg {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .gradient-header {
            background: linear-gradient(45deg, #1e40af, #3b82f6, #1e3a8a);
            background-size: 200% 200%;
            animation: gradientBg 10s ease infinite;
        }
        
        .winner-badge {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.9;
            }
        }
        
        .progress-animation {
            transition: width 1.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <header class="gradient-header text-white py-12 px-4 shadow-lg">
        <div class="container mx-auto max-w-6xl text-center">
            <h1 class="text-5xl font-black mb-4 tracking-tight">2024 National Election Results</h1>
            <div class="bg-white/20 rounded-full px-6 py-2 inline-block backdrop-blur-sm">
                <p class="text-xl font-medium">Official Final Tally for Valco Hall</p>
            </div>
        </div>
    </header>

    <main class="container mx-auto max-w-6xl px-4 py-10">
        <!-- Stats Dashboard -->
        <section class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Stats cards -->
                <div class="bg-white rounded-xl shadow-md p-6 transform transition hover:scale-105 duration-300 border-l-4 border-blue-600">
                    <h3 class="text-gray-500 font-semibold text-sm uppercase tracking-wider mb-2">Total Votes Cast</h3>
                    <div class="flex items-end">
                        <span class="text-4xl font-bold text-gray-800">247M</span>
                        <span class="ml-2 text-sm text-gray-500 mb-1">votes</span>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">From all 50 states and territories</div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 transform transition hover:scale-105 duration-300 border-l-4 border-green-600">
                    <h3 class="text-gray-500 font-semibold text-sm uppercase tracking-wider mb-2">Voter Turnout</h3>
                    <div class="flex items-end">
                        <span class="text-4xl font-bold text-gray-800">68.3%</span>
                        <span class="ml-2 text-sm text-green-600 mb-1">↑ 4.2% from 2020</span>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">Highest turnout since 1992</div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 transform transition hover:scale-105 duration-300 border-l-4 border-purple-600">
                    <h3 class="text-gray-500 font-semibold text-sm uppercase tracking-wider mb-2">Precincts Reporting</h3>
                    <div class="flex items-end">
                        <span class="text-4xl font-bold text-gray-800">100%</span>
                        <span class="ml-2 text-sm text-purple-600 mb-1">Complete</span>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">All results verified and certified</div>
                </div>
            </div>
        </section>

        <!-- Results Visualization -->
        <section class="bg-white rounded-xl shadow-lg p-8 mb-16 max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Election Results</h2>
        
            <!-- Swiper Container -->
            <div class="swiper-container">
                <div class="swiper-wrapper" >
                    <!-- President Race Results -->
                    <div class="swiper-slide bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Presidential Race Results</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                            <div class="h-80 bg-white rounded-lg p-4 shadow-md flex items-center justify-center">
                                <canvas id="presidentChart"></canvas>
                            </div>
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl font-bold text-gray-800">Candidate A</h3>
                                <div class="text-blue-600 font-medium">Democratic Party</div>
                                <div class="mt-1 text-gray-600">82,000,000 votes (54%)</div>
                            </div>
                        </div>
                    </div>
        
                    <!-- Vice President Race Results -->
                    <div class="swiper-slide bg-gray-100 rounded-lg shadow-md p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Vice Presidential Race Results</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                            <div class="h-80 bg-white rounded-lg p-4 shadow-md flex items-center justify-center">
                                <canvas id="vicePresidentChart"></canvas>
                            </div>
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl font-bold text-gray-800">Candidate C</h3>
                                <div class="text-blue-600 font-medium">Democratic Party</div>
                                <div class="mt-1 text-gray-600">80,000,000 votes (53%)</div>
                            </div>
                        </div>
                    </div>
        
                    <!-- Other Portfolios -->
                    <div class="swiper-slide bg-gray-100 rounded-lg shadow-md p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Other Portfolios</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                            <div class="h-80 bg-white rounded-lg p-4 shadow-md flex items-center justify-center">
                                <canvas id="otherPortfoliosChart"></canvas>
                            </div>
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl font-bold text-gray-800">Candidate E</h3>
                                <div class="text-blue-600 font-medium">Democratic Party</div>
                                <div class="mt-1 text-gray-600">75,000,000 votes (50%)</div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Swiper Pagination and Navigation -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev text-gray-700"></div>
                <div class="swiper-button-next text-gray-700"></div>
            
            </div>
        </section>
        
       

        <div>
            <!-- Electoral Map -->
            <section class="bg-white rounded-xl shadow-lg p-8 mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Electoral College Results</h2>
                <div class="text-center mb-8">
                    <div class="inline-flex items-center bg-gray-100 rounded-lg p-1">
                        <div class="px-4 py-2 rounded-md bg-blue-600 text-white font-medium">Electoral Map</div>
                        <div class="px-4 py-2 text-gray-600 font-medium">Popular Vote</div>
                    </div>
                </div>
                
                <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg flex items-center justify-center">
                    <p class="text-gray-400">Electoral map visualization would be displayed here</p>
                    <!-- This would be replaced with an actual electoral map visualization -->
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div class="text-blue-800 font-semibold">Candidate A (D)</div>
                        <div class="font-bold text-3xl text-blue-900">306</div>
                        <div class="text-blue-600 text-sm">Electoral votes</div>
                    </div>
                    
                    <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                        <div class="text-red-800 font-semibold">Candidate B (R)</div>
                        <div class="font-bold text-3xl text-red-900">232</div>
                        <div class="text-red-600 text-sm">Electoral votes</div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="text-gray-800 font-semibold">Required to Win</div>
                        <div class="font-bold text-3xl text-gray-900">270</div>
                        <div class="text-gray-600 text-sm">Electoral votes</div>
                    </div>
                </div>
            </section>
            
            <!-- Battleground States -->
            <section class="bg-white rounded-xl shadow-lg p-8 mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Battleground States</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">State</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Winner</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Margin</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Electoral Votes</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Key Counties</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">Pennsylvania</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Candidate A (D)</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">+1.2%</td>
                                <td class="px-6 py-4 whitespace-nowrap">20</td>
                                <td class="px-6 py-4">Philadelphia, Allegheny</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">Georgia</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Candidate A (D)</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">+0.3%</td>
                                <td class="px-6 py-4 whitespace-nowrap">16</td>
                                <td class="px-6 py-4">Fulton, DeKalb</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">Arizona</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Candidate B (R)</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">+0.9%</td>
                                <td class="px-6 py-4 whitespace-nowrap">11</td>
                                <td class="px-6 py-4">Maricopa, Pima</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">Wisconsin</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Candidate A (D)</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">+0.7%</td>
                                <td class="px-6 py-4 whitespace-nowrap">10</td>
                                <td class="px-6 py-4">Milwaukee, Dane</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">Michigan</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Candidate A (D)</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">+2.8%</td>
                                <td class="px-6 py-4 whitespace-nowrap">16</td>
                                <td class="px-6 py-4">Wayne, Oakland</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        
            <!-- State-by-State Results -->
            <section class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">State-by-State Results</h2>
                
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" placeholder="Search for a state..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Example state cards - these would be generated dynamically -->
                    <div class="border rounded-lg overflow-hidden bg-white hover:shadow-md transition-shadow">
                        <div class="bg-blue-600 p-3 text-white font-semibold flex justify-between items-center">
                            <span>California</span>
                            <span class="text-xs bg-white text-blue-800 px-2 py-0.5 rounded-full">55 EV</span>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                                    <span class="text-sm">Candidate A (D)</span>
                                </div>
                                <span class="font-medium">63.5%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                <div class="bg-blue-500 h-2 rounded-full progress-animation" style="width: 63.5%"></div>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                                    <span class="text-sm">Candidate B (R)</span>
                                </div>
                                <span class="font-medium">34.3%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full progress-animation" style="width: 34.3%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border rounded-lg overflow-hidden bg-white hover:shadow-md transition-shadow">
                        <div class="bg-red-600 p-3 text-white font-semibold flex justify-between items-center">
                            <span>Texas</span>
                            <span class="text-xs bg-white text-red-800 px-2 py-0.5 rounded-full">38 EV</span>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                                    <span class="text-sm">Candidate B (R)</span>
                                </div>
                                <span class="font-medium">52.1%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                <div class="bg-red-500 h-2 rounded-full progress-animation" style="width: 52.1%"></div>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                                    <span class="text-sm">Candidate A (D)</span>
                                </div>
                                <span class="font-medium">46.5%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full progress-animation" style="width: 46.5%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border rounded-lg overflow-hidden bg-white hover:shadow-md transition-shadow">
                        <div class="bg-blue-600 p-3 text-white font-semibold flex justify-between items-center">
                            <span>New York</span>
                            <span class="text-xs bg-white text-blue-800 px-2 py-0.5 rounded-full">29 EV</span>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                                    <span class="text-sm">Candidate A (D)</span>
                                </div>
                                <span class="font-medium">61.8%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                <div class="bg-blue-500 h-2 rounded-full progress-animation" style="width: 61.8%"></div>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                                    <span class="text-sm">Candidate B (R)</span>
                                </div>
                                <span class="font-medium">36.4%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full progress-animation" style="width: 36.4%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- More state cards would go here -->
                </div>
                
                <div class="mt-8 text-center">
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">Load More States</button>
                </div>
            </section>
        </div>
        
        
        
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="container mx-auto max-w-6xl px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">2024 Election Results</h3>
                    <p class="text-gray-300">Official final tally as certified by the Federal Election Commission.</p>
                    <p class="text-gray-400 mt-4 text-sm">Last updated: February 28, 2025</p>
                </div>
                <div class="md:text-right">
                    <h3 class="text-xl font-bold mb-4">Resources</h3>
                    <ul class="space-y-2 text-gray-300">
                       
                        <li><a href="#" class="hover:text-blue-300 transition-colors">Download Data (CSV)</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                © 2025 Election Results Portal. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Initialize chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('resultsChart').getContext('2d');
            const resultsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Candidate A (D)', 'Candidate B (R)', 'Candidate C (I)', 'Others'],
                    datasets: [{
                        label: 'Votes (millions)',
                        data: [82, 70, 9, 1],
                        backgroundColor: [
                            '#3b82f6',
                            '#ef4444',
                            '#10b981',
                            '#94a3b8'
                        ],
                        borderColor: [
                            '#2563eb',
                            '#dc2626',
                            '#059669',
                            '#64748b'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.raw + ' million votes';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Votes (in millions)'
                            }
                        }
                    }
                }
            });
            
            // Animate progress bars on load
            const progressBars = document.querySelectorAll('.progress-animation');
            setTimeout(() => {
                progressBars.forEach(bar => {
                    const targetWidth = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = targetWidth;
                    }, 100);
                });
            }, 500);
        });

    </script>
    <!-- Include Swiper.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 5000, // 5 seconds
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            slidesPerView: 1,
            spaceBetween: 600,
        });
    </script>
    
</body>
</html>