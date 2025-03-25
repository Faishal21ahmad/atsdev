<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('storage/asset/ATS_light.png') }}" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="{{ asset('storage/asset/ATS_dark.png') }}" type="image/png" media="(prefers-color-scheme: dark)">
    <title>Email Verification Code</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/css">
        @media (max-width: 600px) {
            .mobile-padding {
                padding-left: 24px !important;
                padding-right: 24px !important;
            }
        }
    </style>
</head>
<body class="bg-slate-50 font-sans">
    <!-- Email Container -->
    <div class="max-w-2xl mx-auto my-8 bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-slate-700 py-6 px-8 text-center">
            <img src="{{ asset('storage/asset/ATS_light.png') }}" alt="Company Logo" class="h-12 inline-block">
        </div>
        
        <!-- Content -->
        <div class="px-10 py-8 mobile-padding">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Your Verification Code</h1>
            <p class="text-slate-700 mb-4">Hello,</p>
            <p class="text-slate-700 mb-6">We received a request to verify your email address. Please use the following One-Time Password (OTP) to complete your verification:</p>

            <!-- OTP Box -->
            <div class="bg-slate-100 rounded-lg py-4 px-6 mb-6 text-center">
                <div class="text-3xl font-bold tracking-widest text-slate-900 my-2">{{ $otpCode }}</div>
            </div>
            
            <p class="text-sm text-slate-500 mb-6">This code will expire in <span class="font-semibold">10 minutes</span>. Please don't share this code with anyone.</p>
            <p class="text-slate-700 mb-6">If you didn't request this code, you can safely ignore this email.</p>
            <p class="text-slate-700">Best regards,<br><span class="font-semibold">The ATS Team</span></p>
        </div>
        
        <!-- Footer -->
        <div class="bg-slate-50 py-4 px-8 text-center text-xs text-slate-500">
            <p>© {{ date('Y') }} ATS System </p>
            <p class="mt-1">If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>
</html>