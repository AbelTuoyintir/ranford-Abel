<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCC‑EVOTE · WhatsApp voting</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class="rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])
    <script src="https://unpkg.com/gsap@3.12.2/dist/gsap.min.js"></script>
    <style>
        :root {
            --ucc-navy: #00205B;
            --ucc-gold: #FFD700;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding-top: 80px; /* sticky header offset */
        }

        .ucc-navy {
            background-color: var(--ucc-navy);
        }

        .ucc-gold {
            background-color: var(--ucc-gold);
        }

        .text-ucc-navy {
            color: var(--ucc-navy);
        }

        .text-ucc-gold {
            color: var(--ucc-gold);
        }

        .border-ucc-navy {
            border-color: var(--ucc-navy);
        }

        .border-ucc-gold {
            border-color: var(--ucc-gold);
        }

        .btn-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 32, 91, 0.3);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 32, 91, 0.2);
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* fixed header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            width: 100%;
        }

        .slide-in-section {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .slide-in-section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* WhatsApp vote section (originally .voting-section) */
        .voting-section {
            max-width: 1200px;
            margin: auto;
            padding: 60px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
        }

        .voting-content {
            flex: 1;
        }

        .voting-content h2 {
            font-size: 38px;
            color: #1e1e1e;
            margin-bottom: 20px;
        }

        .voting-content h2 span {
            color: #25D366; /* WhatsApp green */
        }

        .voting-content p {
            font-size: 17px;
            line-height: 1.7;
            color: #555;
            margin-bottom: 15px;
        }

        .features {
            margin-top: 25px;
        }

        .features li {
            list-style: none;
            margin-bottom: 12px;
            font-size: 16px;
            color: #333;
        }

        .features li::before {
            content: "✔";
            color: #25D366;
            margin-right: 10px;
            font-weight: bold;
        }

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .blob {
            width: 380px;
            height: 380px;
            background: #25D366;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .blob img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .voting-section {
                flex-direction: column-reverse;
                text-align: center;
            }

            .blob {
                width: 300px;
                height: 300px;
            }
        }

        /* custom WhatsApp button */
        .whatsapp-btn {
            background-color: #25D366;
            color: white;
            font-weight: 600;
            padding: 14px 32px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 1.25rem;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 16px rgba(37, 211, 102, 0.3);
            margin-top: 20px;
            text-decoration: none;
        }

        .whatsapp-btn:hover {
            background-color: #20b859;
            transform: scale(1.05);
            box-shadow: 0 12px 24px rgba(37, 211, 102, 0.4);
        }

        .whatsapp-btn i {
            font-size: 1.8rem;
        }

        /* simple whatsapp icon fallback (svg) */
        .wa-icon {
            width: 28px;
            height: 28px;
            fill: white;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="ucc-navy text-white shadow-lg">
            <div class="container mx-auto px-4 py-3 flex items-center justify-between space-x-2">
                <div class="flex items-center">
                    <!-- UCC Logo -->
                    <img src="{{ asset('images/IMG_202411319_103428204.png') }}" alt="" class="h-10 w-10 rounded-lg m-1" />
                    <div>
                        <h1 class="text-xl font-bold">University of Cape Coast</h1>
                        <p class="text-sm text-ucc-gold">Electronic Voting Portal</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="py-16 md:py-24 bg-gradient-to-b from-gray-100 to-white flex-grow slide-in-section">
            <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0 sm:w-1/4 mb-4">
                    <h1 class="text-4xl md:text-5xl font-bold text-ucc-navy mb-4">Your Vote, Your Voice</h1>
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-6">UCC Electronic Voting System</h2>
                    <p class="text-lg text-gray-600 mb-8">Secure, transparent, and accessible elections for the University of Cape Coast community. Cast your vote and make a difference today.</p>
                    <div class="flex flex-col-3 sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6">
                        <a href="#options" class="ucc-navy text-white border-2 py-3 px-6 rounded-lg text-lg font-semibold transition duration-300 btn-hover sm:text-small">Get Started</a>
                        <a href="#" class="bg-white text-ucc-navy border-2 border-ucc-navy py-3 px-6 rounded-lg text-lg font-semibold transition duration-300 btn-hover sm:text-small">Learn More</a>
                        <a href="{{route('/normination-landing-page')}}" class="ucc-gold border-2 text-ucc-navy py-3 px-6 rounded-lg text-lg font-semibold transition duration-300 pulse sm:text-small">Fill Nomination Form</a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <img src="{{ asset('images/girl.jpg') }}" alt="African University Voting" class="w-full max-w-md rounded-lg shadow-lg">
                </div>
            </div>
        </section>

        <!-- WhatsApp voting section (originally .voting-section) with new button -->
        <section class="voting-section slide-in-section">
            <div class="voting-content">
                <h2 class="text-4xl md:text-5xl font-bold text-ucc-navy">Vote Easily Using <span class="font-bold">WhatsApp</span></h2>
                <p>
                    Our voting platform allows supporters to vote for their favorite contestants
                    directly through WhatsApp — no USSD codes, no complicated steps, and no expensive charges.
                </p>
                <p>
                    With just a simple WhatsApp message, users can cast their votes instantly from anywhere,
                    making the voting process faster, cheaper, and more accessible for everyone.
                </p>
                <ul class="features">
                    <li>No USSD dialing required</li>
                    <li>No extra charges or hidden fees</li>
                    <li>Fast and secure real-time voting</li>
                    <li>Works on any smartphone with WhatsApp</li>
                    <li>User-friendly and highly reliable</li>
                    <li>Perfect for award nights and special events</li>
                    <li>Affordable voting solution - no premium charges required</li>
                </ul>

                <!-- NEW: WhatsApp vote button redirecting to oyalo.net -->
                <a href="https://vote.oyalo.net" target="_blank" rel="noopener noreferrer" class="whatsapp-btn">
                    <!-- inline SVG for WhatsApp -->
                    <svg class="wa-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.077 4.928C17.191 3.041 14.683 2 12.006 2 6.798 2 2.548 6.193 2.54 11.393c-.003 1.747.456 3.457 1.328 4.985L2.25 21.75l5.433-1.574c1.483.834 3.152 1.27 4.86 1.27h.004c5.2 0 9.454-4.195 9.462-9.396.004-2.512-.972-4.876-2.86-6.764zM12.023 20.04h-.003c-1.483 0-2.94-.398-4.205-1.15l-.302-.18-3.226.935.997-3.148-.184-.308A8.277 8.277 0 0 1 4.54 11.4c.008-4.317 3.519-7.824 7.845-7.824 2.098 0 4.067.817 5.55 2.3a7.758 7.758 0 0 1 2.302 5.525c-.008 4.32-3.519 7.826-7.842 7.826zm4.303-5.918c-.236-.118-1.393-.687-1.61-.765-.215-.078-.372-.118-.528.118-.156.235-.604.764-.74.92-.137.157-.274.176-.51.059-.973-.51-1.847-1.13-2.577-1.88-.195-.196-.37-.41-.528-.642.07-.046.13-.104.18-.171.157-.215.316-.43.447-.667.1-.18.16-.39.176-.604 0-.236-.12-.447-.3-.585-.332-.254-.666-.5-1.014-.724-.214-.137-.45-.235-.697-.282-.207-.04-.416-.017-.612.067-.186.082-.34.218-.444.391-.11.186-.173.4-.184.618-.012.26.038.52.146.76.116.26.284.498.494.702.194.189.39.376.596.553.526.45 1.13.803 1.782 1.04.334.117.672.217 1.016.3.427.098.855.142 1.285.133.433-.013.86-.106 1.26-.278.33-.14.634-.338.896-.582.137-.13.255-.277.352-.437.06-.103.09-.22.087-.337 0-.12-.043-.236-.123-.33-.09-.108-.22-.182-.363-.21-.088-.018-.177-.024-.266-.02-.113.007-.226.024-.336.054-.15.042-.295.103-.43.18-.11.06-.215.13-.314.208.096-.196.215-.38.355-.55.184-.22.4-.412.64-.57.154-.103.316-.194.483-.27.15-.066.31-.112.473-.135.176-.024.356-.024.532 0 .142.018.282.058.414.118.245.11.454.294.6.523.137.214.212.463.215.718.007.314-.1.623-.297.873-.102.133-.224.248-.36.343-.148.104-.301.2-.46.287-.15.082-.298.167-.44.263-.12.08-.228.176-.32.286-.087.108-.154.23-.2.36-.034.1-.05.206-.045.312.006.112.03.223.07.33.07.193.198.36.366.484.182.131.39.219.61.255.147.025.298.025.446 0 .197-.03.388-.097.562-.196.148-.085.285-.188.407-.306.17-.164.312-.355.419-.565.08-.16.13-.332.15-.508.014-.17.002-.34-.036-.506-.033-.144-.1-.28-.19-.398-.09-.118-.2-.217-.33-.29z"/>
                    </svg>
                    <span>Vote via WhatsApp → vote.oyalo.net</span>
                </a>
            </div>

            <div class="image-container">
                <div class="blob">
                    <img src="{{ asset('images/w1.jpeg') }}" alt="WhatsApp Voting">
                </div>
            </div>
        </section>

        <!-- Options Section -->
        <section id="options" class="py-16 bg-gray-100 ">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-ucc-navy mb-12">Choose Your Path</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Check Registration Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transition duration-500 card-hover">
                        <div class="ucc-navy p-4">
                            <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-ucc-navy mb-2">Check Registration Status</h3>
                            <p class="text-gray-600 mb-4">Verify if you're registered to vote in the upcoming elections.</p>
                            <a href="{{route('/voters/register')}}" class="block text-center ucc-gold text-ucc-navy font-bold py-2 rounded-lg transition duration-300 hover:bg-yellow-400">Check Now</a>
                        </div>
                    </div>

                    <!-- Voter Login Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transition duration-500 card-hover">
                        <div class="ucc-navy p-4">
                            <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-ucc-navy mb-2">Login as Voter</h3>
                            <p class="text-gray-600 mb-4">Access your voting portal to cast your vote securely.</p>
                            <a href="{{route('/student')}}" class="block text-center ucc-gold text-ucc-navy font-bold py-2 rounded-lg transition duration-300 hover:bg-yellow-400">Voter Login</a>
                        </div>
                    </div>

                    <!-- Candidate Login Card -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transition duration-500 card-hover">
                        <div class="ucc-navy p-4">
                            <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-ucc-navy mb-2">Candidate Portal</h3>
                            <p class="text-gray-600 mb-4">Candidates can access their dashboard and monitor results.</p>
                            <a href="{{route('/candidate')}}" class="block text-center ucc-gold text-ucc-navy font-bold py-2 rounded-lg transition duration-300 hover:bg-yellow-400">Candidate Login</a>
                        </div>
                    </div>

                    <!-- Admin Login Card -->
                    {{-- <div class="bg-white rounded-xl shadow-lg overflow-hidden transition duration-500 card-hover">
                        <div class="ucc-navy p-4">
                            <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-ucc-navy mb-2">Administration</h3>
                            <p class="text-gray-600 mb-4">Election administrators can manage the entire voting process and view public opinions.</p>
                            <a href="{{route('/admin')}}" class="block text-center ucc-gold text-ucc-navy font-bold py-2 rounded-lg transition duration-300 hover:bg-yellow-400">Admin Login</a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-white slide-in-section">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-ucc-navy mb-4">Why Choose Our E-Voting System?</h2>
                <p class="text-center text-gray-600 mb-12 max-w-3xl mx-auto">Our electronic voting system is designed with security, accessibility, and transparency in mind.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-ucc-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-ucc-navy mb-2">Secure Voting</h3>
                        <p class="text-gray-600">Advanced encryption and authentication protocols ensure your vote remains secure and confidential.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-ucc-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-ucc-navy mb-2">Transparent Process</h3>
                        <p class="text-gray-600">Real-time updates and auditable records ensure transparency throughout the entire electoral process.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-ucc-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-ucc-navy mb-2">Vote Anywhere</h3>
                        <p class="text-gray-600">Cast your vote from anywhere on campus or remotely using your student credentials.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Email Verification Section -->
        <section class="py-16 bg-gray-100 slide-in-section">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-ucc-navy mb-4">Email or Google Verification</h2>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                    A verification email will be sent to your Gmail. Use the password provided to log in and change it, or verify you with Google.
                </p>
                <a href="{{route('/google-verification')}}" class="ucc-navy text-white py-3 px-8 rounded-lg text-lg font-semibold transition duration-300 btn-hover inline-flex items-center justify-center">
                    <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <path fill="#4285F4" d="M45.12 24.5c0-1.56-.14-3.06-.4-4.5H24v8.51h11.84c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.56-9.47 6.56-16.17z"/>
                        <path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.31-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"/>
                        <path fill="#FBBC05" d="M11.69 28.18C11.25 26.86 11 25.45 11 24s.25-2.86.69-4.18v-5.7H4.34C2.85 17.09 2 20.45 2 24s.85 6.91 2.34 9.88l7.35-5.7z"/>
                        <path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.92 4.18 29.94 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.35 5.7c1.73-5.2 6.58-9.07 12.31-9.07z"/>
                    </svg>
                    Verify with Google
                </a>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 ucc-navy slide-in-section">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Grab Your Nomination Form</h2>
                <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto">Be a part of shaping the future of UCC. Nominate yourself or your candidate for the upcoming elections.</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{route('/normination-landing-page')}}" class="ucc-gold text-ucc-navy py-3 px-8 rounded-lg text-lg font-semibold transition duration-300 pulse">Fill Nomination Form</a>
                    <a href="{{route('/public-room')}}" class="bg-transparent text-white border-2 border-white py-3 px-8 rounded-lg text-lg font-semibold transition duration-300 hover:bg-white hover:text-black">Public Room</a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8 slide-in-section">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                        <h3 class="text-lg font-bold mb-4">UCC E-Vote</h3>
                        <p class="text-gray-400">Your secure platform for campus elections.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">Home</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">About</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">Elections</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">Help Center</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-4">Contact</h3>
                        <ul class="space-y-2">
                            <li class="text-gray-400">University of Cape Coast</li>
                            <li class="text-gray-400">Cape Coast, Ghana</li>
                            <li class="text-gray-400">Email: evoting@ucc.edu.gh</li>
                            <li class="text-gray-400">Phone: +233 XX XXX XXXX</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-4">Stay Connected</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124-4.09-.193-7.715-2.157-10.141-5.126-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 14-7.503 14-14v-.617c.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-ucc-gold transition duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <hr class="my-6 border-gray-700">
                <p class="text-center text-gray-500">&copy; 2025 University of Cape Coast E-Voting System. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ballot animation
            gsap.timeline({repeat: -1, repeatDelay: 2})
                .to("#ballot", {y: -20, duration: 1})
                .to("#ballot", {y: 150, duration: 1, delay: 0.5, ease: "bounce.out"});

            // Scroll animation for cards
            const cards = document.querySelectorAll('.card-hover');

            function checkScroll() {
                cards.forEach(card => {
                    const cardPosition = card.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.3;

                    if (cardPosition < screenPosition) {
                        card.style.opacity = 1;
                        card.style.transform = 'translateY(0)';
                    }
                });
            }

            cards.forEach(card => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(50px)';
                card.style.transition = 'all 0.6s ease-out';
            });

            window.addEventListener('scroll', checkScroll);
            checkScroll();

            // Intersection observer for slide-in sections
            const sections = document.querySelectorAll('.slide-in-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        gsap.to(entry.target, {
                            opacity: 1,
                            y: 0,
                            duration: 1,
                            ease: "power2.out"
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            sections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>
</body>
</html>