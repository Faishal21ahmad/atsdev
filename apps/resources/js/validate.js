// Fungsi validasi file
function validateFileInput(event) {
    // Cegah form dari pengiriman default
    event.preventDefault();
    // Ambil input file dari form yang sedang di-submit
    const fileInput = event.target.querySelector('input[type="file"]');
    // Daftar format file yang diizinkan
    const allowedFormats = ['xls', 'xlsx', 'csv'];
    // Ukuran maksimal file (500KB)
    const maxSize = 500 * 1024; // 500KB dalam bytes
    // Ambil file yang diunggah
    const file = fileInput.files[0];
    // Array untuk menyimpan pesan error
    const errors = [];

    if (!file) {
        errors.push('Silakan pilih file yang akan diunggah.');
    } else {
        // Validasi format file
        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedFormats.includes(fileExtension)) errors.push(`Format file tidak diizinkan.`,` Hanya format ${allowedFormats.join(', ')} yang diizinkan.`);
        // Validasi ukuran file
        if (file.size > maxSize) errors.push(`Ukuran file melebihi batas maksimal 500KB.`);
    }

    // Jika ada error, tampilkan menggunakan showAlert
    if (errors.length > 0) {
        showAlert('danger', errors);
        return false; // Hentikan proses submit
    }

    // Jika semua validasi berhasil, submit form secara manual
    event.target.submit();
}

// Tambahkan event listener ke semua form dengan ID "importForms"
document.addEventListener('DOMContentLoaded', function () {
    // Ambil semua form dengan ID "importForms"
    const forms = document.querySelectorAll('#importForm');

    // Loop melalui setiap form dan tambahkan event listener
    forms.forEach(form => {
        form.addEventListener('submit', validateFileInput);
    });
});
