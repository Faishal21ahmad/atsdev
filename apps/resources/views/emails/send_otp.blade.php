<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Code</title>
    <style type="text/css">
        @media (max-width: 600px) {
            .mobile-padding {
                padding-left: 24px !important;
                padding-right: 24px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: sans-serif;">
    <!-- Email Container -->
    <div style="max-width: 640px; margin: 32px auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <!-- Header -->
        <div style="background-color: #334155; padding: 24px 32px; text-align: center;">
            <img src="{{ asset('storage/asset/ATS_light.png') }}" alt="Company Logo" style="height: 48px; display: inline-block;">
        </div>
        
        <!-- Content -->
        <div style="padding: 32px 40px;" class="mobile-padding">
            <h1 style="font-size: 24px; font-weight: bold; color: #0f172a; margin-bottom: 24px;">Your Verification Code</h1>
            <p style="color: #475569; margin-bottom: 16px;">Hello,</p>
            <p style="color: #475569; margin-bottom: 24px;">We received a request to verify your email address. Please use the following One-Time Password (OTP) to complete your verification:</p>

            <!-- OTP Box -->
            <div style="background-color: #f1f5f9; border-radius: 8px; padding: 16px 24px; margin-bottom: 24px; text-align: center;">
                <div style="font-size: 24px; font-weight: bold; letter-spacing: 4px; color: #0f172a; margin: 8px 0;">{{ $otpCode }}</div>
            </div>
            
            <p style="font-size: 14px; color: #64748b; margin-bottom: 24px;">This code will expire in <span style="font-weight: 600;">10 minutes</span>. Please don't share this code with anyone.</p>
            <p style="color: #475569; margin-bottom: 24px;">If you didn't request this code, you can safely ignore this email.</p>
            <p style="color: #475569;">Best regards,<br><span style="font-weight: 600;">The ATS Team</span></p>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #f8fafc; padding: 16px 32px; text-align: center; font-size: 12px; color: #64748b;">
            <p>© {{ date('Y') }} ATS System</p>
            <p style="margin-top: 4px;">If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>
</html>
