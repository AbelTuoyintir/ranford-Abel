@auth
<x-admin-sidebar>
    <style>
        /* Existing CSS styles remain unchanged */
        @keyframes glowPulse {
            0% { box-shadow: 0 0 10px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.6); }
            100% { box-shadow: 0 0 10px rgba(59, 130, 246, 0.3); }
        }
        .glow-effect {
            transition: all 0.3s ease;
        }
        .glow-effect:hover {
            animation: glowPulse 2s infinite;
            transform: scale(1.05);
        }
        .candidate-card {
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        .candidate-card.selected {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.1);
        }
        .preview-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            overflow-y: auto;
        }
        .preview-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
        }
        /* Fixed layout structure */
        body {
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .page-content {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 64px);
            margin-top: 64px;
        }
        .candidates-container {
            overflow-y: auto;
            flex: 1;
        }
        .fixed-header, .fixed-footer {
            position: sticky;
            background: white;
            z-index: 10;
        }
        .fixed-header {
            top: 0;
        }
        .fixed-footer {
            bottom: 0;
        }
        .portfolio-missing {
            border-left: 4px solid #ef4444 !important;
            background-color: rgba(239, 68, 68, 0.05);
        }
        .portfolio-section {
            position: relative;
        }
        .error-indicator {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #ef4444;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .error-indicator.visible {
            opacity: 1;
        }
        /* Toast notification */
        .toast-notification {
            position: fixed;
            top: 80px;
            right: 20px;
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 12px 16px;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-width: 350px;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }
        .toast-notification.visible {
            transform: translateX(0);
        }
        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid white;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
        }
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        /* Thumbs-up image */
        .thumbs-up {
            display: none;
            margin-top: 10px;
            text-align: center;
        }
        .thumbs-up svg {
            width: 40px;
            height: 40px;
        }
        .candidate-card.selected .thumbs-up {
            display: block;
        }
        /* Thumbs-up image on hover */
    .candidate-card:hover .thumbs-up {
        display: block;
        opacity: 0.8;
    }

