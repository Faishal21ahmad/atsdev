@props(['type' => 'info', 'messages' => []])

@php
    // Tentukan warna dan ikon berdasarkan tipe pesan
    $colors = [
        'danger' => ['bg' => 'bg-red-50', 'text' => 'text-red-800', 'icon' => 'text-red-800', 'dark' => 'dark:bg-gray-800 dark:text-red-400'],
        'alert' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-800', 'icon' => 'text-yellow-800', 'dark' => 'dark:bg-gray-800 dark:text-yellow-400'],
        'success' => ['bg' => 'bg-green-50', 'text' => 'text-green-800', 'icon' => 'text-green-800', 'dark' => 'dark:bg-gray-800 dark:text-green-400'],
        'info' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-800', 'icon' => 'text-blue-800', 'dark' => 'dark:bg-gray-800 dark:text-blue-400'],
    ];
    $color = $colors[$type] ?? $colors['info'];
@endphp

<div id="alert" class="fixed top-4 right-4 sm:top-6 sm:right-6 z-50 w-full max-w-xs sm:max-w-sm">
    <div class="flex p-4 text-sm rounded-lg shadow-lg {{ $color['bg'] }} {{ $color['text'] }} {{ $color['dark'] }}" role="alert">
        <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">{{ ucfirst($type) }}</span>
        <div>
            <span class="font-medium">
                @if ($type === 'danger')
                    Please fix the following errors:
                @elseif ($type === 'alert')
                    Attention needed:
                @elseif ($type === 'success')
                    Success!
                @endif
            </span>
            <ul class="mt-1.5 list-disc list-inside">
                @foreach ($messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


<script>  
    setTimeout(function () {
        let alert = document.getElementById('alert');
        alert.classList.add('opacity-0'); // Menghilangkan opacity (fade out)
        
        setTimeout(() => {
            alert.classList.add('hidden'); // Sembunyikan setelah animasi selesai
        }, 500);
    }, 5000);
</script>