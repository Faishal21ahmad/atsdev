
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
        danger: 'Danger Alert:',
        alert: 'Attention needed:',
        success: 'Success:',
        info: 'Info:',
    };
    return titles[type] || 'Info';
}

window.showAlert = showAlert;