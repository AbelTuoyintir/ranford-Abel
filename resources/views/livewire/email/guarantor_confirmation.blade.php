<!DOCTYPE html>
<html>
<head>
    <title>Guarantor Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 40px 20px;
            color: #333;
        }

        .email-wrapper {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        a {
            color: #fff;
            background-color: #007BFF;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
        }

        a:hover {
            background-color: #0056b3;
        }

        b {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <p>Dear {{ $supporter->name }},</p>
        
        <p>
            You have been listed as a guarantor for nominee <b>{{ $nominee->full_name }}</b> 
            (Reg No: {{ $nominee->reg_number }}) for the position of <b>{{ $nominee->position }}</b>.
        </p>
        
        <p>Please click the link below to confirm you are aware and approve:</p>
        
        <p>
            <a href="{{ $confirmationUrl }}">Confirm Guarantor Approval</a>
        </p>
        
        <p>If you did not expect this email, please ignore it.</p>
    </div>
</body>
</html>


