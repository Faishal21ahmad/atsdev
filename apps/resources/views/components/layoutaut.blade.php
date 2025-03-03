<!DOCTYPE html>
<html class="h-full bg-white dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>{{ $title }}</title>
</head>
<body class="h-full bg-white dark:bg-gray-900">
    <!-- Komponen Alert -->
    @if (session('alert'))
        <x-alert :type="session('alert.type')" :messages="session('alert.messages')" />
    @endif
    <!-- JavaScript -->
    <div id="js-alert-container" class="fixed flex flex-col top-4 right-4 sm:top-6 sm:right-6 z-[80] w-full max-w-xs sm:max-w-sm gap-4"></div>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        {{ $slot }}
    </div>

    <script>
        // Fungsi untuk validasi client-side
        function validateForm() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            const errors = [];

            if (email === '') {
                errors.push('Email tidak boleh kosong');
            }

            if (password === '') {
                errors.push('Password tidak boleh kosong');
            }

            return errors;
        }

     

        // Event listener untuk form submission
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Mencegah form di-submit secara default

            // Validasi client-side
            const errors = validateForm();

            if (errors.length > 0) {
                // showErrors(errors);
                showAlert('danger', errors);
            }  else {
                // Jika tidak ada error, submit form secara manual
                this.submit();
            }
        });

        // Fungsi untuk menampilkan alert
        function showAlert(type, messages) {
            const container = document.getElementById('js-alert-container');

            // Buat elemen alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert-message'; // Tambahkan class untuk styling
            alertDiv.innerHTML = `
                <div class="flex p-4 text-sm rounded-lg shadow-lg ${getAlertColor(type)}" role="alert">
                    <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">${type}</span>
                    <div>
                        <span class="font-medium">${getAlertTitle(type)}</span>
                        <ul class="mt-1.5 list-disc list-inside">
                            ${messages.map(msg => `<li>${msg}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            `;

            // Tambahkan ke container
            container.appendChild(alertDiv);

            // Tampilkan alert
            alertDiv.classList.remove('hidden');

            // Sembunyikan alert setelah 5 detik
            setTimeout(() => {
                alertDiv.classList.add('hidden');
                setTimeout(() => alertDiv.remove(), 300); // Hapus elemen setelah animasi selesai
            }, 5000);
        }

        // Fungsi untuk menentukan warna alert berdasarkan type
        function getAlertColor(type) {
            const colors = {
                danger: 'bg-red-50 text-red-800 dark:bg-gray-800 dark:text-red-400',
                alert: 'bg-yellow-50 text-yellow-800 dark:bg-gray-800 dark:text-yellow-400',
                success: 'bg-green-50 text-green-800 dark:bg-gray-800 dark:text-green-400',
                info: 'bg-blue-50 text-blue-800 dark:bg-gray-800 dark:text-blue-400',
            };
            return colors[type] || colors.info;
        }

        // Fungsi untuk menentukan judul alert berdasarkan type
        function getAlertTitle(type) {
            const titles = {
                danger: 'Please fix the following errors:',
                alert: 'Attention needed:',
                success: 'Success!',
                info: 'Info:',
            };
            return titles[type] || 'Info';
        }
    </script>  

</body>
</html>

