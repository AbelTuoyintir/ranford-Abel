<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Status</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class="rounded-full w-16 h-16">
</head>
<body style="background-color: #f7fafc; font-family: sans-serif;">
    <div style="max-width: 32rem; margin: 2.5rem auto; background-color: #fff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 0.5rem; overflow: hidden;">
        <div class="mb-5" style="background-color: #48bb78; color: white; text-align: center; padding: 1.5rem 1.25rem; position: relative; height: 14px;">
            <h1 style="font-size: 1.25rem; font-weight: bold; position: absolute; left: 50%; transform: translateX(-50%);">
                Verify Your Voter Status
            </h1>
        </div>

        <div style="padding: 1.5rem;">
            <h2 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Hello {{ $voter->firstName }} {{ $voter->lastName }},</h2>
            <p style="color: #4a5568; margin-bottom: 1rem;">
                We noticed you initiated the voter verification process. Please confirm your status by clicking the button below:
            </p>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin-top: 1.5rem;">

            <h3 style="font-size: 1rem; font-weight: 600; margin-top: 1.5rem;">Your Password:</h3>
            <p style="background-color: #edf2f7; padding: 0.75rem; border-radius: 0.25rem; font-size: 1rem; font-weight: bold; text-align: center;">
                {{ $randomPassword}}
            </p>
            <p style="color: #4a5568; margin-top: 1rem;">
                Please you can change your password after logging in.
            </p>
            

            
            
            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" style="display: inline-block; padding: 0.75rem 1.5rem; background-color: #48bb78; color: white; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); text-decoration: none; transition: background-color 0.3s;">
                    Verify Voter Status
                </a>
            </div>

            <p style="color: #4a5568; margin-top: 1.5rem;">
                If the button above doesn’t work, copy and paste this link into your web browser:
            </p>

            <p style="background-color: #edf2f7; padding: 0.75rem; border-radius: 0.25rem; margin-top: 0.5rem; font-size: 0.875rem; color: #4a5568; word-break: break-all;">
                <a href="{{ $verificationUrl }}" style="color: #48bb78; text-decoration: underline;">{{ $verificationUrl }}</a>
            </p>

            <p style="color: #4a5568; margin-top: 1.5rem;">
                This link will expire in 24 hours. If you didn’t request this action, you can ignore this email.
            </p>

            
        </div>

        <div style="background-color: #f7fafc; text-align: center; padding: 1rem;">
            <p style="font-size: 0.875rem; color: #718096;">Best regards,</p>
            <p style="font-size: 0.875rem; color: #718096; font-weight: 600;">UCC Election Team</p>
            <p style="font-size: 0.875rem; color: #718096;">
                <a href="https://vote.ucc.edu.gh/voter-login" style="color: #48bb78; text-decoration: underline;">Click Here To Vote</a>
            </p>
        </div>
    </div>
</body>
</html>
