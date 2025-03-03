<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />
    <div class="container mx-auto w-full mt-2">
        <div class="flex w-full justify-between dark:text-white ">
            <div class="">
                <h1 class="text-2xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Check OUT</h1>
                {{-- <p class="text-3xl font-semibold">Total : <span id="totalCheckIN"></span></p> --}}
            </div>
            
            <div class="inline-flex flex-col gap-2 text-black">
                <form id="submitCheckin" action="{{ route('checkout.save.action') }}" method="POST">
                    @csrf
                    <button type="submit" id="checkOUT" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Check OUT</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mx-auto w-full mt-2">
        <div id="content" class="grid gap-4 lg:grid-cols-2 grid-cols-1">
            <div id="tabelContent" class="order-2 lg:order-1">
                <div class="overflow-hidden">
                    <div class="overflow-x-auto overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                        <table id="tableList" class="table-auto w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 rounded-md text-gray-900 dark:text-gray-100">
                                    <th class="py-3 px-1 whitespace-nowrap">No</th>
                                    <th class="py-3 px-1 whitespace-nowrap">Code Asset</th>
                                    <th class="py-3 px-1 whitespace-nowrap">Nama Asset</th>
                                    <th class="py-3 px-1 whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="border-b border-gray-200 dark:border-gray-700 rounded-md text-gray-900 dark:text-gray-100">
                                @if (empty($itemCheckout))
                                    <tr>
                                        <td colspan="4" class="py-2 px-1 text-center">Empty Data .</td>
                                    </tr>
                                @else
                                    @foreach ($itemCheckout as $index => $item)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <td class="py-3 px-1 whitespace-nowrap">{{ $index + 1 }}</td>
                                            <td class="py-3 px-1 whitespace-nowrap">{{ $item['codeAsset'] }}</td>
                                            <td class="py-3 px-1 whitespace-nowrap">{{ $item['nameAsset'] }}</td>
                                            <td class="py-3 px-1 whitespace-nowrap">
                                                <form action="{{ route('checkout.remove.action', $item['id']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-4 sm:px-5 py-1 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="formContent" class="order-1 lg:order-2">
                <div class="w-full p-2 bg-slate-800 rounded-md space-y-2">
                    <form id="codeAsset" action="{{ route('checkout.add.action') }}" method="POST" class="flex items-center mx-auto">
                        @csrf
                        <label for="codeAsset" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <input type="text" id="codeAsset" name="codeAsset" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Input Code" />
                            <div id="autocompleteList" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-48 overflow-y-auto hidden shadow-lg dark:bg-gray-700 dark:border-gray-600  scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100  dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                            </div>
                        </div>
                        <input hidden type="text" name="nameAsset" id="nameAsset" value="">
                        <button type="submit" class="inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-gray-700 rounded-md border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            Add
                        </button>
                        {{-- <button type="button" class="inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-gray-700 rounded-md border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            Scan
                        </button> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const itemAsset = @json($assetItem); // Data dari controller

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
                        document.getElementById('nameAsset').value = item.asset_name; // Isi input nameAsset
                        autocompleteContainer.classList.add('hidden'); // Sembunyikan autocomplete
                    });
                    autocompleteContainer.appendChild(option);
                });

                // Tampilkan atau sembunyikan autocomplete container
                autocompleteContainer.classList.toggle('hidden', filteredAssets.length === 0);

                // Cek apakah input codeAsset sesuai dengan data yang ada di itemAsset
                const matchedItem = itemAsset.find(item => item.code_assets.toLowerCase() === inputValue);
                if (matchedItem) {
                    document.getElementById('nameAsset').value = matchedItem.asset_name; // Isi nameAsset jika input valid
                } else {
                    document.getElementById('nameAsset').value = ""; // Kosongkan nameAsset jika input tidak valid
                }
            }
        });


        function validateForm() {
            const nameAsset = document.getElementById('nameAsset').value.trim();
            const errors = [];

            if (nameAsset === '') {
                errors.push('Code Asset Tidak Valid');
            }
            return errors;
        }

        document.addEventListener('submit', function (e) {
            if (e.target && e.target.id === 'codeAsset') {
                e.preventDefault();
                const errors = validateForm();
                if (errors.length > 0) {
                    showAlert('danger', errors);
                } else {
                    e.target.submit();
                }
            }
        });
    </script>
</x-layoutdsbd>