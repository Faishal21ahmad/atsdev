export async function disableSubmitIfNoChanges(formId) {
    await new Promise(resolve => setTimeout(resolve, 0)); // Tunggu DOM siap

    const form = document.getElementById(formId);
    if (!form) return;

    const inputs = form.querySelectorAll('input, textarea, select');
    const submitButton = form.querySelector('button[type="submit"]');

    if (!submitButton) return;

    // Simpan nilai awal dalam Map
    const initialValues = new Map();
    inputs.forEach(input => {
        if (input.type === 'checkbox' || input.type === 'radio') {
            initialValues.set(input, input.checked);
        } else {
            initialValues.set(input, input.value.trim());
        }
    });

    function checkChanges() {
        let hasChanges = false;

        for (const input of inputs) {
            if (input.type === 'checkbox' || input.type === 'radio') {
                if (input.checked !== initialValues.get(input)) {
                    hasChanges = true;
                }
            } else if (input.value.trim() !== initialValues.get(input)) {
                hasChanges = true;
            }
        }

        submitButton.disabled = !hasChanges;
    }

    // Tambahkan event listener untuk input
    inputs.forEach(input => {
        input.addEventListener('input', checkChanges);
        input.addEventListener('change', checkChanges);
    });

    // Cegah submit jika tidak ada perubahan dan tampilkan showAlert
    form.addEventListener('submit', function (e) {
        if (submitButton.disabled) {
            e.preventDefault();
            showAlert('danger', ['Tidak ada perubahan yang dibuat pada form.']);
        }
    });

    // Panggil sekali untuk inisialisasi
    checkChanges();
}
