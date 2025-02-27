<x-layoutaut title="{{ $title }}">
    <!-- Header -->
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="text-center text-5xl font-bold tracking-tight text-gray-900 dark:text-gray-100">ATC</h2>
        <h2 class="mt-8 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-gray-100">Enter OTP Code</h2>
        <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
            Enter the 6-digit code sent to your email.
        </p>
    </div>

    <div class="mb-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form id="otp-form" class="space-y-6" action="{{ route('otp') }}" method="POST">
            @csrf
            <!-- OTP Input Fields -->
            <div class="flex justify-center space-x-2">
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-next="code-2" id="code-1" class="otp-box w-12 h-12 text-center text-lg font-medium rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-indigo-400 dark:focus:ring-indigo-400 dark:text-white" required />
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-1" data-focus-input-next="code-3" id="code-2" class="otp-box w-12 h-12 text-center text-lg font-medium rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-indigo-400 dark:focus:ring-indigo-400 dark:text-white" required />
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-2" data-focus-input-next="code-4" id="code-3"  class="otp-box w-12 h-12 text-center text-lg font-medium rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-indigo-400 dark:focus:ring-indigo-400 dark:text-white" required />
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-3" data-focus-input-next="code-5" id="code-4" class="otp-box w-12 h-12 text-center text-lg font-medium rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-indigo-400 dark:focus:ring-indigo-400 dark:text-white" required />
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-4" data-focus-input-next="code-6" id="code-5" class="otp-box w-12 h-12 text-center text-lg font-medium rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-indigo-400 dark:focus:ring-indigo-400 dark:text-white" required />
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-5" id="code-6" class="otp-box w-12 h-12 text-center text-lg font-medium rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-indigo-400 dark:focus:ring-indigo-400 dark:text-white" required />
            </div>
            <!-- Hidden input untuk menyimpan OTP lengkap -->
            <input id="otpfull" type="text" name="otpfull" hidden class="otp-box h-12 text-center text-lg font-medium rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-indigo-400 dark:focus:ring-indigo-400 dark:text-white" required />
            <div>
                <button type="submit" class="flex w-[50%] mx-auto justify-center rounded-md bg-indigo-600 px-3 py-3 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">Verify OTP</button>
            </div>
        </form>
    </div>

    <script>
        // Fungsi untuk menggabungkan nilai dari 6 input OTP
        function combineOTP() {
            const otp1 = document.getElementById('code-1').value;
            const otp2 = document.getElementById('code-2').value;
            const otp3 = document.getElementById('code-3').value;
            const otp4 = document.getElementById('code-4').value;
            const otp5 = document.getElementById('code-5').value;
            const otp6 = document.getElementById('code-6').value;
    
            // Gabungkan nilai OTP
            const fullOTP = otp1 + otp2 + otp3 + otp4 + otp5 + otp6;
    
            // Set nilai OTP ke input tersembunyi
            document.getElementById('otpfull').value = fullOTP;
        }
    
        // Fungsi untuk fokus ke input berikutnya
        function focusNextInput(el, prevId, nextId) {
            if (el.value.length === 0) {
                if (prevId) {
                    document.getElementById(prevId).focus();
                }
            } else {
                if (nextId) {
                    document.getElementById(nextId).focus();
                }
            }
        }
    
        // Fungsi untuk validasi angka
        function validateNumberInput(event) {
            // Cegah input jika bukan angka
            if (!/^\d$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete" && event.key !== "Tab") {
                event.preventDefault();
            }
        }
    
        // Tambahkan event listener ke semua input OTP
        document.querySelectorAll('[data-focus-input-init]').forEach(function(element) {
            // Cegah input jika bukan angka
            element.addEventListener('keypress', validateNumberInput);
    
            // Cegah paste karakter non-angka
            element.addEventListener('paste', function(event) {
                event.preventDefault();
                const pasteData = (event.clipboardData || window.clipboardData).getData('text');
                const digits = pasteData.replace(/\D/g, ''); // Hanya ambil angka dari data yang di-paste
    
                // Ambil semua input OTP
                const inputs = document.querySelectorAll('[data-focus-input-init]');
    
                // Isi nilai ke masing-masing input
                inputs.forEach((input, index) => {
                    if (digits[index]) {
                        input.value = digits[index];
                        // Fokus ke input berikutnya setelah mengisi input saat ini
                        const nextId = input.getAttribute('data-focus-input-next');
                        if (nextId) {
                            document.getElementById(nextId).focus();
                        }
                    }
                });
    
                // Gabungkan nilai OTP setelah paste
                combineOTP();
            });
    
            // Event keyup untuk fokus otomatis ke input berikutnya & menggabungkan OTP
            element.addEventListener('keyup', function() {
                const prevId = this.getAttribute('data-focus-input-prev');
                const nextId = this.getAttribute('data-focus-input-next');
                focusNextInput(this, prevId, nextId);
    
                // Gabungkan nilai OTP setiap kali ada perubahan
                combineOTP();
            });
    
            // Validasi angka saat mengetik
            element.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, ''); // Hapus karakter non-angka jika ada
            });
        });
    
        // Pastikan nilai OTP digabungkan saat form di-submit
        document.getElementById('otp-form').addEventListener('submit', function() {
            combineOTP();
        });
    </script>
</x-layoutaut>