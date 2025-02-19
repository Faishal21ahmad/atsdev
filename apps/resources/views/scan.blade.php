<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <div class="container w-full mt-5 grid grid-cols-1 lg:grid-cols-2 gap-3">
        <!-- Kamera SCAN Section -->
        <div id="kameraSCAN" class="border-2 h-96 flex rounded-md border-slate-200 bg-slate-50 dark:border-slate-600 dark:bg-slate-800">
            <div id="qr-reader" class="w-full"></div> 
        </div>
        <!-- Search Group Section -->
        <div id="searchGrub" class="order-1 md:order-none">
          <div class="flex items-center mx-auto">
            <div class="relative w-full">
              <!-- Input untuk Code Asset -->
              <input type="text" id="codeAsset" name="codeAsset" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Input Code" />
              <!-- Container untuk Autocomplete List -->
              <div id="autocompleteList" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-48 overflow-y-auto hidden shadow-lg dark:bg-gray-700 dark:border-gray-600 scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
              </div>
            </div>
            <!-- Tombol Search -->
            <a id="searchItemAsset" href="#" class="inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-gray-700 rounded-md border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
              <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
              </svg>Search
            </a>
          </div>
        </div>
      </div>
   
  <script>

   


    // Data dari controller
    const itemAsset = @json($assetItem);

    // Event listener untuk input pada codeAsset
    document.addEventListener('input', (e) => {
        if (e.target.id === 'codeAsset') {
            const inputValue = e.target.value.toLowerCase();
            const autocompleteContainer = document.getElementById('autocompleteList');
            autocompleteContainer.innerHTML = '';

            // Filter data berdasarkan input
            const filteredAssets = itemAsset.filter(item =>
                item.code_assets.toLowerCase().includes(inputValue)
            );

            // Tampilkan hasil autocomplete
            filteredAssets.forEach(item => {
                const option = document.createElement('div');
                option.textContent = item.code_assets;
                option.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-100', 'dark:hover:bg-gray-600', 'text-gray-900', 'dark:text-white');
                option.addEventListener('click', () => {
                    e.target.value = item.code_assets; // Isi input codeAsset
                    autocompleteContainer.classList.add('hidden'); // Sembunyikan autocomplete
                });
                autocompleteContainer.appendChild(option);
            });

            // Tampilkan atau sembunyikan autocomplete container
            autocompleteContainer.classList.toggle('hidden', filteredAssets.length === 0);
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        const searchButton = document.getElementById('searchItemAsset');
        const codeAssetInput = document.getElementById('codeAsset');

        if (searchButton && codeAssetInput) {
            searchButton.addEventListener('click', function (event) {
                event.preventDefault(); // Mencegah default action tombol

                let codeAsset = codeAssetInput.value.trim();
                let errors = [];

                if (codeAsset === '') {
                    errors.push('Masukkan Code Asset terlebih dahulu!');
                }

                if (codeAsset.length !== 8) {
                    errors.push('Code Asset tidak valid! Harus 8 karakter!');
                }

                if (errors.length > 0) {
                    showAlert('danger', errors); // Menampilkan semua error sekaligus
                    return;
                }

                // Pastikan variabel `$toForm` telah didefinisikan sebelumnya dalam Blade
                let routeUrl = "{{ $toForm == 'asset' ? route('itemAsset', ['codeAsset' => '__CODE__']) : route('mainten.report', ['codeAsset' => '__CODE__']) }}";

                window.location.href = routeUrl.replace('__CODE__', encodeURIComponent(codeAsset));
            });
        }
    });


  </script>
</x-layoutdsbd>

