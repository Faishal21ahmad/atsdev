<header  id="header" class="p-4 pb-0 sm:pb-4 sm:ml-64 absolute top-0 z-40">
    <div class="px-4 fixed top-0 left-0 right-0 h-16 bg-white dark:bg-gray-800 flex items-center justify-between sm:ml-64 lg:px-14 border-b-2 dark:border-gray-800">
        
        
        <div class="items-center flex">
            <!-- Divider -->
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                </svg>
            </button>
            <!-- Title Page -->
            <span class="text-xl font-semibold  sm:text-2xl whitespace-nowrap dark:text-white">
                {{ $title }}
            </span>
        </div>
        

        {{-- <!-- Divider -->
        <button 
            data-drawer-target="logo-sidebar" 
            data-drawer-toggle="logo-sidebar" 
            aria-controls="logo-sidebar"
            type="button" 
            class="absolute top-3/4 left-1/2 -translate-x-1/2 -translate-y-1/2 sm:hidden">
            <div class="h-1.5 w-20 bg-black mx-auto rounded-lg m-3"></div>
        </button> --}}

        <!-- User Role -->
        <span class="text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
            {{ $user }} {{ $role }}
        </span>
    </div>
</header> 