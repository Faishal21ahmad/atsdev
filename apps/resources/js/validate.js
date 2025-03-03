function disableSubmitIfNoChanges(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    // Temukan semua input, textarea, dan select dalam form
    const inputs = form.querySelectorAll('input, textarea, select');
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Simpan nilai awal
    const initialValues = {};
    
    inputs.forEach(input => {
        // Handle checkbox dan radio button
        if (input.type === 'checkbox' || input.type === 'radio') {
            initialValues[input.name] = input.checked;
        } 
        // Handle select dropdown
        else if (input.tagName === 'SELECT') {
            initialValues[input.name] = input.value;
        }
        // Handle input biasa
        else {
            initialValues[input.name] = input.value;
        }
    });

    // Fungsi untuk memeriksa perubahan
    function checkChanges() {
        let hasChanges = false;

        inputs.forEach(input => {
            // Bandingkan nilai saat ini dengan nilai awal
            if (input.type === 'checkbox' || input.type === 'radio') {
                if (input.checked !== initialValues[input.name]) {
                    hasChanges = true;
                }
            } else if (input.value !== initialValues[input.name]) {
                hasChanges = true;
            }
        });

        // Update status tombol submit
        submitButton.disabled = !hasChanges;
    }

    // Tambahkan event listener untuk semua input
    inputs.forEach(input => {
        input.addEventListener('input', checkChanges);
        input.addEventListener('change', checkChanges);
    });

    // Panggil sekali saat inisialisasi
    checkChanges();
}