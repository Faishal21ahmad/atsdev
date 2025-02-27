<x-layoutaut title="{{ $title }}">
    <!-- Header -->
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="text-center text-5xl font-bold tracking-tight text-gray-900 dark:text-white">ATC</h2>
        <h2 class="mt-8 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-gray-200">Konfirmasi Email forgot password</h2>
    </div>
    <!-- Login Form -->
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <form id="Form" action="{{ route('confirm.email.action') }}" method="POST" class="space-y-6 mb-16" >
            @csrf
            <div>
                <label for="email" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-200">Email</label>
                <div class="mt-2">
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        class="block w-full rounded-md px-3 py-1.5 text-base outline-1 sm:text-sm border-gray-300 text-gray-900 bg-gray-50 focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                        placeholder="xxxxxx@gmail.com">
                </div>
            </div>

            <div class="">
                <button type="submit" class="flex w-[50%] px-3 py-3 text-sm mx-auto justify-center bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">
                    Confirm 
                </button>
            </div>
        </form>
    </div>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm text-white text-center">
        <p>Login ? <a href="{{ route('login') }}" class="text-blue-500">klik here</a></p>
    </div>
</x-layoutaut>