/* "Click to Vote" message */
    .candidate-card .click-to-vote {
        display: none;
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
    }

    .candidate-card:hover .click-to-vote {
        display: block;
    }
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .nav-bar {
                align-items: center;
                margin-top: 10%;
            }
            .nav-items {
                align-items: center;
            }
            .candidate-image {
                width: 120px;
                height: 120px;
            }
            .preview-content {
                margin: 5% auto;
                width: 95%;
                padding: 15px;
            }
            .election-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
    <body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen font-sans mb-10">
        <!-- Navigation Bar - Fixed -->
        <div class="fixed w-full bg-gradient-to-b bg-gray-800 p-4 text-white shadow-2xl top-2 z-10 nav-bar">
            <nav class="container mx-auto">
                <div class="overflow-x-auto pb-2">
                    <ul class="flex whitespace-nowrap uppercase text-white nav-items">
                        @foreach ($portfolios as $portfolio)
                        <li class="flex items-center hover:bg-gray-900 p-2 rounded text-sm md:text-base mr-2 portfolio-nav-item" data-portfolio-id="{{$portfolio->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24" class="mr-2">
                                <path d="M4 3a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2V5a2 2 0 00-2-2H4zm2 4h12v2H6V7zm0 4h8v2H6v-2zm12 2v-2h2v2h-2zm2 2h-2v2h2v-2zm-12 2h8v2H6v-2z"/>
                            </svg>
                            <a href="#portfolio-{{$portfolio->id}}">{{$portfolio->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Toast notification for validation errors -->
        <div id="validationToast" class="toast-notification">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <p class="font-medium text-red-800">Please complete your selections</p>
                    <p id="toastMessage" class="text-sm text-red-700"></p>
                </div>
            </div>
        </div>

        <!-- Main Content - Scrollable -->
        <div class="page-content">
            <div class="candidates-container">
                <div class="p-4 md:p-8 mt-2">
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-8">
                        <!-- Election Header - Fixed in view -->
                        <div class="fixed-header">
                            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 md:p-6 text-center text-white election-header">
                                <h1 class="text-xl md:text-3xl font-bold mb-2 uppercase">UCC Student Elections {{ date('Y') }}</h1>
                                <p class="text-blue-100 text-sm md:text-base">Choose Your Representatives</p>
                            </div>

                            <!-- Preview Button - Fixed below header -->
                            <div class="bg-blue-50 p-3 shadow-md flex justify-between items-center">
                                <div id="progressStatus" class="text-blue-800 font-medium">Select all positions to continue</div>
                                <button 
                                    type="button" 
                                    id="previewBtn"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-bold text-sm"
                                >
                                    Preview Selections
                                </button>
                            </div>
                        </div>

                        <!-- Portfolio Sections - This area scrolls -->
                        <form id="voteForm" action="/submit-vote" method="POST">
                            @csrf
                            <input type="hidden" value="{{$activePolls}}" name="poll">
                            <input type="hidden" value="{{auth()->user()->id}}" name="user_id">
                            
                            <div class="mt-24"> <!-- Add spacing to account for fixed header -->
                                @foreach ($portfolios as $portfolio)
                                <div id="portfolio-{{$portfolio->id}}" class="mb-6 md:mb-8 portfolio-section">
                                    <div class="error-indicator" id="error-indicator-{{$portfolio->id}}"></div>
                                    <div class="bg-blue-50 p-3 md:p-4 sticky top-24 z-10">
                                        <h2 class="text-lg md:text-2xl font-bold text-blue-900 mb-1">{{$portfolio->name}}</h2>
                                    </div>

                                    <div class="p-3 md:p-6">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                                           

                                            <!-- Candidates for the portfolio -->
                                            @foreach ($candidates->where('portfolio_id', $portfolio->id) as $candidate)
                                            <div class="candidate-card glow-effect border-2 rounded-2xl p-4 text-center cursor-pointer group relative overflow-hidden" 
                                                data-portfolio-id="{{$portfolio->id}}" 
                                                data-value="{{$candidate->id}}"
                                                data-image="{{asset('storage/' . $candidate->image_path)}}"
                                                data-name="{{ $candidate->team_name }}"
                                                data-number="{{ $candidate->ballot_number }}">
                                                <div class="w-24 h-24 md:w-32 md:h-32 lg:w-40 lg:h-40 rounded-lg overflow-hidden mx-auto mb-3 shadow-lg transition-transform group-hover:scale-110 candidate-image">
                                                    <img 
                                                        src="{{ asset('storage/'. $candidate->image_path) }}" 
                                                        alt="{{ $candidate->first_name }} {{ $candidate->middle_name }} {{ $candidate->last_name }}"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </div>
                                                <div class="space-y-1">
                                                    <h3 class="text-lg md:text-xl font-semibold text-blue-900">
                                                        {{ $candidate->team_name }} 
                                                    </h3>
                                                    <p class="text-xs md:text-sm text-gray-600">{{ $candidate->teaser }}</p>
                                                    <p class="text-base md:text-xl text-gray-600">#{{ $candidate->ballot_number }}</p>
                                                </div>
                                                <div class="absolute top-2 right-2 bg-blue-500 text-white rounded-full w-6 h-6 md:w-8 md:h-8 flex items-center justify-center selection-indicator opacity-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <input 
                                                    type="radio" 
                                                    name="votes[{{$portfolio->id}}]" 
                                                    value="{{$candidate->id}}" 
                                                    class="hidden vote-radio"
                                                >
                                                <!-- Thumbs-up for Candidate -->
                                                <div class="thumbs-up">
                                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#50b464" stroke="#50b464">
                                                        <path fill="#75cc8b" d="M238.986 26.47c-.825-.01-1.648-.008-2.47.003-7.52.096-14.927.958-22.188 2.578-58.085 12.96-102.088 73.253-116.93 166.41l17.776 2.833c14.167-88.922 54.783-140.9 103.074-151.674 48.29-10.776 108.966 18.458 165.854 102.81l14.923-10.065C348.077 63.82 290.963 26.958 238.985 26.47zm-7.363 42.24c-.82.008-1.638.028-2.453.06-7.827.32-15.446 1.826-22.76 4.642-19.504 7.51-36.01 23.927-49.05 48.692l15.93 8.384c11.668-22.164 25.08-34.694 39.587-40.28 14.506-5.584 30.932-4.625 50.006 3.032 38.147 15.314 84.798 58.2 132.805 120.473l14.255-10.99C360.977 139.203 313.59 94.2 269.588 76.535c-12.89-5.175-25.67-7.935-37.965-7.824zm-.592 39.466c-6.247-.03-12.35 1.114-17.99 3.853-8.596 4.174-15.492 11.964-19.933 22.44l16.575 7.024c3.164-7.466 6.913-11.18 11.22-13.273 4.308-2.09 9.795-2.65 16.82-1.382 14.05 2.538 33.037 12.87 51.923 26.805 37.77 27.872 76.124 69.76 87.81 84.947l14.266-10.977c-13.402-17.418-51.44-58.976-91.388-88.455-19.974-14.74-40.18-26.56-59.41-30.035-2.404-.434-4.812-.73-7.205-.865-.898-.05-1.793-.078-2.686-.082zm-81.47 32.566c-4.498 8.93-10.762 28.084-16.716 46.45-5.954 18.37-11.03 34.984-11.03 34.984l17.215 5.258s5.04-16.497 10.937-34.69c5.897-18.193 13.22-39.045 15.668-43.906l-16.076-8.096zm33.135 10.406c-11.62 24.464-19.368 51.84-11.992 78.483 12.94 46.74 44.042 99.694 95.953 113.173l4.524-17.422c-42.188-10.953-71.27-57.717-83.13-100.552-5.63-20.338.214-43.448 10.905-65.957l-16.26-7.722zm62.535 5.106c-.892-.006-1.79.03-2.687.105-5.386.452-10.798 2.364-15.58 5.724-6.377 4.48-11.795 11.174-16.85 20.187-8.915 15.9-7.64 33.784-.644 49.748 6.996 15.963 19.326 30.832 33.776 44.326 28.9 26.987 66.05 48.325 90.55 56.088l5.438-17.16c-20.146-6.384-57.082-27.224-83.703-52.083-13.31-12.43-24.097-25.9-29.575-38.4-5.478-12.498-6.038-23.2-.143-33.714 4.197-7.484 8.21-11.952 11.497-14.262 3.286-2.31 5.69-2.816 8.82-2.507 6.26.616 16.157 6.88 27.296 17.298 22.278 20.836 48.945 55.515 83.428 71.965l7.75-16.246c-28.587-13.637-54.798-46.34-78.883-68.865-12.042-11.264-23.702-20.677-37.825-22.067-.883-.087-1.772-.134-2.665-.14zm5.364 40.775l-16.776 6.53c2.782 7.147 8.363 13.638 16.41 22.764 8.044 9.127 18.362 19.68 29.506 29.973 11.145 10.292 23.087 20.304 34.475 28.307 11.387 8.002 21.89 14.153 32.185 16.255l3.6-17.635c-5.244-1.072-14.994-6.01-25.436-13.348-10.443-7.338-21.91-16.918-32.613-26.803-10.703-9.885-20.672-20.095-28.217-28.654-7.545-8.56-12.858-16.675-13.136-17.39zM88.127 220.474c-2.7 20.7-.85 50.2 3.195 78.19 4.047 27.99 9.704 53.42 17.936 67.9l15.648-8.893c-5.04-8.866-11.88-34.672-15.77-61.584-3.89-26.912-5.418-55.978-3.16-73.283l-17.85-2.33zm73.61 25.02l-17.7 3.27c2.796 15.14 14.096 38.007 29.256 60.63 15.16 22.626 33.31 44.284 54.36 51.572l5.89-17.01c-12.623-4.37-31.124-23.427-45.297-44.58-14.173-21.153-24.89-45.124-26.508-53.88zm252.634 5.062c-2.82 33.908-22.99 91.907-48.016 123.775l14.156 11.117c28.46-36.242 48.56-94.502 51.8-133.4l-17.94-1.493zm-281.52.52l-17.68 3.378c1.068 5.59 5.258 22.92 10.605 41.943 5.348 19.023 10.998 38.17 17.39 48.89l15.46-9.22c-3.356-5.627-10.293-25.942-15.52-44.54-5.23-18.6-9.606-37.052-10.255-40.45zm248.185 2.534c-1.81 9.433-8.274 30.502-16.16 50.767-7.886 20.265-17.88 40.592-24.223 48.08l13.735 11.635c9.955-11.752 19.076-32.155 27.26-53.188 8.186-21.032 14.75-41.828 17.066-53.902l-17.678-3.39zm-92.95 78.95l-5.456 17.155 38.75 12.33 5.46-17.154-38.754-12.33zm-107.954 15.557c-11.333 2.277-25.168 9.124-37.747 16.14-6.29 3.506-12.093 7.053-16.697 10.175-2.303 1.56-4.3 3.005-5.997 4.384-1.698 1.38-2.99 2.174-4.71 4.936l15.282 9.51c-.908 1.46-.3.4.78-.477 1.078-.877 2.734-2.093 4.743-3.455 4.018-2.724 9.477-6.068 15.365-9.35 11.776-6.568 25.96-12.897 32.526-14.216l-3.545-17.647zm74.585 22.2c-36.986-.37-71.186 11.506-107.762 36.814l10.242 14.804c55.303-38.266 98.21-43.222 162.315-20.97l5.902-17.003c-25.312-8.786-48.506-13.418-70.697-13.642zm86.65 13.43l-8.676 15.773 23.486 12.916 8.676-15.772-23.487-12.916zm-75 15.56c-1.832-.01-3.68.02-5.545.09-26.098.99-55.397 9.924-90.466 30.898l9.238 15.447c37.99-22.72 66.52-29.49 91.373-28.312 24.852 1.177 46.713 10.534 70.77 22.2l7.855-16.198c-24.482-11.87-48.933-22.616-77.774-23.983-1.802-.086-3.618-.134-5.45-.143zm-.982 30.425c-5.37-.054-10.583.356-15.57 1.15-22.792 3.62-40.893 14.478-51.016 25.975l13.51 11.895c6.516-7.4 21.822-17.154 40.334-20.096 18.512-2.942 40.22.146 62.45 17.33l11.01-14.24c-19.497-15.07-39.837-21.312-58.405-21.96-.773-.028-1.545-.046-2.312-.054zm2.635 37.336c-1.556-.014-3.112.017-4.668.096-12.448.633-24.804 4.333-35.22 12.51l11.116 14.158c13.707-10.76 36.382-10.437 53.49-3.95l6.38-16.83c-9.433-3.577-20.212-5.886-31.098-5.984z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            @endforeach

                                             <!-- Skip Option -->
                                             <div class="candidate-card glow-effect border-2 border-blue-200 rounded-2xl p-4 text-center cursor-pointer group relative overflow-hidden hover:border-blue-500" 
                                             data-portfolio-id="{{$portfolio->id}}" 
                                             data-value="skip" 
                                             data-name="Skip">
                                             <div class="w-24 h-24 md:w-32 md:h-32 lg:w-40 lg:h-40 rounded-lg overflow-hidden mx-auto mb-3 shadow-lg transition-transform group-hover:scale-110 candidate-image">
                                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-blue-400">
                                                     <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4-10H8v2h8v-2z"/>
                                                 </svg>
                                             </div>
                                             <div class="space-y-1">
                                                 <h3 class="text-lg md:text-xl font-semibold text-blue-900">
                                                     Skip
                                                 </h3>
                                                 <p class="text-xs md:text-sm text-gray-600">Choose this option to skip this portfolio.</p>
                                             </div>
                                             <div class="absolute top-2 right-2 bg-blue-500 text-white rounded-full w-6 h-6 md:w-8 md:h-8 flex items-center justify-center selection-indicator opacity-0">
                                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                 </svg>
                                             </div>
                                             <input 
                                                 type="radio" 
                                                 name="votes[{{$portfolio->id}}]" 
                                                 value="skip" 
                                                 class="hidden vote-radio"
                                             >
                                             <!-- Thumbs-up for Skip -->
                                             <div class="thumbs-up">
                                                 <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#50b464" stroke="#50b464">
                                                     <path fill="#75cc8b" d="M238.986 26.47c-.825-.01-1.648-.008-2.47.003-7.52.096-14.927.958-22.188 2.578-58.085 12.96-102.088 73.253-116.93 166.41l17.776 2.833c14.167-88.922 54.783-140.9 103.074-151.674 48.29-10.776 108.966 18.458 165.854 102.81l14.923-10.065C348.077 63.82 290.963 26.958 238.985 26.47zm-7.363 42.24c-.82.008-1.638.028-2.453.06-7.827.32-15.446 1.826-22.76 4.642-19.504 7.51-36.01 23.927-49.05 48.692l15.93 8.384c11.668-22.164 25.08-34.694 39.587-40.28 14.506-5.584 30.932-4.625 50.006 3.032 38.147 15.314 84.798 58.2 132.805 120.473l14.255-10.99C360.977 139.203 313.59 94.2 269.588 76.535c-12.89-5.175-25.67-7.935-37.965-7.824zm-.592 39.466c-6.247-.03-12.35 1.114-17.99 3.853-8.596 4.174-15.492 11.964-19.933 22.44l16.575 7.024c3.164-7.466 6.913-11.18 11.22-13.273 4.308-2.09 9.795-2.65 16.82-1.382 14.05 2.538 33.037 12.87 51.923 26.805 37.77 27.872 76.124 69.76 87.81 84.947l14.266-10.977c-13.402-17.418-51.44-58.976-91.388-88.455-19.974-14.74-40.18-26.56-59.41-30.035-2.404-.434-4.812-.73-7.205-.865-.898-.05-1.793-.078-2.686-.082zm-81.47 32.566c-4.498 8.93-10.762 28.084-16.716 46.45-5.954 18.37-11.03 34.984-11.03 34.984l17.215 5.258s5.04-16.497 10.937-34.69c5.897-18.193 13.22-39.045 15.668-43.906l-16.076-8.096zm33.135 10.406c-11.62 24.464-19.368 51.84-11.992 78.483 12.94 46.74 44.042 99.694 95.953 113.173l4.524-17.422c-42.188-10.953-71.27-57.717-83.13-100.552-5.63-20.338.214-43.448 10.905-65.957l-16.26-7.722zm62.535 5.106c-.892-.006-1.79.03-2.687.105-5.386.452-10.798 2.364-15.58 5.724-6.377 4.48-11.795 11.174-16.85 20.187-8.915 15.9-7.64 33.784-.644 49.748 6.996 15.963 19.326 30.832 33.776 44.326 28.9 26.987 66.05 48.325 90.55 56.088l5.438-17.16c-20.146-6.384-57.082-27.224-83.703-52.083-13.31-12.43-24.097-25.9-29.575-38.4-5.478-12.498-6.038-23.2-.143-33.714 4.197-7.484 8.21-11.952 11.497-14.262 3.286-2.31 5.69-2.816 8.82-2.507 6.26.616 16.157 6.88 27.296 17.298 22.278 20.836 48.945 55.515 83.428 71.965l7.75-16.246c-28.587-13.637-54.798-46.34-78.883-68.865-12.042-11.264-23.702-20.677-37.825-22.067-.883-.087-1.772-.134-2.665-.14zm5.364 40.775l-16.776 6.53c2.782 7.147 8.363 13.638 16.41 22.764 8.044 9.127 18.362 19.68 29.506 29.973 11.145 10.292 23.087 20.304 34.475 28.307 11.387 8.002 21.89 14.153 32.185 16.255l3.6-17.635c-5.244-1.072-14.994-6.01-25.436-13.348-10.443-7.338-21.91-16.918-32.613-26.803-10.703-9.885-20.672-20.095-28.217-28.654-7.545-8.56-12.858-16.675-13.136-17.39zM88.127 220.474c-2.7 20.7-.85 50.2 3.195 78.19 4.047 27.99 9.704 53.42 17.936 67.9l15.648-8.893c-5.04-8.866-11.88-34.672-15.77-61.584-3.89-26.912-5.418-55.978-3.16-73.283l-17.85-2.33zm73.61 25.02l-17.7 3.27c2.796 15.14 14.096 38.007 29.256 60.63 15.16 22.626 33.31 44.284 54.36 51.572l5.89-17.01c-12.623-4.37-31.124-23.427-45.297-44.58-14.173-21.153-24.89-45.124-26.508-53.88zm252.634 5.062c-2.82 33.908-22.99 91.907-48.016 123.775l14.156 11.117c28.46-36.242 48.56-94.502 51.8-133.4l-17.94-1.493zm-281.52.52l-17.68 3.378c1.068 5.59 5.258 22.92 10.605 41.943 5.348 19.023 10.998 38.17 17.39 48.89l15.46-9.22c-3.356-5.627-10.293-25.942-15.52-44.54-5.23-18.6-9.606-37.052-10.255-40.45zm248.185 2.534c-1.81 9.433-8.274 30.502-16.16 50.767-7.886 20.265-17.88 40.592-24.223 48.08l13.735 11.635c9.955-11.752 19.076-32.155 27.26-53.188 8.186-21.032 14.75-41.828 17.066-53.902l-17.678-3.39zm-92.95 78.95l-5.456 17.155 38.75 12.33 5.46-17.154-38.754-12.33zm-107.954 15.557c-11.333 2.277-25.168 9.124-37.747 16.14-6.29 3.506-12.093 7.053-16.697 10.175-2.303 1.56-4.3 3.005-5.997 4.384-1.698 1.38-2.99 2.174-4.71 4.936l15.282 9.51c-.908 1.46-.3.4.78-.477 1.078-.877 2.734-2.093 4.743-3.455 4.018-2.724 9.477-6.068 15.365-9.35 11.776-6.568 25.96-12.897 32.526-14.216l-3.545-17.647zm74.585 22.2c-36.986-.37-71.186 11.506-107.762 36.814l10.242 14.804c55.303-38.266 98.21-43.222 162.315-20.97l5.902-17.003c-25.312-8.786-48.506-13.418-70.697-13.642zm86.65 13.43l-8.676 15.773 23.486 12.916 8.676-15.772-23.487-12.916zm-75 15.56c-1.832-.01-3.68.02-5.545.09-26.098.99-55.397 9.924-90.466 30.898l9.238 15.447c37.99-22.72 66.52-29.49 91.373-28.312 24.852 1.177 46.713 10.534 70.77 22.2l7.855-16.198c-24.482-11.87-48.933-22.616-77.774-23.983-1.802-.086-3.618-.134-5.45-.143zm-.982 30.425c-5.37-.054-10.583.356-15.57 1.15-22.792 3.62-40.893 14.478-51.016 25.975l13.51 11.895c6.516-7.4 21.822-17.154 40.334-20.096 18.512-2.942 40.22.146 62.45 17.33l11.01-14.24c-19.497-15.07-39.837-21.312-58.405-21.96-.773-.028-1.545-.046-2.312-.054zm2.635 37.336c-1.556-.014-3.112.017-4.668.096-12.448.633-24.804 4.333-35.22 12.51l11.116 14.158c13.707-10.76 36.382-10.437 53.49-3.95l6.38-16.83c-9.433-3.577-20.212-5.886-31.098-5.984z"/>
                                                 </svg>
                                             </div>
                                         </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Submit Button - Fixed at bottom -->
                            <div class="fixed-footer bg-blue-50 p-4 md:p-6 shadow-lg">
                                <button 
                                    type="button" 
                                    id="submitBtn"
                                    class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-900 transition w-full font-bold text-lg"
                                    disabled
                                >
                                    Submit Your Votes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Modal -->
        <div id="previewModal" class="preview-modal">
            <div class="preview-content">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-blue-900">Your Selections</h2>
                    <button id="closePreview" class="text-gray-500 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="previewContent" class="space-y-4">
                    <!-- Preview content will be inserted here -->
                </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <button id="editSelections" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition text-gray-800 font-medium">
                        Edit Selections
                    </button>
                    <button id="confirmSubmit" 
                        class="px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700 transition text-white font-medium">
                        Confirm & Submit
                    </button>
                </div>
            </div>
        </div>
        <!-- JavaScript for Validation and Interaction -->
        <script>
             document.addEventListener('DOMContentLoaded', function() {
                const portfolios = @json($portfolios);
                const voteForm = document.getElementById('voteForm');
                const submitBtn = document.getElementById('submitBtn');
                const previewBtn = document.getElementById('previewBtn');
                const previewModal = document.getElementById('previewModal');
                const closePreview = document.getElementById('closePreview');
                const editSelections = document.getElementById('editSelections');
                const confirmSubmit = document.getElementById('confirmSubmit');
                const previewContent = document.getElementById('previewContent');
                const progressStatus = document.getElementById('progressStatus');
                const validationToast = document.getElementById('validationToast');
                const toastMessage = document.getElementById('toastMessage');
                
                // Make candidate cards clickable
                document.querySelectorAll('.candidate-card').forEach(card => {
                    card.addEventListener('click', function() {
                        const portfolioId = this.getAttribute('data-portfolio-id');
                        const value = this.getAttribute('data-value');
                        const radioInput = this.querySelector(`input[value="${value}"]`);
                        
                        // Deselect all in the same portfolio
                        document.querySelectorAll(`.candidate-card[data-portfolio-id="${portfolioId}"]`).forEach(otherCard => {
                            otherCard.classList.remove('selected');
                            otherCard.querySelector('.selection-indicator').classList.add('opacity-0');
                            otherCard.querySelector('.thumbs-up').style.display = 'none'; // Hide thumbs-up for other cards
                        });
                        
                        // Select this card
                        this.classList.add('selected');
                        this.querySelector('.selection-indicator').classList.remove('opacity-0');
                        this.querySelector('.thumbs-up').style.display = 'block'; // Show thumbs-up for selected card
                        radioInput.checked = true;
                        
                        // Remove error indicator
                        document.getElementById(`error-indicator-${portfolioId}`).classList.remove('visible');
                        document.getElementById(`portfolio-${portfolioId}`).classList.remove('portfolio-missing');
                        
                        // Update progress
                        updateProgress();
                    });
                });
                document.getElementById("confirmSubmit").addEventListener("click", function() {
                        let submitBtn = document.getElementById("submitBtn");
                        let confirmSubmit =document.getElementById("confirmSubmit");
                        // Disable the button to prevent double-clicking
                        submitBtn.disabled = true;
                        confirmSubmit.disabled = true;
                        // Change text and add a spinner
                        submitBtn.innerHTML = `
                            <div class="loading-spinner"></div> Submitting...
                        `;
                        confirmSubmit.innerHTML = `
                            <div class="loading-spinner"></div> Submitting...
                        `;

                        // Simulate form submission delay (replace with actual request)
                        setTimeout(() => {
                            submitBtn.innerHTML = "Submit Your Votes";
                            submitBtn.disabled = false; // Enable button again (remove in real submission)
                        }, 3000);

                        setTimeout(() => {
                            confirmSubmit.innerHTML = "Submit Your Votes";
                            confirmSubmit.disabled = false; // Enable button again (remove in real submission)
                        }, 3000);
                    });
                // Make navigation items clickable with error highlighting
                document.querySelectorAll('.portfolio-nav-item').forEach(item => {
                    item.addEventListener('click', function(e) {
                        const portfolioId = this.getAttribute('data-portfolio-id');
                        const portfolioSection = document.getElementById(`portfolio-${portfolioId}`);
                        
                        e.preventDefault();
                        portfolioSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                
                // Helper function to check for missing selections
                function checkMissingSelections() {
                    const missingPortfolios = [];
                    
                    portfolios.forEach(portfolio => {
                        const portfolioVote = document.querySelector(`input[name="votes[${portfolio.id}]"]:checked`);
                        if (!portfolioVote) {
                            missingPortfolios.push(portfolio.name);
                            
                            // Highlight the portfolio section
                            const portfolioSection = document.getElementById(`portfolio-${portfolio.id}`);
                            portfolioSection.classList.add('portfolio-missing');
                            document.getElementById(`error-indicator-${portfolio.id}`).classList.add('visible');
                        }
                    });
                    
                    return missingPortfolios;
                }
                
                // Update progress function
                function updateProgress() {
                    let selectedCount = 0;
                    let totalCount = portfolios.length;
                    
                    portfolios.forEach(portfolio => {
                        const isSelected = document.querySelector(`input[name="votes[${portfolio.id}]"]:checked`);
                        if (isSelected) {
                            selectedCount++;
                            
                            // Ensure no error highlighting for selected portfolios
                            document.getElementById(`portfolio-${portfolio.id}`).classList.remove('portfolio-missing');
                            document.getElementById(`error-indicator-${portfolio.id}`).classList.remove('visible');
                        }
                    });
                    
                    // Update status text and enable/disable submit button
                    if (selectedCount === totalCount) {
                        progressStatus.textContent = "All positions selected! Review or submit.";
                        progressStatus.classList.remove('text-blue-800');
                        progressStatus.classList.add('text-green-600');
                        submitBtn.disabled = false;
                    } else {
                        progressStatus.textContent = `Select all positions to continue (${selectedCount}/${totalCount})`;
                        progressStatus.classList.remove('text-green-600');
                        progressStatus.classList.add('text-blue-800');
                        submitBtn.disabled = true;
                    }
                }
                
                // Show toast notification
                function showToast(message) {
                    toastMessage.textContent = message;
                    validationToast.classList.add('visible');
                    
                    setTimeout(() => {
                        validationToast.classList.remove('visible');
                    }, 5000);
                }
                
                // Preview button click - existing functionality
                previewBtn.addEventListener('click', function() {
                    // Check for missing selections before showing preview
                    const missingPortfolios = checkMissingSelections();
                    
                    if (missingPortfolios.length > 0) {
                        // Show toast for missing selections
                        showToast(`Please select a candidate or skip for: ${missingPortfolios.join(', ')}`);
                        
                        // Scroll to first missing section
                        const firstMissing = portfolios.find(p => p.name === missingPortfolios[0]);
                        document.getElementById(`portfolio-${firstMissing.id}`).scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                        
                        return; // Don't show preview if selections are incomplete
                    }
                    
                    buildPreviewContent();
                    previewModal.style.display = 'block';
                });
                
                // Submit button now works like preview
                submitBtn.addEventListener('click', function() {
                    // Check for missing selections
                    const missingPortfolios = checkMissingSelections();
                    
                    if (missingPortfolios.length > 0) {
                        // Show error toast and scroll to first missing section
                        showToast(`Please select a candidate or skip for: ${missingPortfolios.join(', ')}`);
                        const firstMissing = portfolios.find(p => p.name === missingPortfolios[0]);
                        document.getElementById(`portfolio-${firstMissing.id}`).scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    } else {
                        // Build preview content and show preview modal
                        buildPreviewContent();
                        previewModal.style.display = 'block';
                    }
                });
                
                // Function to build preview content
                function buildPreviewContent() {
                    previewContent.innerHTML = ''; // Clear previous content
                    portfolios.forEach(portfolio => {
                        const selectedOption = document.querySelector(`input[name="votes[${portfolio.id}]"]:checked`);
                        const selectionDiv = document.createElement('div');
                        selectionDiv.className = 'p-3 bg-blue-50 rounded-lg';
                        
                        const portfolioTitle = document.createElement('h3');
                        portfolioTitle.className = 'font-semibold text-blue-900';
                        portfolioTitle.textContent = portfolio.name;
                        selectionDiv.appendChild(portfolioTitle);
                        
                        const selectionInfo = document.createElement('div'); // Changed to div for better structure
                        selectionInfo.className = 'text-gray-700 mt-1 flex items-center gap-2'; // Added flex for image+text layout
                        
                        if (selectedOption) {
                            const card = document.querySelector(`.candidate-card[data-portfolio-id="${portfolio.id}"][data-value="${selectedOption.value}"]`);
                            const candidateImage = card.getAttribute('data-image');
                            const candidateName = card.getAttribute('data-name');
                            const candidateNumber = card.getAttribute('data-number');
                            
                            if (selectedOption.value === 'skip') {
                                selectionInfo.textContent = 'SKIPPED';
                                selectionInfo.className += ' italic text-gray-500';
                            } else {
                                // Create image element if image exists
                                if (candidateImage) {
                                    const img = document.createElement('img');
                                    img.src =  candidateImage;
                                    img.alt = candidateName;
                                    img.className = 'w-12 h-12 rounded-full object-cover'; // Adjust size as needed
                                    selectionInfo.appendChild(img);
                                }
                                
                                // Create text node for name and number
                                const textNode = document.createTextNode(candidateName + (candidateNumber ? ` (#${candidateNumber})` : ''));
                                selectionInfo.appendChild(textNode);
                            }
                        } else {
                            selectionInfo.textContent = 'Not selected';
                            selectionInfo.className += ' text-red-500';
                        }
                        
                        selectionDiv.appendChild(selectionInfo);
                        previewContent.appendChild(selectionDiv);
                    });
                }
                
                // Close preview on button click
                closePreview.addEventListener('click', function() {
                    previewModal.style.display = 'none';
                });
                
                // Close preview on edit button click
                editSelections.addEventListener('click', function() {
                    previewModal.style.display = 'none';
                });
                
                // Confirm submit from preview modal
                confirmSubmit.addEventListener('click', function() {
                    // Final validation check before submission
                    const missingPortfolios = checkMissingSelections();
                    if (missingPortfolios.length > 0) {
                        previewModal.style.display = 'none';
                        showToast(`Please select a candidate or skip for: ${missingPortfolios.join(', ')}`);
                        const firstMissing = portfolios.find(p => p.name === missingPortfolios[0]);
                        document.getElementById(`portfolio-${firstMissing.id}`).scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    } else {
                        voteForm.submit();
                    }
                });
                
                // Close modal when clicking outside of it
                window.addEventListener('click', function(event) {
                    if (event.target === previewModal) {
                        previewModal.style.display = 'none';
                    }
                });
                
                // Initialize progress on page load
                updateProgress();
            });
        </script>
    </body>
</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth