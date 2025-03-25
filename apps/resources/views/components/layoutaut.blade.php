<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('storage/asset/ATS_light.png') }}" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="{{ asset('storage/asset/ATS_dark.png') }}" type="image/png" media="(prefers-color-scheme: dark)">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>{{ $title }}</title>
</head>
<body class="h-screen bg-white dark:bg-slate-900">
    <!-- Komponen Alert -->
    @if (session('alert'))
        <x-alert :type="session('alert.type')" :messages="session('alert.messages')" />
    @endif
    <!-- JavaScript -->
    <div id="js-alert-container" class="fixed flex flex-col top-4 right-4 sm:top-6 sm:right-6 z-[80] w-full max-w-xs sm:max-w-sm gap-4"></div>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        {{ $slot }}
    </div>
</body>
</html>

