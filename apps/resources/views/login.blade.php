<x-layoutaut title="{{ $title }}">


        <!-- Header -->
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="text-center text-5xl font-bold tracking-tight text-gray-900 dark:text-white">ATC</h2>
            <h2 class="mt-8 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-gray-200">Sign in to your account</h2>
        </div>
        <!-- Login Form -->
        <div class="mb-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form id="loginForm" action="{{ route('login.action') }}" method="POST" class="space-y-6 mb-16" >
                @csrf
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-200">Email</label>
                    <div class="mt-2">
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}"
                            autocomplete="email" 
                            class="block w-full rounded-md bg-white dark:bg-gray-800 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200 outline-1 -outline-offset-1 outline-gray-300 dark:outline-gray-700 placeholder:text-gray-400 dark:placeholder-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6"
                            >
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-200">Password</label>
                    </div>
                    <div class="mt-2">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            autocomplete="current-password" 
                            class="block w-full rounded-md bg-white dark:bg-gray-800 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200 outline-1 -outline-offset-1 outline-gray-300 dark:outline-gray-700 placeholder:text-gray-400 dark:placeholder-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6"
                            >
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="flex w-[50%] mx-auto justify-center rounded-md bg-gray-600 px-3 py-3 text-sm font-semibold text-white shadow-xs hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-600">
                        Log in
                    </button>
                </div>
            </form>
        </div>
<br><br>

</x-layoutaut>