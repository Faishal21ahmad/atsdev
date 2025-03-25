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
<body class="h-full bg-white dark:bg-slate-900 scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
    <!-- Komponen Alert -->
    @if (session('alert'))
        <x-alert :type="session('alert.type')" :messages="session('alert.messages')" />
    @endif
    <!-- JavaScript -->
    <div id="js-alert-container" class="fixed flex flex-col top-4 right-4 sm:top-6 sm:right-6 z-[80] w-full max-w-xs sm:max-w-sm gap-4"></div>
    <x-header :title="$title" :user="$user" :role="$role"/>
    <x-sidebar/>

    <div class="p-4 sm:ml-64 mt-[60px] lg:px-14">
    {{ $slot }}
    </div>
</body>
</html>
