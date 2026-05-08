@props(['poll'])
<!DOCTYPE html>
<html>
<head>
    <title>{{ $poll->title }} - Election Results</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        /* Print Styles - Optimized for professional output */
        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }
            
            body {
                margin: 0;
                padding: 0;
                background: white !important;
                color: #000 !important;
                font-size: 10pt;
            }
            
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            .no-print,
            button,
            .download-btn,
            .print-button {
                display: none !important;
            }
            
            .container {
                max-width: 100% !important;
                padding: 0 !important;
            }
            
            .bg-white,
            .candidate-card,
            .portfolio-summary {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }
            
            .chart-container {
                page-break-inside: avoid;
                height: 300px !important;
                margin: 20px 0;
            }
            
            canvas {
                max-height: 300px !important;
            }
            
            .print-section {
                page-break-inside: avoid;
                margin-bottom: 40px;
            }
            
            h1, h2, h3 {
                page-break-after: avoid;
                color: #000 !important;
            }
            
            table {
                page-break-inside: avoid;
                font-size: 9pt;
            }
            
            .candidate-card {
                page-break-inside: avoid;
                margin-bottom: 10px;
                padding: 10px;
            }
            
            .portfolio-summary {
                page-break-inside: avoid;
            }
            
            /* Print header */
            .print-header {
                display: block !important;
                text-align: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 3px solid #000;
            }
            
            .print-header h1 {
                font-size: 24pt;
                margin: 0;
                font-weight: bold;
            }
            
            .print-header .subtitle {
                font-size: 14pt;
                color: #333;
                margin-top: 5px;
            }
            
            /* Print footer */
            .print-footer {
                display: block !important;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                text-align: center;
                font-size: 8pt;
                color: #666;
                padding: 10px;
                border-top: 1px solid #ccc;
            }
            
            /* Ensure colors print */
            .winner-badge,
            .percentage-badge {
                border: 1px solid #000 !important;
            }
            
            .bg-blue-50,
            .bg-green-50,
            .bg-purple-50,
            .bg-yellow-50 {
                background-color: #f8f9fa !important;
                border: 1px solid #dee2e6 !important;
            }
        }
        
        /* Screen Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            padding: 2rem;
            color: #1f2937;
        }
        
        .print-header {
            display: none;
        }
        
        .print-footer {
            display: none;
        }
        
        .print-button {
            display: inline-flex;
            align-items: center;
            background-color: #059669;
            color: white;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            margin-left: 0.5rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .print-button:hover {
            background-color: #047857;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .bg-white {
            background-color: white;
        }
        
        .shadow-lg {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .p-6 {
            padding: 1.5rem;
        }
        
        .chart-container {
            height: 400px;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .portfolio-summary {
            margin-bottom: 24px;
            padding: 20px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 12px;
            border-left: 6px solid #2563eb;
        }
        
        .candidate-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid #e5e7eb;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .candidate-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .winner-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .vote-bar {
            height: 10px;
            background: #e5e7eb;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 8px;
        }
        
        .vote-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            border-radius: 5px;
        }
        
        .percentage-badge {
            background: #f0f9ff;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #bae6fd;
        }
        
        .download-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .download-btn:hover {
            background: #2563eb;
        }
        
        .excel-btn {
            background: #059669;
        }
        
        .excel-btn:hover {
            background: #047857;
        }
        
        .pdf-btn {
            background: #dc2626;
        }
        
        .pdf-btn:hover {
            background: #b91c1c;
        }
        
        /* Loading overlay */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        .loading-overlay.active {
            display: flex;
        }
        
        .loading-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="py-8">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay-{{ $poll->id }}">
        <div class="loading-content">
            <div class="spinner"></div>
            <p style="color: #1f2937; font-weight: 600;">Generating PDF...</p>
            <p style="color: #6b7280; font-size: 14px;">Please wait while we prepare your document</p>
        </div>
    </div>

    <!-- Print Header (only visible when printing) -->
    <div class="print-header" id="print-header-{{ $poll->id }}">
        <h1>UCC ELECTION RESULTS</h1>
        <div class="subtitle">Official Report - {{ $poll->title }}</div>
        <div style="font-size: 10pt; margin-top: 10px; color: #666;">
            Generated on {{ date('F j, Y \a\t g:i A') }}
        </div>
    </div>

    <div class="container mx-auto px-4" id="printableContent-{{ $poll->id }}">
        <!-- Main Poll Card -->
        <div class="bg-white rounded-xl shadow-lg mb-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 poll-title-{{ $poll->id }}">{{ $poll->title }}</h1>
                        <p class="text-gray-600 mt-1">
                            <span class="font-medium">Election Date:</span> {{ $poll->start_date }} 
                            | <span class="font-medium">Last Updated:</span> {{ $poll->updated_at->format('M d, Y H:i') }}
                        </p>
                    </div>
                    {{-- Download and Print Buttons --}}
                    <div class="flex items-center gap-4 no-print">
                        <button onclick="generatePDF_{{ $poll->id }}()" class="download-btn pdf-btn no-print">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Download PDF
                        </button>
                        <button onclick="exportToExcel_{{ $poll->id }}()" class="download-btn excel-btn no-print">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Export Excel
                        </button>
                        <button onclick="printPoll_{{ $poll->id }}()" class="download-btn no-print">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                            </svg>
                            Print
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Election Stats -->
            <div class="p-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg stat-box-{{ $poll->id }}">
                        <div class="text-3xl font-bold text-blue-600">{{ number_format($poll->voters) }}</div>
                        <div class="text-sm text-blue-800 font-medium mt-1">Votes Cast</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg stat-box-{{ $poll->id }}">
                        <div class="text-3xl font-bold text-green-600">{{ number_format($poll->total_voters) }}</div>
                        <div class="text-sm text-green-800 font-medium mt-1">Total Voters</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg stat-box-{{ $poll->id }}">
                        <div class="text-3xl font-bold text-purple-600">
                            {{ $poll->total_voters > 0 ? number_format(($poll->voters / $poll->total_voters) * 100, 1) : 0 }}%
                        </div>
                        <div class="text-sm text-purple-800 font-medium mt-1">Voter Turnout</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg stat-box-{{ $poll->id }}">
                        <div class="text-3xl font-bold text-yellow-600">{{ ucfirst($poll->status) }}</div>
                        <div class="text-sm text-yellow-800 font-medium mt-1">Election Status</div>
                    </div>
                </div>
            </div>
            
            <!-- Portfolio Results -->
            <div class="p-6">
                @php $groupedCandidates = $poll->candidates->groupBy('portfolio'); @endphp
                
                @foreach($groupedCandidates as $portfolio => $candidates)
                    @php
                        $maxVotes = $candidates->max('votes');
                        $portfolioSkipped = $poll->skipped_votes_breakdown[$portfolio] ?? 0;
                        $candidateVotesInPortfolio = $candidates->sum('votes');
                        // $skippedVotesInPortfolio = $portfolioSkipped;
                        $skippedVotesInPortfolio = $poll->voters - $candidateVotesInPortfolio;
                        $totalVotesInPortfolio = $candidateVotesInPortfolio + $skippedVotesInPortfolio;

                        //get all skipped votes for all portfolios
                        $totalSkipped_votecast = array_sum($poll->skipped_votes_breakdown);

                        $candidatePercentages = [];
                        $totalCandidatePercentage = 0;
                        
                        foreach($candidates as $candidate) {
                            $percentage = $totalVotesInPortfolio > 0 ? 
                                number_format(($candidate->votes / $totalVotesInPortfolio) * 100, 2) : 0;
                            $candidatePercentages[$candidate->id] = $percentage;
                            $totalCandidatePercentage += $percentage;
                        }
                        
                        $skippedPercentage = $totalVotesInPortfolio > 0 ? 
                            number_format(($skippedVotesInPortfolio / $totalVotesInPortfolio) * 100, 2) : 0;
                        
                        $totalAllPercentages = $totalCandidatePercentage + $skippedPercentage;
                        if ($totalAllPercentages > 100.01 || $totalAllPercentages < 99.99) {
                            $adjustmentFactor = 100 / $totalAllPercentages;
                            foreach($candidatePercentages as $candidateId => $percentage) {
                                $candidatePercentages[$candidateId] = number_format($percentage * $adjustmentFactor, 2);
                            }
                            $skippedPercentage = number_format($skippedPercentage * $adjustmentFactor, 2);
                        }
                    @endphp
                    
                    <div class="mb-10 print-section print-section-{{ $poll->id }}" id="portfolio-{{ Str::slug($portfolio) }}-{{ $poll->id }}">
                        <!-- Portfolio Header -->
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $portfolio }}</h2>
                                <p class="text-gray-600">Official Election Results</p>
                            </div>
                            <span class="winner-badge">
                                @if($maxVotes > 0)
                                    WINNER DECLARED
                                @else
                                    NO WINNER
                                @endif
                            </span>
                        </div>
                        
                        <!-- Portfolio Summary -->
                        <div class="portfolio-summary mb-8">
                            <h3 class="font-bold text-blue-700 text-lg mb-4">Vote Summary</h3>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                                    <div class="text-2xl font-bold text-gray-800">{{ number_format($totalVotesInPortfolio) }}</div>
                                    <div class="text-sm text-gray-600 font-medium mt-1">Total Votes</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                                    <div class="text-2xl font-bold text-green-600">{{ number_format($candidateVotesInPortfolio) }}</div>
                                    <div class="text-sm text-gray-600 font-medium mt-1">Candidate Votes</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                                    <div class="text-2xl font-bold text-yellow-600">{{ number_format($skippedVotesInPortfolio) }}</div>
                                    <div class="text-sm text-gray-600 font-medium mt-1">Skipped Votes</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                                    <div class="text-2xl font-bold text-purple-600">{{ $skippedPercentage }}%</div>
                                    <div class="text-sm text-gray-600 font-medium mt-1">Skipped Rate</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Candidates -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-700 mb-4">Candidates</h3>
                            <div class="space-y-4">
                                @foreach($candidates as $candidate)
                                    @php
                                        $isWinner = $candidate->votes == $maxVotes && $maxVotes > 0;
                                        $candidatePercentage = $candidatePercentages[$candidate->id] ?? 0;
                                    @endphp
                                    
                                    <div class="candidate-card">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-start gap-4">
                                                <img src="{{ asset('storage/'. $candidate->image_path) }}" 
                                                     alt="{{ $candidate->name }}"
                                                     class="w-20 h-20 rounded-full object-cover border-4 border-white shadow">
                                                <div>
                                                    <div class="flex items-center gap-3">
                                                        <h4 class="font-bold text-lg text-gray-800">{{ $candidate->name }}</h4>
                                                        @if($isWinner)
                                                            <span class="winner-badge">WINNER</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-gray-600 text-sm mt-1">Team: <span class="font-medium">{{ $candidate->team_name }}</span></p>
                                                    <div class="flex items-center gap-4 mt-3">
                                                        <span class="text-lg font-bold text-gray-800">
                                                            {{ number_format($candidate->votes) }} votes
                                                        </span>
                                                        <span class="percentage-badge">
                                                            {{ $candidatePercentage }}%
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm text-gray-500">Vote Share</div>
                                                <div class="vote-bar w-48 mt-2">
                                                    <div class="vote-fill" style="width: {{ $candidatePercentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Chart -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-700 mb-4">Vote Distribution</h3>
                            <div class="chart-container">
                                <canvas id="chart-{{ Str::slug($portfolio) }}-{{ $poll->id }}"
                                    data-candidates='@json($candidates->map(function($c) {
                                        return [
                                            'name' => $c->name,
                                            'votes' => $c->votes,
                                            'team' => $c->team_name
                                        ];
                                    }))'
                                    data-skipped="{{ $skippedVotesInPortfolio }}"
                                    data-portfolio="{{ $portfolio }}">
                                </canvas>
                            </div>
                        </div>
                        
                        <!-- Summary Table -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="font-bold text-gray-700 mb-4">Detailed Breakdown</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white rounded-lg overflow-hidden" style="border-collapse: collapse;">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700" style="border: 1px solid #e5e7eb;">Candidate/Status</th>
                                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700" style="border: 1px solid #e5e7eb;">Team</th>
                                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700" style="border: 1px solid #e5e7eb;">Votes</th>
                                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700" style="border: 1px solid #e5e7eb;">Percentage</th>
                                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700" style="border: 1px solid #e5e7eb;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($candidates as $candidate)
                                            <tr class="border-t border-gray-200 hover:bg-gray-50">
                                                <td class="py-3 px-4 text-sm" style="border: 1px solid #e5e7eb;">
                                                    <div class="flex items-center gap-2">
                                                        <img src="{{ asset('storage/'. $candidate->image_path) }}" 
                                                             class="w-8 h-8 rounded-full object-cover">
                                                        <span>{{ $candidate->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 text-sm" style="border: 1px solid #e5e7eb;">{{ $candidate->team_name }}</td>
                                                <td class="py-3 px-4 text-sm font-medium" style="border: 1px solid #e5e7eb;">{{ number_format($candidate->votes) }}</td>
                                                <td class="py-3 px-4 text-sm" style="border: 1px solid #e5e7eb;">
                                                    <span class="percentage-badge">{{ $candidatePercentages[$candidate->id] ?? 0 }}%</span>
                                                </td>
                                                <td class="py-3 px-4 text-sm" style="border: 1px solid #e5e7eb;">
                                                    @if($candidate->votes == $maxVotes && $maxVotes > 0)
                                                        <span class="winner-badge inline-block">Winner</span>
                                                    @else
                                                        <span class="text-gray-500">Candidate</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="border-t border-gray-200 bg-yellow-50">
                                            <td class="py-3 px-4 text-sm font-medium" style="border: 1px solid #e5e7eb;">Skipped Votes</td>
                                            <td class="py-3 px-4 text-sm" style="border: 1px solid #e5e7eb;">-</td>
                                            <td class="py-3 px-4 text-sm font-medium" style="border: 1px solid #e5e7eb;">{{ number_format($skippedVotesInPortfolio) }}</td>
                                            <td class="py-3 px-4 text-sm" style="border: 1px solid #e5e7eb;">
                                                <span class="percentage-badge" style="background: #fef3c7; color: #92400e;">
                                                    {{ $skippedPercentage }}%
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-yellow-700" style="border: 1px solid #e5e7eb;">Skipped</td>
                                        </tr>
                                        <tr class="border-t-2 border-gray-800 bg-gray-100 font-bold">
                                            <td class="py-3 px-4" style="border: 1px solid #e5e7eb;">TOTAL</td>
                                            <td class="py-3 px-4" style="border: 1px solid #e5e7eb;">-</td>
                                            <td class="py-3 px-4" style="border: 1px solid #e5e7eb;">{{ number_format($totalVotesInPortfolio) }}</td>
                                            <td class="py-3 px-4" style="border: 1px solid #e5e7eb;">100.00%</td>
                                            <td class="py-3 px-4" style="border: 1px solid #e5e7eb;">Portfolio Total</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    @if(!$loop->last)
                        <div class="border-b border-gray-300 my-8"></div>
                    @endif
                @endforeach
                
                <!-- Overall Election Summary -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-8 mt-8 summary-section-{{ $poll->id }}">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Election Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="text-5xl font-bold text-blue-600 mb-2">{{ number_format($poll->voters) }}</div>
                            <div class="text-gray-700 font-medium">Total Votes Cast</div>
                            <div class="text-sm text-gray-500 mt-1">Across all portfolios</div>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold text-green-600 mb-2">
                                {{ $poll->total_voters > 0 ? number_format(($poll->voters / $poll->total_voters) * 100, 2) : 0 }}%
                            </div>
                            <div class="text-gray-700 font-medium">Overall Voter Turnout</div>
                            <div class="text-sm text-gray-500 mt-1">Based on {{ number_format($poll->total_voters) }} registered voters</div>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold text-purple-600 mb-2">
                                @php
                                    $totalSkipped = 0;
                                    foreach($groupedCandidates as $portfolio => $candidates) {
                                        $totalSkipped += $poll->skipped_votes_breakdown[$portfolio] ?? 0;
                                    }
                                    $overallSkippedPercentage = $poll->voters > 0 ? 
                                        number_format(($totalSkipped / $poll->voters) * 100, 2) : 0;
                                @endphp
                                {{ $overallSkippedPercentage }}%
                            </div>
                            <div class="text-gray-700 font-medium">Overall Skip Rate</div>
                            <div class="text-sm text-gray-500 mt-1">{{ number_format($totalSkipped_votecast + 1) }} total skipped votes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Official Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            <p>This is an official election results report generated by UCC E-Voting System</p>
            <p class="mt-1">Report ID: {{ $poll->id }}-{{ date('YmdHis') }} | Generated on: {{ date('F j, Y \a\t g:i A') }}</p>
        </div>
    </div>

    <!-- Print Footer (only visible when printing) -->
    <div class="print-footer" id="print-footer-{{ $poll->id }}">
        <p>UCC E-Voting System | Report ID: {{ $poll->id }}-{{ date('YmdHis') }} | Page</p>
    </div>

    <script>
        // Initialize charts for this specific poll
        (function() {
            const pollId = '{{ $poll->id }}';
            
            document.addEventListener('DOMContentLoaded', function() {
                initializeChartsForPoll_{{ $poll->id }}();
            });

            function initializeChartsForPoll_{{ $poll->id }}() {
                document.querySelectorAll('canvas[id*="-{{ $poll->id }}"]').forEach(chartElement => {
                    const ctx = chartElement.getContext('2d');
                    const candidates = JSON.parse(chartElement.dataset.candidates || '[]');
                    const skippedVotes = parseInt(chartElement.dataset.skipped || '0');
                    const portfolio = chartElement.dataset.portfolio || 'Portfolio';
                    
                    const labels = candidates.map(c => c.name);
                    labels.push('Skipped Votes');
                    
                    const data = candidates.map(c => c.votes);
                    data.push(skippedVotes);
                    
                    const colors = candidates.map((c, i) => {
                        const colorsPalette = [
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(139, 92, 246, 0.7)',
                            'rgba(239, 68, 68, 0.7)',
                        ];
                        return colorsPalette[i % colorsPalette.length];
                    });
                    colors.push('rgba(156, 163, 175, 0.7)');
                    
                    const borderColors = colors.map(color => color.replace('0.7', '1'));
                    const total = data.reduce((a, b) => a + b, 0);
                    
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Votes',
                                data: data,
                                backgroundColor: colors,
                                borderColor: borderColors,
                                borderWidth: 2,
                                borderRadius: 4,
                                barPercentage: 0.7,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                    titleColor: '#1f2937',
                                    bodyColor: '#4b5563',
                                    borderColor: '#e5e7eb',
                                    borderWidth: 1,
                                    cornerRadius: 6,
                                    padding: 12,
                                    callbacks: {
                                        label: function(context) {
                                            const value = context.raw;
                                            const percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;
                                            return `${context.label}: ${value.toLocaleString()} votes (${percentage}%)`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return value.toLocaleString();
                                        },
                                        font: {
                                            size: 12
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Number of Votes',
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 12
                                        },
                                        maxRotation: 45,
                                        minRotation: 45
                                    }
                                }
                            }
                        }
                    });
                });
            }

            // Generate PDF for this specific poll
            window['generatePDF_{{ $poll->id }}'] = async function() {
                const overlay = document.getElementById('loadingOverlay-{{ $poll->id }}');
                overlay.classList.add('active');
                
                try {
                    const element = document.getElementById('printableContent-{{ $poll->id }}');
                    const pollTitle = document.querySelector('.poll-title-{{ $poll->id }}').textContent.replace(/[^a-z0-9]/gi, '_').toLowerCase();
                    const filename = `election_results_${pollTitle}_${new Date().toISOString().split('T')[0]}.pdf`;
                    
                    const opt = {
                        margin: [15, 10, 15, 10],
                        filename: filename,
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { 
                            scale: 2,
                            useCORS: true,
                            logging: false,
                            letterRendering: true
                        },
                        jsPDF: { 
                            unit: 'mm', 
                            format: 'a4', 
                            orientation: 'portrait',
                            compress: true
                        },
                        pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
                    };
                    
                    await html2pdf().set(opt).from(element).save();
                    
                } catch (error) {
                    console.error('PDF generation error:', error);
                    alert('Failed to generate PDF. Please try using the Print option instead.');
                } finally {
                    overlay.classList.remove('active');
                }
            };

            // Export to Excel/CSV for this specific poll
            window['exportToExcel_{{ $poll->id }}'] = function() {
                let csvContent = '';
                
                // Add BOM for Excel UTF-8 support
                csvContent = '\uFEFF';
                
                // Header
                const pollTitle = document.querySelector('.poll-title-{{ $poll->id }}').textContent;
                csvContent += '=== UCC ELECTION RESULTS REPORT ===\n';
                csvContent += `Election: ${pollTitle}\n`;
                csvContent += `Generated: ${new Date().toLocaleString()}\n`;
                csvContent += `Report ID: {{ $poll->id }}-${Date.now()}\n\n`;
                
                // Overall stats
                const statBoxes = document.querySelectorAll('.stat-box-{{ $poll->id }}');
                csvContent += '=== OVERALL STATISTICS ===\n';
                statBoxes.forEach(box => {
                    const value = box.querySelector('.text-3xl')?.textContent.trim() || '';
                    const label = box.querySelector('.text-sm')?.textContent.trim() || '';
                    if (value && label) {
                        csvContent += `${label},${value}\n`;
                    }
                });
                csvContent += '\n';
                
                // Portfolio data
                document.querySelectorAll('.print-section-{{ $poll->id }}').forEach(section => {
                    const portfolioTitle = section.querySelector('h2')?.textContent.trim() || 'Portfolio';
                    csvContent += `\n=== ${portfolioTitle.toUpperCase()} ===\n\n`;
                    
                    // Portfolio summary
                    const summaryBoxes = section.querySelectorAll('.portfolio-summary .bg-white');
                    csvContent += 'Summary:\n';
                    summaryBoxes.forEach(box => {
                        const value = box.querySelector('.text-2xl')?.textContent.trim() || '';
                        const label = box.querySelector('.text-sm')?.textContent.trim() || '';
                        if (value && label) {
                            csvContent += `${label},${value}\n`;
                        }
                    });
                    csvContent += '\n';
                    
                    // Detailed results table
                    csvContent += 'Candidate/Status,Team,Votes,Percentage,Status\n';
                    
                    const table = section.querySelector('table tbody');
                    if (table) {
                        table.querySelectorAll('tr').forEach(row => {
                            const cells = row.querySelectorAll('td');
                            if (cells.length >= 5) {
                                const candidate = cells[0].textContent.trim().replace(/,/g, ' ');
                                const team = cells[1].textContent.trim().replace(/,/g, ' ');
                                const votes = cells[2].textContent.trim().replace(/,/g, '');
                                const percentage = cells[3].textContent.trim().replace(/%/g, '');
                                const status = cells[4].textContent.trim();
                                
                                csvContent += `"${candidate}","${team}",${votes},${percentage},${status}\n`;
                            }
                        });
                    }
                    
                    csvContent += '\n' + '-'.repeat(80) + '\n';
                });
                
                // Overall summary
                const summarySection = document.querySelector('.summary-section-{{ $poll->id }}');
                if (summarySection) {
                    csvContent += '\n=== FINAL ELECTION SUMMARY ===\n';
                    const summaryStats = summarySection.querySelectorAll('.text-center');
                    summaryStats.forEach(stat => {
                        const value = stat.querySelector('.text-5xl')?.textContent.trim() || '';
                        const label = stat.querySelector('.font-medium')?.textContent.trim() || '';
                        if (value && label) {
                            csvContent += `${label},${value}\n`;
                        }
                    });
                }
                
                // Footer
                csvContent += `\n\nGenerated by UCC E-Voting System\n`;
                csvContent += `Report ID: {{ $poll->id }}-${Date.now()}\n`;
                csvContent += `Date: ${new Date().toLocaleString()}\n`;
                
                // Create and download file
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                
                const pollTitleClean = pollTitle.replace(/[^a-z0-9]/gi, '_').toLowerCase();
                link.setAttribute('href', url);
                link.setAttribute('download', `election_results_${pollTitleClean}_${new Date().toISOString().split('T')[0]}.csv`);
                link.style.visibility = 'hidden';
                
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };

            // Print handler for this specific poll
            window['printPoll_{{ $poll->id }}'] = function() {
                // Store original title
                const originalTitle = document.title;
                const pollTitle = document.querySelector('.poll-title-{{ $poll->id }}').textContent;
                
                // Update title for print
                document.title = `UCC Election Results - ${pollTitle}`;
                
                // Print
                window.print();
                
                // Restore title
                document.title = originalTitle;
            };
        })();
    </script>
</body>
</html>