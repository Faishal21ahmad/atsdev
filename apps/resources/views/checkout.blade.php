<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />
    <div class="container mx-auto w-full mt-2">
        <div class="flex w-full justify-between dark:text-white ">
            <div class="">
                <h1 class="text-2xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap overflow-hidden">{{ $user['name'] }}</h1>
                <p class="text-3xl font-semibold">Total : <span id="totalCheckIN">Rp. {{ number_format($total, 0, ',', '.') ?? '' }}</span></p>
            </div>
            
            <div class="inline-flex flex-col gap-2 text-black ">
                <form id="submitCheckin" action="{{ route('checkout.save.action') }}" method="POST">
                    @csrf
                    <input hidden id="totalprice" type="text" name="pricetotal" value="{{ $total }}">
                    <input hidden id="inputreason" type="text" name="reason">
                    <input hidden id="inputvendor" type="text" name="vendor">
                    <input hidden id="inputdescription" type="text" name="description">
                    <button type="submit" id="checkOUT" class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Check OUT</button>
                    
                </form>
                <button type="button" id="addButton" data-modal-target="ModalAdd" data-modal-toggle="ModalAdd" class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md lg:hidden">Add Asset</button>
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
                                <tr class="border-b border-slate-200 dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100">
                                    <th class="py-3 px-1 whitespace-nowrap">No</th>
                                    <th class="py-3 px-1 whitespace-nowrap">Code Asset</th>
                                    <th class="py-3 px-1 whitespace-nowrap">Nama Asset</th>
                                    <th class="py-3 px-1 whitespace-nowrap">Price</th>
                                    <th class="py-3 px-1 whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="border-b border-slate-200 dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100">
                                @if (empty($itemCheckout))
                                    <tr>
                                        <td colspan="5" class="py-2 px-1 text-center">Empty Data .</td>
                                    </tr>
                                @else
                                    @foreach ($itemCheckout as $item)
                                        <tr class="border-b border-slate-200 dark:border-slate-700">
                                            <td class="py-3 px-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                                            <td class="py-3 px-1 whitespace-nowrap">{{ $item['codeAsset'] ?? '' }}</td>
                                            <td class="py-3 px-1 whitespace-nowrap">{{ $item['nameAsset'] ?? '' }}</td>
                                            <td class="py-3 px-1 whitespace-nowrap">Rp. {{ number_format($item['price'], 0, ',', '.') ?? '' }}</td>
                                            <td class="py-3 px-1 whitespace-nowrap">
                                                <form action="{{ route('checkout.remove.action', $item['id']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-4 sm:px-5 py-1 shadow-md bg-red-100 hover:bg-red-200 dark:bg-red-800 dark:hover:bg-red-700 dark:text-white rounded-md">Delete</button>
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
            <div id="formContent" class="order-1 lg:order-2 space-y-2">
                <div class="w-full p-4 rounded-md space-y-2 shadow-md bg-slate-100 dark:bg-slate-800">
                    <div class="col-span-2">
                        <label for="reason" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Reason</label>
                        <input type="text" id="reason" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Ex: grant, disposed, sold " />
                    </div> 
                    <div id="colVen" class="col-span-1">
                        <label for="vendor" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Vendor</label>
                        <select id="vendor" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500
                        overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full" placeholder="Name Account Items">
                            <option selected value="" class="text-slate-400">select vendor</option>
                            @foreach ($vendors as $item)
                                <option value="{{ $item->id }}">{{ $item->vendor_name }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-span-2">
                        <label for="Description" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Description</label>
                        <textarea id="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Write your thoughts here..."></textarea>
                    </div>
                </div>
                <div class="hidden lg:block w-full p-4 space-y-3 rounded-md shadow-md bg-slate-100 dark:bg-slate-800">
                    <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Input Asset</h1>
                    <div id="containerFormCheckoutAsset" class="">
                        <form id="checkoutAsset" action="{{ route('checkout.add.action') }}" method="POST" class="space-y-2">
                            @csrf
                            <input hidden type="text" name="nameAsset" id="nameAsset" value="">
                            <div class="col-span-2 space-y-2">
                                <label for="codeAsset" class="block -mt-2 text-sm font-medium text-slate-900 dark:text-white">Search asset</label>
                                <div class="relative w-full">
                                    <input type="text" id="codeAsset" name="codeAsset" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Input Code" />
                                    <div id="autocompleteList" class="absolute z-10 w-full bg-white border border-slate-300 rounded-md max-h-48 overflow-y-auto hidden shadow-lg dark:bg-slate-700 dark:border-slate-600 
                                    
                                    
                                    scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100  dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label for="price" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Price</label>
                                <input type="number" name="price" id="price" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Enter price">
                            </div> 
                            <button type="submit" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md">
                                Add
                            </button>
                            {{-- <button type="button" class="inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-slate-700 rounded-md border border-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">
                                Scan
                            </button> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ModalAdd -->
    <div id="ModalAdd" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-slate-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-slate-600 border-slate-200">
                    <h3 id="labelModal" class="text-lg font-semibold text-slate-900 dark:text-white">Add Asset</h3>
                    <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="ModalAdd">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div id="formModal" class="p-4 space-y-2">
                    <!-- Form akan diisi oleh JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('input', (e) => {
            const vendor = document.getElementById('vendor').value;
            const description = document.getElementById('description').value;
            const reason = document.getElementById('reason').value;
            document.getElementById('inputvendor').value = vendor;
            document.getElementById('inputdescription').value = description;
            document.getElementById('inputreason').value = reason;
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Clone form dan ubah ID-nya untuk modal checkoutAsset
            const originalFormHTML = document.getElementById('containerFormCheckoutAsset').innerHTML;
            const modalFormHTML = originalFormHTML.replace(/id="(.*?)"/g, 'id="$1-modal"');
            document.getElementById('formModal').innerHTML = modalFormHTML;
        });


        const itemAsset = @json($assetItem); // Data dari controller

        document.addEventListener('input', (e) => {
            if (e.target.matches('input[name="codeAsset"], input[name="codeAsset-modal"]')) {
            // if (e.target.id === 'codeAsset') {
                const inputValue = e.target.value.toLowerCase();
                const autocompleteContainer = e.target.nextElementSibling;
                autocompleteContainer.innerHTML = '';

                // Filter data berdasarkan input
                const filteredAssets = itemAsset.filter(item =>
                    item.code_assets.toLowerCase().includes(inputValue)
                );

                // Tampilkan hasil autocomplete
                filteredAssets.forEach(item => {
                    const option = document.createElement('div');
                    option.textContent = item.code_assets;
                    option.classList.add('p-2', 'cursor-pointer', 'hover:bg-slate-100', 'dark:hover:bg-slate-600', 'text-slate-900', 'dark:text-white');
                    option.addEventListener('click', () => {
                        e.target.value = item.code_assets; // Isi input codeAsset
                        const form = e.target.closest('form');
                        const nameAssetInput = form.querySelector('input[name="nameAsset"]');
                        if (nameAssetInput) nameAssetInput.value = item.asset_name; // Isi input nameAsset
                        // document.getElementById('nameAsset').value = item.asset_name; // Isi input nameAsset
                        autocompleteContainer.classList.add('hidden'); // Sembunyikan autocomplete
                    });
                    autocompleteContainer.appendChild(option);
                });

                // Tampilkan atau sembunyikan autocomplete container
                autocompleteContainer.classList.toggle('hidden', filteredAssets.length === 0);

                // Cek apakah input codeAsset sesuai dengan data yang ada di itemAsset
                const form = e.target.closest('form');
                const nameAssetInput = form.querySelector('input[name="nameAsset"]');
                
                const matchedItem = itemAsset.find(item => item.code_assets.toLowerCase() === inputValue);
                if (nameAssetInput) nameAssetInput.value = matchedItem ? matchedItem.asset_name : ""; // Isi input nameAsset
            }
        });


        function validateForm(form) {
            const codeAsset = form.querySelector('input[name="codeAsset"]').value.trim();
            const price = form.querySelector('input[name="price"]').value.trim();
            const errors = [];

            if (!codeAsset) errors.push('Code Asset tidak boleh kosong');
            else if (codeAsset.length != 8) errors.push('Code Asset Tidak Valid');
            if (!price) errors.push('Price tidak boleh kosong');
            else if (!/^\d+$/.test(unitPrice) || unitPrice <= 0) errors.push('Price harus angka');
            return errors;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('submit', function (e) {
                if (e.target && (e.target.id === 'checkoutAsset' || e.target.id === 'checkoutAsset-modal')) {
                    e.preventDefault();
                    const errors = validateForm(e.target);
                    if (errors.length > 0) showAlert('danger', errors);
                    else this.submit();
                }
            });
        });

        function validateFormsubmitCheckin(){
            const totalprice = document.getElementById('totalprice').value.trim();
            const inputreason = document.getElementById('inputreason').value.trim();
            const inputvendor = document.getElementById('inputvendor').value.trim();
            const inputdescription = document.getElementById('inputdescription').value.trim();
            const errors = [];
            
            if (!totalprice) {
                if (!inputreason) errors.push('Reason tidak boleh kosong');
                if (!inputvendor) errors.push('Vendor tidak boleh kosong');
                if (!inputdescription) errors.push('Description  tidak boleh kosong');
                else if (inputdescription.length < 3) errors.push('Description minimal 3 karakter');
                else if (inputdescription.length > 100) errors.push('Description maksimal 100 karakter');
            } else {
                errors.push('Pilih Asset terlebih dahulu');
            }
            return errors;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('submitCheckin').addEventListener('submit', function (e) {
                e.preventDefault(); 
                const errors = validateFormsubmitCheckin();
                if (errors.length > 0) showAlert('danger', errors);
                else this.submit();
            });
        });

    </script>
</x-layoutdsbd>