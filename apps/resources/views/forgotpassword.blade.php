<x-layoutaut title="{{ $title }}">
    <!-- Header -->
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="text-center text-5xl font-bold tracking-tight text-gray-900 dark:text-white">ATC</h2>
        <h2 class="mt-8 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-gray-200">Create New Password</h2>
    </div>
    <!-- Login Form -->
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <form id="Form" action="{{ route('forgot.password.action') }}" method="POST" class="space-y-6 mb-16" >
            @csrf
            <div>
                <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-200">New Password</label>
                <div class="mt-2 relative">
                    <input 
                        type="password" 
                        name="newPassword" 
                        id="password"
                        class="block w-full rounded-md px-3 py-1.5 text-base outline-1 sm:text-sm border-gray-300 text-gray-900 bg-gray-50 focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                        placeholder="Masukkan password baru">
                    <button type="button" onclick="togglePassword('password', 'togglePasswordIcon1')" class="absolute inset-y-0 right-3 flex items-center">
                        <svg id="togglePasswordIcon1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 3C5.455 3 1.733 6.118.456 10c1.277 3.882 5 7 9.544 7s8.267-3.118 9.544-7c-1.277-3.882-5-7-9.544-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>
                            <path d="M10 7a3 3 0 100 6 3 3 0 000-6z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div>
                <label for="passwordconfirm" class="block text-sm font-medium text-gray-900 dark:text-gray-200">Password Confirm</label>
                <div class="mt-2 relative">
                    <input 
                        type="password" 
                        name="passwordConfirm" 
                        id="passwordconfirm"
                        class="block w-full rounded-md px-3 py-1.5 text-base outline-1 sm:text-sm border-gray-300 text-gray-900 bg-gray-50 focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                        placeholder="Konfirmasi password">
                    <button type="button" onclick="togglePassword('passwordconfirm', 'togglePasswordIcon2')" class="absolute inset-y-0 right-3 flex items-center">
                        <svg id="togglePasswordIcon2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 3C5.455 3 1.733 6.118.456 10c1.277 3.882 5 7 9.544 7s8.267-3.118 9.544-7c-1.277-3.882-5-7-9.544-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>
                            <path d="M10 7a3 3 0 100 6 3 3 0 000-6z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="">
                <button type="submit" class="flex w-[50%] px-3 py-3 text-sm mx-auto justify-center bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">
                    Create
                </button>
            </div>
        </form>
    </div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }

</script>
</x-layoutaut>