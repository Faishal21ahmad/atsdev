<!DOCTYPE html>
<html class="h-full bg-white dark:bg-gray-900 
scrollbar-thin
scrollbar-thumb-rounded-full 
scrollbar-thumb-slate-300 
scrollbar-track-slate-100 
dark:scrollbar-thumb-slate-300 
dark:scrollbar-track-slate-500
scrollbar-thumb-rounded-full 
scrollbar-track-rounded-full
">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>{{ $title }}</title>
</head>
<body class="h-full">
    <!-- Komponen Alert -->
    @if (session('alert'))
        <x-alert :type="session('alert.type')" :messages="session('alert.messages')" />
    @endif
    <!-- JavaScript -->
    <div id="js-alert-container" class="fixed flex flex-col top-4 right-4 sm:top-6 sm:right-6 z-50 w-full max-w-xs sm:max-w-sm gap-4"></div>

    <x-header :title="$title" :user="$user" :role="$role"/>

    <x-sidebar/>

    <div class="p-4 sm:ml-64 mt-16 lg:px-14">
    {{ $slot }}
    </div>

    <script>
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

        // setTimeout(function () {
        //     let alert = document.getElementById('alert');
        //     alert.classList.add('opacity-0'); // Menghilangkan opacity (fade out)
            
        //     setTimeout(() => {
        //         alert.classList.add('hidden'); // Sembunyikan setelah animasi selesai
        //     }, 500);
        // }, 5000);
    </script>


</body>
</html>



{{-- 
    <div class="flex flex-col gap-4 fixed z-50">
        <button class="p-4 bg-slate-200" onclick="showAlert('danger', ['Your account has been delete successfully.','wkwkwkwkw testing'])">
            Show danger Alert
        </button>
        <button class="p-4 bg-slate-200" onclick="showAlert('alert', ['Your account has been problem successfully.'])">
            Show alert Alert
        </button>
        <button class="p-4 bg-slate-200" onclick="showAlert('success', ['Your account has been created successfully.'])">
            Show success Alert
        </button>
        <button class="p-4 bg-slate-200" onclick="showAlert('info', ['Your account has been created successfully.'])">
            Show success Alert
        </button>
    </div> --}}

