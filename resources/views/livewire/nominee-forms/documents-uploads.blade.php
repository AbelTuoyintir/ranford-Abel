@auth('ticket')
@php
    $existingDocs = $existingDocs ?? collect();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>UCC-EVOTE | Nomination Document Center</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon">
    @vite(["resources/css/app.css","resources/js/app.js"])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ========== UCC OFFICIAL COLOR SCHEME ========== */
        :root {
            --ucc-navy: #00205B;
            --ucc-dark-navy: #00143d;
            --ucc-gold: #FFD700;
            --ucc-light-gold: #fff9e6;
            --ucc-blue: #1a4c8c;
            --ucc-light-blue: #e8f1f8;
            --accent-teal: #00bcd4;
            --accent-green: #4caf50;
            --accent-orange: #ff9800;
            --accent-purple: #9c27b0;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #eef2f5 50%, #f8f4e6 100%);
            min-height: 100vh;
            color: var(--ucc-navy);
            position: relative;
        }

        /* Background pattern overlay */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cpath fill='%2300205B' fill-opacity='0.03' d='M100 0L200 100L100 200L0 100L100 0z'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 40px;
            pointer-events: none;
            z-index: 0;
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            min-height: 100vh;
        }

        /* ========== FLOATING DECORATIONS ========== */
        .floating-icon {
            position: fixed;
            opacity: 0.1;
            pointer-events: none;
            z-index: 0;
            font-size: 8rem;
            color: var(--ucc-gold);
        }

        .floating-1 { top: 10%; left: -5%; animation: float 20s infinite ease-in-out; }
        .floating-2 { bottom: 15%; right: -5%; animation: float 25s infinite reverse ease-in-out; }
        .floating-3 { top: 40%; right: 5%; animation: float 18s infinite ease-in-out; animation-delay: 2s; }
        
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(20px, -30px) rotate(10deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: var(--ucc-light-gold);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--ucc-gold);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #e6c200;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideInLeft {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        @keyframes pulse-gold {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(255, 215, 0, 0); }
        }
        @keyframes bounce-icon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* ========== TOAST NOTIFICATIONS ========== */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 500px;
            width: 100%;
        }

        .toast {
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.4s ease-out;
            backdrop-filter: blur(10px);
        }

        .toast.success {
            background: linear-gradient(135deg, var(--accent-green) 0%, #45a049 100%);
            color: white;
            border-left: 4px solid #4caf50;
        }

        .toast.error {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            border-left: 4px solid #ff4444;
        }

        .toast-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
            animation: bounce-icon 0.6s ease-in-out;
        }

        .toast-close {
            margin-left: auto;
            cursor: pointer;
            font-size: 1.2rem;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        .toast-close:hover {
            opacity: 1;
        }

        /* ========== HEADER HERO SECTION ========== */
        .header-section {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeIn 0.6s ease-out;
            position: relative;
        }

        .hero-illustration {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .hero-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 215, 0, 0.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--ucc-gold);
            backdrop-filter: blur(4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .hero-icon:hover {
            transform: translateY(-5px);
        }

        .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--ucc-gold) 0%, #e6c200 100%);
            color: var(--ucc-navy);
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
            animation: pulse-gold 2s infinite;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--ucc-navy) 0%, var(--ucc-blue) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 16px 0;
            letter-spacing: -1px;
            line-height: 1.1;
        }

        .page-subtitle {
            color: var(--ucc-navy);
            font-size: 1.2rem;
            margin: 16px 0;
            font-weight: 500;
            opacity: 0.8;
        }

        .header-actions {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-compress {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--accent-orange) 0%, #ff7043 100%);
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 8px 20px rgba(255, 152, 0, 0.3);
        }

        .btn-compress:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(255, 152, 0, 0.4);
        }

        /* ========== USER PROFILE CARD ========== */
        .profile-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: 0 10px 30px rgba(0, 32, 91, 0.1);
            border: 2px solid var(--ucc-light-gold);
            animation: fadeIn 0.6s ease-out 0.1s both;
            position: relative;
            overflow: hidden;
        }

        .profile-card::after {
            content: "📄";
            position: absolute;
            bottom: -10px;
            right: -10px;
            font-size: 5rem;
            opacity: 0.05;
            pointer-events: none;
            transform: rotate(-15deg);
        }

        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--ucc-gold) 0%, #e6c200 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ucc-navy);
            font-size: 1.8rem;
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
        }

        .profile-info h2 {
            margin: 0;
            font-size: 1.3rem;
            color: var(--ucc-navy);
            font-weight: 700;
        }

        .profile-info p {
            margin: 4px 0 0 0;
            font-size: 0.9rem;
            color: #666;
        }

        .progress-section {
            background: linear-gradient(135deg, var(--ucc-light-blue) 0%, var(--ucc-light-gold) 100%);
            padding: 16px;
            border-radius: 12px;
            border-left: 4px solid var(--ucc-gold);
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ucc-navy);
        }

        .progress-bar-container {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            overflow: hidden;
        }

        #progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--ucc-gold) 0%, var(--accent-green) 100%);
            transition: width 0.5s ease;
            border-radius: 10px;
        }

        /* ========== FORM SECTION ========== */
        .form-section {
            background: white;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 32px;
            box-shadow: 0 10px 30px rgba(0, 32, 91, 0.08);
            border: 1px solid rgba(255, 215, 0, 0.2);
            animation: fadeIn 0.6s ease-out 0.2s both;
            transition: transform 0.3s ease;
        }

        .form-section:hover {
            transform: translateY(-2px);
        }

        /* ========== SECTION HEADERS ========== */
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 3px solid var(--ucc-gold);
        }

        .section-number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--ucc-navy) 0%, var(--ucc-blue) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(0, 32, 91, 0.3);
        }

        .section-header h3 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--ucc-navy);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header i {
            font-size: 1.6rem;
            color: var(--ucc-gold);
        }

        /* ========== DOCUMENTS GRID ========== */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        /* ========== DOCUMENT CARD ========== */
        .doc-card {
            background: linear-gradient(135deg, #fafbfc 0%, #f5f7fa 100%);
            border: 2px solid #e0e6ed;
            border-radius: 14px;
            padding: 20px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .doc-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, var(--ucc-gold) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .doc-card:hover {
            border-color: var(--ucc-gold);
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.2);
            transform: translateY(-8px);
        }

        .doc-card:hover::before {
            opacity: 0.1;
        }

        .doc-card.uploaded {
            background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%);
            border-color: var(--accent-green);
            border-left: 5px solid var(--accent-green);
        }

        .doc-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .doc-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ucc-navy);
        }

        .doc-title i {
            font-size: 1.4rem;
            color: var(--ucc-gold);
            transition: transform 0.3s ease;
        }

        .doc-card:hover .doc-title i {
            transform: scale(1.2) rotate(10deg);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--accent-green) 0%, #45a049 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(76, 175, 80, 0.3);
        }

        .doc-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 16px;
            line-height: 1.6;
        }

        /* ========== FILE INPUT ========== */
        .file-input-wrapper {
            position: relative;
            margin-bottom: 12px;
        }

        .file-input-custom {
            width: 100%;
            padding: 12px;
            border: 2px dashed var(--ucc-gold);
            border-radius: 10px;
            background: rgba(255, 215, 0, 0.05);
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--ucc-navy);
            font-weight: 500;
        }

        .file-input-custom:hover {
            background: rgba(255, 215, 0, 0.1);
            border-color: #e6c200;
        }

        .file-input-custom::file-selector-button {
            background: linear-gradient(135deg, var(--ucc-navy) 0%, var(--ucc-blue) 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input-custom::file-selector-button:hover {
            background: linear-gradient(135deg, var(--ucc-dark-navy) 0%, var(--ucc-navy) 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 32, 91, 0.3);
        }

        .file-specs {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: #999;
            margin-top: 8px;
        }

        .file-specs i {
            color: var(--ucc-gold);
        }

        /* ========== STATUS MESSAGES ========== */
        .file-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--accent-green) 0%, #45a049 100%);
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
            animation: fadeIn 0.4s ease-out;
        }

        .error-badge {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 12px;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(238, 90, 111, 0.1) 100%);
            border-left: 4px solid #ff6b6b;
            border-radius: 8px;
            color: #ff4444;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 10px;
            animation: slideInLeft 0.4s ease-out;
        }

        /* ========== ACTION BUTTONS ========== */
        .button-section {
            background: linear-gradient(135deg, var(--ucc-light-blue) 0%, var(--ucc-light-gold) 100%);
            border: 2px solid var(--ucc-gold);
            border-radius: 16px;
            padding: 24px;
            margin-top: 32px;
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-action {
            flex: 1;
            min-width: 200px;
            padding: 16px 24px;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }

        .btn-action:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-action:active {
            transform: translateY(-2px);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--accent-orange) 0%, #ff7043 100%);
            color: white;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--ucc-navy) 0%, var(--ucc-blue) 100%);
            color: white;
        }

        .btn-action i {
            font-size: 1.25rem;
            transition: transform 0.3s ease;
        }

        .btn-action:hover i {
            transform: scale(1.2);
        }

        .button-warning {
            background: linear-gradient(135deg, var(--ucc-light-blue) 0%, white 100%);
            border: 2px solid var(--ucc-blue);
            border-radius: 12px;
            padding: 16px;
            margin-top: 12px;
            color: var(--ucc-navy);
            font-size: 0.9rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .button-warning i {
            color: var(--ucc-gold);
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* ========== REQUIREMENTS SECTION ========== */
        .requirements-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 40px;
            animation: fadeIn 0.6s ease-out 0.3s both;
        }

        .requirement-card {
            background: white;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 8px 25px rgba(0, 32, 91, 0.08);
            border-left: 5px solid var(--ucc-gold);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .requirement-card::before {
            content: "📋";
            position: absolute;
            bottom: -20px;
            right: -10px;
            font-size: 5rem;
            opacity: 0.05;
            pointer-events: none;
        }

        .requirement-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0, 32, 91, 0.15);
        }

        .requirement-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .requirement-header i {
            font-size: 1.8rem;
            color: var(--ucc-gold);
            transition: transform 0.3s ease;
        }

        .requirement-card:hover .requirement-header i {
            transform: scale(1.2) rotate(10deg);
        }

        .requirement-header h4 {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--ucc-navy);
        }

        .requirement-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .requirement-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px 0;
            font-size: 0.9rem;
            color: #555;
            line-height: 1.6;
            border-bottom: 1px solid #eee;
        }

        .requirement-list li:last-child {
            border-bottom: none;
        }

        .requirement-list li::before {
            content: '✓';
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            min-width: 24px;
            background: linear-gradient(135deg, var(--ucc-gold) 0%, #e6c200 100%);
            color: var(--ucc-navy);
            border-radius: 50%;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .help-card {
            background: linear-gradient(135deg, var(--accent-teal) 0%, #0097a7 100%);
            color: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0, 188, 212, 0.3);
        }

        .help-card i {
            color: white;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .page-wrapper {
                padding: 20px 12px;
            }

            .form-section {
                padding: 20px;
            }

            .page-title {
                font-size: 2.2rem;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-content {
                gap: 12px;
            }

            .documents-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .button-section {
                flex-direction: column;
            }

            .btn-action {
                min-width: 100%;
            }

            .requirements-section {
                grid-template-columns: 1fr;
            }

            .section-header h3 {
                font-size: 1.2rem;
            }

            .section-number {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating decorative icons -->
    <i class="fas fa-vote-yea floating-icon floating-1"></i>
    <i class="fas fa-file-alt floating-icon floating-2"></i>
    <i class="fas fa-graduation-cap floating-icon floating-3"></i>

    <!-- Toast Notifications -->
    @if(session('success') || session('error'))
        <div class="toast-container">
            @if(session('success'))
                <div class="toast success">
                    <i class="fas fa-check-circle toast-icon"></i>
                    <span>{{ session('success') }}</span>
                    <i class="fas fa-times toast-close" onclick="this.closest('.toast').remove()"></i>
                </div>
            @endif
            @if(session('error'))
                <div class="toast error">
                    <i class="fas fa-exclamation-circle toast-icon"></i>
                    <span>{{ session('error') }}</span>
                    <i class="fas fa-times toast-close" onclick="this.closest('.toast').remove()"></i>
                </div>
            @endif
        </div>
        <script>
            setTimeout(() => {
                const toasts = document.querySelectorAll('.toast');
                toasts.forEach(toast => {
                    toast.style.animation = 'slideOutRight 0.4s ease-out forwards';
                    setTimeout(() => toast.remove(), 400);
                });
            }, 5000);
        </script>
    @endif

    <div class="page-wrapper">
        <!-- Header Section -->
        <div class="header-section">
            <div class="hero-illustration">
                <div class="hero-icon"><i class="fas fa-check-circle"></i></div>
                <div class="hero-icon"><i class="fas fa-file-upload"></i></div>
                <div class="hero-icon"><i class="fas fa-user-check"></i></div>
            </div>
            <span class="header-badge">
                <i class="fas fa-university"></i>
                UCC Election Portal
            </span>
            <h1 class="page-title">Nomination Document Suite</h1>
            <p class="page-subtitle">Complete your candidacy with all required documents</p>
            <div class="header-actions">
                <a href="https://www.ilovepdf.com/compress_pdf" target="_blank" class="btn-compress">
                    <i class="fas fa-compress"></i> Compress PDF Files
                </a>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="profile-info">
                    <p><i class="fas fa-star" style="color: var(--ucc-gold);"></i> Welcome back, Aspirant</p>
                    <h2>{{ $user->full_name ?? 'Candidate' }}</h2>
                    <p><i class="fas fa-id-card"></i> ID: {{ $user->reg_number }}</p>
                </div>
            </div>
            <div class="progress-section">
                <div class="progress-label">
                    <span><i class="fas fa-chart-pie"></i> <strong>Document Completion</strong></span>
                    <span id="completion-percent" style="color: var(--ucc-navy); font-weight: 700;">0%</span>
                </div>
                <div class="progress-bar-container">
                    <div id="progress-bar" style="width: 0%"></div>
                </div>
                <p style="font-size: 0.8rem; color: #666; margin: 8px 0 0 0;">
                    <i class="fas fa-info-circle"></i> Upload documents to track your progress
                </p>
            </div>
        </div>

        <!-- Main Form -->
        <form method="POST" action="{{ route('nomination.documents.store', $user) }}" enctype="multipart/form-data" id="nominationForm">
            @csrf
            
            <!-- Section 1: Academic Documents -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-number">1</div>
                    <h3><i class="fas fa-book"></i> Academic Requirements</h3>
                </div>

                <div class="documents-grid">
                    <!-- CGPA Card -->
                    <div class="doc-card {{ $existingDocs->has('cgpa') ? 'uploaded' : '' }}">
                        <div class="doc-card-header">
                            <div class="doc-title">
                                <i class="fas fa-chart-line"></i>
                                CGPA Evidence
                            </div>
                            @if($existingDocs->has('cgpa'))
                                <span class="status-badge">
                                    <i class="fas fa-check-circle"></i> Uploaded
                                </span>
                            @endif
                        </div>
                        <p class="doc-description">
                            <i class="fas fa-circle-info"></i> Medical students: upload recent academic transcript
                        </p>
                        <div class="file-input-wrapper">
                            <input type="file" id="cgpa_file" name="cgpa_file" accept=".pdf,.jpg,.jpeg,.png" 
                                   class="file-input-custom" data-doc-type="cgpa">
                        </div>
                        <div class="file-specs">
                            <i class="fas fa-file"></i>
                            PDF, JPG, PNG (Max 5MB)
                        </div>
                        @if($existingDocs->has('cgpa'))
                            <div class="file-badge">
                                <i class="fas fa-archive"></i> File saved — upload new to replace
                            </div>
                        @endif
                        @error('cgpa_file')
                            <div class="error-badge">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Fee Receipt Card -->
                    <div class="doc-card {{ $existingDocs->has('fee_receipt') ? 'uploaded' : '' }}">
                        <div class="doc-card-header">
                            <div class="doc-title">
                                <i class="fas fa-receipt"></i>
                                Fee Receipt
                            </div>
                            @if($existingDocs->has('fee_receipt'))
                                <span class="status-badge">
                                    <i class="fas fa-check-circle"></i> Uploaded
                                </span>
                            @endif
                        </div>
                        <p class="doc-description">
                            <i class="fas fa-circle-info"></i> Current academic year payment receipt
                        </p>
                        <div class="file-input-wrapper">
                            <input type="file" id="fee_receipt" name="fee_receipt" accept=".pdf,.jpg,.jpeg,.png" 
                                   class="file-input-custom" data-doc-type="fee_receipt">
                        </div>
                        <div class="file-specs">
                            <i class="fas fa-file"></i>
                            PDF, JPG, PNG (Max 5MB)
                        </div>
                        @if($existingDocs->has('fee_receipt'))
                            <div class="file-badge">
                                <i class="fas fa-sync-alt"></i> Existing receipt — replace if needed
                            </div>
                        @endif
                        @error('fee_receipt')
                            <div class="error-badge">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Professional Documents -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-number">2</div>
                    <h3><i class="fas fa-briefcase"></i> Professional Documents</h3>
                </div>

                <div class="documents-grid">
                    <!-- CV Card -->
                    <div class="doc-card {{ $existingDocs->has('cv') ? 'uploaded' : '' }}">
                        <div class="doc-card-header">
                            <div class="doc-title">
                                <i class="fas fa-file-contract"></i>
                                Curriculum Vitae
                            </div>
                            @if($existingDocs->has('cv'))
                                <span class="status-badge">
                                    <i class="fas fa-check-circle"></i> Uploaded
                                </span>
                            @endif
                        </div>
                        <p class="doc-description">
                            <i class="fas fa-circle-info"></i> Include 2 referees (1 lecturer/HOD) with full contact details
                        </p>
                        <div class="file-input-wrapper">
                            <input type="file" id="cv_file" name="cv_file" accept=".pdf,.doc,.docx" 
                                   class="file-input-custom" data-doc-type="cv">
                        </div>
                        <div class="file-specs">
                            <i class="fas fa-file"></i>
                            PDF, DOC, DOCX (Max 5MB)
                        </div>
                        @if($existingDocs->has('cv'))
                            <div class="file-badge">
                                <i class="fas fa-file-pdf"></i> CV on file — re-upload to revise
                            </div>
                        @endif
                        @error('cv_file')
                            <div class="error-badge">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Medical Report Card -->
                    <div class="doc-card {{ $existingDocs->has('medical_report') ? 'uploaded' : '' }}">
                        <div class="doc-card-header">
                            <div class="doc-title">
                                <i class="fas fa-file-medical"></i>
                                Medical Report
                            </div>
                            @if($existingDocs->has('medical_report'))
                                <span class="status-badge">
                                    <i class="fas fa-check-circle"></i> Uploaded
                                </span>
                            @endif
                        </div>
                        <p class="doc-description">
                            <i class="fas fa-circle-info"></i> From University Hospital (within 3 months)
                        </p>
                        <div class="file-input-wrapper">
                            <input type="file" id="medical_report" name="medical_report" accept=".pdf,.jpg,.jpeg,.png" 
                                   class="file-input-custom" data-doc-type="medical_report">
                        </div>
                        <div class="file-specs">
                            <i class="fas fa-file"></i>
                            PDF, JPG, PNG (Max 5MB)
                        </div>
                        @if($existingDocs->has('medical_report'))
                            <div class="file-badge">
                                <i class="fas fa-hospital"></i> Medical report present — replace if newer
                            </div>
                        @endif
                        @error('medical_report')
                            <div class="error-badge">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Campaign Materials -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-number">3</div>
                    <h3><i class="fas fa-camera"></i> Campaign Materials</h3>
                </div>

                <div class="documents-grid">
                    <!-- Campaign Photo Card -->
                    <div class="doc-card {{ $existingDocs->has('passport_photo') ? 'uploaded' : '' }}">
                        <div class="doc-card-header">
                            <div class="doc-title">
                                <i class="fas fa-image"></i>
                                Campaign Portrait
                            </div>
                            @if($existingDocs->has('passport_photo'))
                                <span class="status-badge">
                                    <i class="fas fa-camera"></i> Uploaded
                                </span>
                            @endif
                        </div>
                        <p class="doc-description">
                            <i class="fas fa-circle-info"></i> Professional JPEG (plain background). Used for ballot & promotional materials.
                        </p>
                        <div class="file-input-wrapper">
                            <input type="file" id="passport_photo" name="passport_photo" accept=".jpg,.jpeg" 
                                   class="file-input-custom" data-doc-type="passport_photo">
                        </div>
                        <div class="file-specs">
                            <i class="fas fa-image"></i>
                            JPEG only (Max 2MB)
                        </div>
                        @if($existingDocs->has('passport_photo'))
                            <div class="file-badge">
                                <i class="fas fa-upload"></i> Replace existing photo to update
                            </div>
                        @endif
                        @error('passport_photo')
                            <div class="error-badge">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons - FIXED VERSION -->
            <div class="button-section">
                <input type="hidden" name="action" id="actionInput" value="">
                <button type="button" id="saveBtn" class="btn-action btn-save">
                    <i class="fas fa-save"></i> Save Draft & Continue
                </button>
                <button type="button" id="submitBtn" class="btn-action btn-submit">
                    <i class="fas fa-paper-plane"></i> Submit Final Nomination
                </button>
            </div>

            <div class="button-warning">
                <i class="fas fa-shield-alt"></i>
                <span><strong>Important:</strong> "Save" stores progress without finalizing. "Submit" locks your candidacy for review. Ensure all documents are correct before final submission.</span>
            </div>
        </form>

        <!-- Requirements Section -->
        <div class="requirements-section">
            <div class="requirement-card">
                <div class="requirement-header">
                    <i class="fas fa-clipboard-check"></i>
                    <h4>Document Quality</h4>
                </div>
                <ul class="requirement-list">
                    <li>All scans must be <strong>clear and legible</strong></li>
                    <li>No cropping or cutting off edges</li>
                    <li>Original documents only (no altered copies)</li>
                    <li>Ensure name visible on all documents</li>
                </ul>
            </div>

            <div class="requirement-card">
                <div class="requirement-header">
                    <i class="fas fa-user-tie"></i>
                    <h4>Referee Requirements</h4>
                </div>
                <ul class="requirement-list">
                    <li>Include 2 referees in your CV</li>
                    <li>At least 1 academic staff (Lecturer/HOD)</li>
                    <li>Include phone numbers and emails</li>
                    <li>Ensure references are current</li>
                </ul>
            </div>

            <div class="requirement-card">
                <div class="requirement-header">
                    <i class="fas fa-camera-retro"></i>
                    <h4>Photo Specifications</h4>
                </div>
                <ul class="requirement-list">
                    <li>Professional, recent photo required</li>
                    <li>Plain white/light background</li>
                    <li>Neutral facial expression</li>
                    <li>Good lighting and clear face</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
    (function() {
        const form = document.getElementById('nominationForm');
        const saveBtn = document.getElementById('saveBtn');
        const submitBtn = document.getElementById('submitBtn');
        const actionInput = document.getElementById('actionInput');
        const progressBar = document.getElementById('progress-bar');
        const percentSpan = document.getElementById('completion-percent');
        
        const docKeys = ['cgpa', 'fee_receipt', 'cv', 'medical_report', 'passport_photo'];
        
        const existingStatus = {
            cgpa: @json($existingDocs->has('cgpa')),
            fee_receipt: @json($existingDocs->has('fee_receipt')),
            cv: @json($existingDocs->has('cv')),
            medical_report: @json($existingDocs->has('medical_report')),
            passport_photo: @json($existingDocs->has('passport_photo'))
        };
        
        let selectedFiles = {
            cgpa: false,
            fee_receipt: false,
            cv: false,
            medical_report: false,
            passport_photo: false
        };
        
        function updateCompletion() {
            let completedCount = 0;
            for (let key of docKeys) {
                if (existingStatus[key] || selectedFiles[key]) completedCount++;
            }
            const percent = Math.round((completedCount / docKeys.length) * 100);
            if (progressBar) progressBar.style.width = percent + '%';
            if (percentSpan) percentSpan.innerText = percent + '%';
        }
        
        const fileInputs = document.querySelectorAll('.file-input-custom');
        
        fileInputs.forEach(input => {
            const docType = input.getAttribute('data-doc-type');
            const docCard = input.closest('.doc-card');
            
            input.addEventListener('change', (e) => {
                selectedFiles[docType] = (input.files && input.files.length > 0);
                if (selectedFiles[docType]) {
                    docCard.classList.add('uploaded');
                } else {
                    docCard.classList.remove('uploaded');
                }
                updateCompletion();
                
                const file = input.files[0];
                if (file) {
                    let maxSize = 5 * 1024 * 1024;
                    if (docType === 'passport_photo') maxSize = 2 * 1024 * 1024;
                    
                    if (file.size > maxSize) {
                        alert(`⚠️ File too large! Max size: ${maxSize / (1024*1024)}MB`);
                        input.value = '';
                        selectedFiles[docType] = false;
                        docCard.classList.remove('uploaded');
                        updateCompletion();
                    } else if (docType === 'passport_photo' && !file.type.match('image/jpeg')) {
                        alert('❌ Campaign photo must be JPEG format (.jpg or .jpeg)');
                        input.value = '';
                        selectedFiles[docType] = false;
                        docCard.classList.remove('uploaded');
                        updateCompletion();
                    }
                }
            });
        });
        
        updateCompletion();
        
        // ✅ FIX: Save button (type="button" so we control submission)
        saveBtn?.addEventListener('click', function() {
            // Set the action value
            actionInput.value = 'save';
            
            // Disable button and show loading
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            
            // Submit the form
            form.submit();
        });
        
        // ✅ FIX: Submit button with validation
        submitBtn?.addEventListener('click', function() {
            // Check for missing documents
            let missingDocs = [];
            for (let key of docKeys) {
                if (!existingStatus[key] && !selectedFiles[key]) {
                    missingDocs.push(key.replace(/_/g, ' ').toUpperCase());
                }
            }
            
            if (missingDocs.length > 0) {
                alert(`⚠️ INCOMPLETE! Missing:\n\n${missingDocs.join(', ')}\n\nPlease upload all documents.`);
                return false;
            }
            
            const confirmMsg = window.confirm("🔒 FINAL SUBMISSION:\n\nOnce submitted, you CANNOT edit or replace documents. Your nomination will be locked for review.\n\nAre you absolutely sure all files are CORRECT?");
            
            if (confirmMsg) {
                // Set the action value to 'submit'
                actionInput.value = 'submit';
                
                // Disable button and show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                
                // Submit the form
                form.submit();
            }
        });
    })();
</script>
</body>
</html>
@else
<script>
    window.location.href = "{{ route('/normination-landing-page') }}";
</script>
@endauth