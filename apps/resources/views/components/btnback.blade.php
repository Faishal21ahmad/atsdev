@props([
    'href' => '#', // Default ke '#' jika tidak diberikan
    'icon' => null, // Ikon opsional (SVG bisa dimasukkan langsung)
])

<a href="{{ $href }}" 
    class="flex items-center justify-stretch gap-1 px-3 py-2 w-32 rounded-lg  text-slate-700 hover:bg-slate-200 transition duration-200 ease-in-out
             dark:hover:bg-slate-700 dark:text-white ">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
        <path d="M4.943,5.606,1.024,9.525a3.585,3.585,0,0,0,0,4.95l3.919,3.919a1.5,1.5,0,1,0,2.121-2.121L4.285,13.492l18.25-.023a1.5,1.5,0,0,0,1.5-1.5v0a1.5,1.5,0,0,0-1.5-1.5L4.3,10.492,7.064,7.727A1.5,1.5,0,0,0,4.943,5.606Z"/>
    </svg>
    <span>BACK</span>
</a>
