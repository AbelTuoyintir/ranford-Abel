<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Voter Slip</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #EFF6FF, #F5F3FF);
            padding: 24px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(to right, #2563EB, #1E40AF);
            color: white;
            padding: 24px;
            position: relative;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .header p {
            color: #BFDBFE;
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .section {
            padding: 24px;
            border-bottom: 1px solid #f0f0f0;
        }

        .section-title {
            font-size: 18px;
            color: #1F2937;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .info-box {
            background: #F9FAFB;
            padding: 12px;
            border-radius: 8px;
        }

        .info-box label {
            display: block;
            color: #2563EB;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .info-box p {
            color: #1F2937;
            font-weight: 600;
        }

        .candidate-card {
            background: linear-gradient(to right, #EFF6FF, #F5F3FF);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .candidate-image {
            width: 96px;
            height: 96px;
            border-radius: 12px;
            margin-right: 16px;
        }

        .fingerprint-image {
            width: 80px;
            height: 80px;
            margin-left: auto;
        }

        .footer {
            background: linear-gradient(to right, #2563EB, #1E40AF);
            color: white;
            padding: 16px;
            text-align: center;
        }

        .footer p {
            font-size: 14px;
            margin-bottom: 4px;
        }

        .footer small {
            font-size: 12px;
            color: #BFDBFE;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Voter Slip</h1>
            <p>Election Commission of University Of Cape Coast</p>
        </div>

        <div class="section">
            <h2 class="section-title">Voter Information</h2>
            <div class="grid">
                <div class="info-box">
                    <label>Voter ID</label>
                    <p>{{ $voter->school_id }}</p>
                </div>
                <div class="info-box">
                    <label>Name</label>
                    <p>{{ $voter->firstName }} {{ $voter->middleName }} {{ $voter->lastName }}</p>
                </div>
                <div class="info-box">
                    <label>Poll Type</label>
                    <p>{{ $poll['title'] }}</p>
                </div>
                <div class="info-box">
                    <label>Gender</label>
                    <p>{{ $voter->gender }}</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Polling Station Details</h2>
            <div class="grid">
                <div class="info-box">
                    <label>Station</label>
                    <p>{{ $poll['poll_type'] }}</p>
                </div>
                <div class="info-box">
                    <label>Booth No.</label>
                    <p>{{ $ipAddress }}</p>
                </div>
            </div>
            <div class="info-box" style="margin-top: 16px;">
                <label>Location</label>
                <p>UCC CAMPUS</p>
            </div>
            <div class="grid" style="margin-top: 16px;">
                <div class="info-box">
                    <label>Date</label>
                    <p>{{ $poll['start_date'] }}</p>
                </div>
                <div class="info-box">
                    <label>Time</label>
                    <p>{{ now()->format('h:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Selected Candidates</h2>
            @foreach($candidates as $candidate)
            <div class="candidate-card">
                
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                  </svg>
                  
                <div>
                    <h3 style="font-size: 18px; margin-bottom: 4px;">{{ $candidate->team_name }}</h3>
                    <p style="color: #2563EB;">{{ $candidate->portfolio->name }}</p>
                    <div style="margin-top: 12px; background: white; padding: 8px 12px; border-radius: 8px; display: inline-block;">
                        <span style="color: #4B5563; font-size: 18px;">#: {{ $candidate->ballot_number }}</span>
                    </div>
                </div>
                <img src="" alt="">
                  
            </div>
            @endforeach
        </div>

        <div class="footer">
            <p>Thank you for voting</p>
            <small>Keep this slip for your records</small>
        </div>
    </div>
</body>
</html>