import { Html5QrcodeScanner } from "html5-qrcode";
document.addEventListener("DOMContentLoaded", function () {
    const qrScanner = new Html5QrcodeScanner("qr-reader", { fps: 20, qrbox: 240 });
    qrScanner.render((decodedText) => {
        console.log(decodedText);
        

        // document.getElementById("codeAsset").value = decodedText;
       
    });
        
});





// document.addEventListener("DOMContentLoaded", function () {
//     const searchButton = document.getElementById("searchItemAsset");
//     const codeAssetInput = document.getElementById("codeAsset");

//     if (searchButton && codeAssetInput) {
//         searchButton.addEventListener("click", function (event) {
//             event.preventDefault();
//             validateAndRedirect(codeAssetInput.value.trim());
//         });
//     }

//     // Inisialisasi QR Scanner
//     const qrScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });

//     qrScanner.render((decodedText) => {
//         document.getElementById("codeAsset").value = decodedText;
//         validateAndRedirect(decodedText);
//     });

//     // Fungsi validasi dan redirect
//     function validateAndRedirect(codeAsset) {
//         let errors = [];

//         if (codeAsset === "") {
//             errors.push("Masukkan Code Asset terlebih dahulu!");
//         }

//         if (codeAsset.length !== 8) {
//             errors.push("Code Asset tidak valid! Harus 8 karakter!");
//         }

//         if (errors.length > 0) {
//             showAlert("danger", errors.join("<br>"));
//             return;
//         }

//         let routeUrl = "{{ $toForm == 'asset' ? route('itemAsset', ['codeAsset' => '__CODE__']) : route('mainten.report', ['codeAsset' => '__CODE__']) }}";
//         window.location.href = routeUrl.replace("__CODE__", encodeURIComponent(codeAsset));
//     }
// });
