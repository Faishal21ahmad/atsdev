import { Html5Qrcode } from "html5-qrcode";
document.addEventListener("DOMContentLoaded", async function () {
    const qrReaderElement = document.getElementById("qr-reader");
    const toggleFlashButton = document.getElementById("toggle-flash");
    const toggleCameraOffButton = document.getElementById("toggle-camera-off");
    const cameraList = document.getElementById("camera-list");
    const startCameraButton = document.getElementById("start-camera");
    
    if (!qrReaderElement) return;

    let scanner = new Html5Qrcode("qr-reader");
    let isFlashOn = false;
    let isScanning = false;
    let selectedCameraId = localStorage.getItem("lastUsedCameraId") || "environment"; // Ambil ID kamera terakhir dari localStorage
    let availableCameras = []; // Simpan daftar kamera yang tersedia

    // Load beep sound
    let beep = new Audio("/storage/audio/beep1.wav");
    beep.load();

    // Mendapatkan daftar kamera yang tersedia
    async function getCameraList() {
        try {
            const cameras = await Html5Qrcode.getCameras();
            availableCameras = cameras; // Simpan daftar kamera ke variabel global
            // Tampilkan daftar kamera di dropdown
            cameraList.innerHTML = '<option value="" class="">pilih kamera</option>';
            cameras.forEach((camera) => {
                let option = document.createElement("option");
                option.value = camera.id;
                option.className = 'absolute inset-0 text-gray-500 rounded-lg overflow-ellipsis whitespace-nowrap';
                option.textContent = camera.label || `Kamera ${camera.id}`;
                cameraList.appendChild(option);

                // Set selected camera jika ID-nya sama dengan yang terakhir digunakan
                if (camera.id === selectedCameraId) {
                    option.selected = true;
                }
            });
        } catch (errors) {
            showAlert('danger', ["Tidak dapat mengakses kamera. Pastikan izin kamera diberikan."]);
            return false;
        }
    }

    // Memulai scan QR
    async function startScan(cameraId = selectedCameraId) {
        try {
            await scanner.start(
                { deviceId: cameraId },
                { fps: 10 },
                (decodedText) => {
                    scanner.stop();
                    isScanning = false;
                    // Memainkan suara beep
                    let beepSound = beep.cloneNode(); // Buat duplikat agar bisa dimainkan ulang
                    beepSound.play();

                    // Redirect ke halaman yang sesuai setelah 700ms
                    setTimeout(() => {
                        let toForm = document.getElementById("toForm").value;
                        let routeUrl = toForm === "asset" 
                            ? `/item/${encodeURIComponent(decodedText)}` 
                            : `/report/mainten/${encodeURIComponent(decodedText)}`;
                        window.location.href = routeUrl;
                    }, 700);
                },
                (error) => {
                    return false;
                }
            );
            isScanning = true;
            selectedCameraId = cameraId;

            // Simpan ID kamera yang terakhir digunakan ke localStorage
            localStorage.setItem("lastUsedCameraId", cameraId);

            // Tampilkan tombol yang sesuai
            toggleFlashButton.classList.remove("hidden");
            toggleCameraOffButton.classList.remove("hidden");
            startCameraButton.classList.add("hidden");
            cameraList.classList.add("hidden");
        } catch (errors) {
            showAlert('danger', ["Tidak dapat mengakses kamera. Pastikan izin kamera diberikan."]);
            return false;
        }
    }

    // Menghentikan scan QR
    function stopScan() {
        if (isScanning) {
            scanner.stop();
            isScanning = false;

            // Sembunyikan tombol kamera aktif, munculkan tombol kontrol lain
            toggleFlashButton.classList.add("hidden");
            toggleCameraOffButton.classList.add("hidden");
            startCameraButton.classList.remove("hidden");
            cameraList.classList.remove("hidden");
            getCameraList();
        }
    }

    // Mengaktifkan/menonaktifkan flash
    async function toggleFlash() {
        if (!isScanning) return;
        try {
            await scanner.applyVideoConstraints({ torch: !isFlashOn });
            isFlashOn = !isFlashOn;
            toggleFlashButton.textContent = isFlashOn ? "OFF Flash" : "ON Flash";
        } catch (errors) {
            showAlert('danger', ["Flash tidak didukung"]);
        }
    }

    // Event listener untuk tombol toggle flash
    toggleFlashButton.addEventListener("click", toggleFlash);

    // Event listener untuk tombol toggle camera off
    toggleCameraOffButton.addEventListener("click", stopScan);

    // Event listener untuk tombol start camera
    startCameraButton.addEventListener("click", () => startScan(selectedCameraId));

    // Event listener untuk memilih kamera dari daftar
    cameraList.addEventListener("change", (e) => {
        if (e.target.value) {
            selectedCameraId = e.target.value;
            startScan(selectedCameraId);
        }
    });

    // Mulai kamera secara default dengan kamera terakhir yang digunakan
    startScan();
});

// Fungsi untuk menampilkan pesan error
// function showAlert(type, messages) {
//     const alertContainer = document.createElement("div");
//     alertContainer.className = `alert alert-${type}`;
//     alertContainer.innerHTML = messages.join("<br>");
//     document.body.appendChild(alertContainer);

//     // Hapus pesan setelah 5 detik
//     setTimeout(() => {
//         alertContainer.remove();
//     }, 5000);
// }


// import { Html5QrcodeScanner } from "html5-qrcode";

// document.addEventListener("DOMContentLoaded", function () {
//     let qrReaderElement = document.getElementById("qr-reader");
//     // Cek apakah elemen "qr-reader" ada di halaman
//     if (!qrReaderElement) return;
//     let beep = new Audio("/storage/audio/beep1.wav");
//     beep.load(); 
//     const qrScanner = new Html5QrcodeScanner("qr-reader", {
//         fps: 30,
//         rememberLastUsedCamera: true,
//         showTorchButtonIfSupported: true
//     });
    
//     qrScanner.render((decodedText) => {
//         console.log(decodedText);
//         qrScanner.clear();
//         // Bunyi beep tanpa delay
//         let beepSound = beep.cloneNode(); // Buat duplikat agar bisa dimainkan ulang
//         beepSound.play();
//         // Redirect ke route sesuai $toForm setelah 500ms
//         setTimeout(() => {
//             let toForm = document.getElementById("toForm").value;
//             let routeUrl = toForm === "asset" 
//                 ? `/item/${encodeURIComponent(decodedText)}` 
//                 : `/report/mainten/${encodeURIComponent(decodedText)}`;
//             window.location.href = routeUrl;
//         }, 700);
//     });
// });
