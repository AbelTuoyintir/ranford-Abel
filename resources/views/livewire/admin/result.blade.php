<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2024 Election Results</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class=" rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])
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