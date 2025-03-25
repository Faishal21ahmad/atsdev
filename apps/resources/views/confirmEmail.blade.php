<x-layoutaut title="{{ $title }}">
    <!-- Header -->
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="text-center text-5xl font-bold tracking-tight text-slate-900 dark:text-white">ATC</h2>
        <h2 class="mt-8 text-center text-2xl/9 font-bold tracking-tight text-slate-900 dark:text-slate-200">Konfirmasi Email forgot password</h2>
    </div>
    <!-- Login Form -->
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <form id="formConfrimEmail" action="{{ route('confirm.email.action') }}" method="POST" class="space-y-6 mb-16" >
            @csrf
            <div>
                <label for="email" class="block text-sm/6 font-medium text-slate-900 dark:text-slate-200">Email</label>
                <div class="mt-2">
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        class="block w-full rounded-md px-3 py-1.5 text-base outline-1 sm:text-sm border-slate-300 text-slate-900 bg-slate-50 focus:ring-slate-300 focus:border-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500"
                        placeholder="xxxxxx@gmail.com">
                </div>
            </div>

            <div class="">
                <button type="submit" class="flex w-[50%] px-3 py-3 shadow-md text-sm mx-auto justify-center bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">
                    Confirm 
                </button>
            </div>
        </form>
    </div>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm dark:text-white text-center">
        <p>Login ? <a href="{{ route('login') }}" class="text-blue-500">klik here</a></p>
    </div>

    <script>
        // Fungsi untuk validasi client-side
        function validateForm() {
            const email = document.getElementById('email').value.trim();
            const errors = [];

            if (!email) errors.push('Email tidak boleh kosong');

            return errors;
        }

        // Event listener untuk form submission
        document.getElementById('formConfrimEmail').addEventListener('submit', function (e) {
            e.preventDefault(); // Mencegah form di-submit secara default
            // Validasi client-side
            const errors = validateForm();
            if (errors.length > 0) showAlert('danger', errors);
            else this.submit();
        });
    </script>
</x-layoutaut>