<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />
    <div class="container mx-auto w-full mt-2">
        <div class="flex w-full justify-between dark:text-white ">
            <div class="">
                <h1 class="text-2xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap overflow-hidden">{{ $user['name'] }}</h1>
                <p class="text-3xl font-semibold">Total : <span id="totalCheckIN">{{ number_format($total, 0, ',', '.') }}</span></p>
            </div>
            
            <div class="inline-flex flex-col gap-2 text-black">
                <form id="submitCheckin" action="{{ route('checkin.save.action') }}" method="POST" class="">
                    @csrf
                    <input hidden id="totalHarga" type="text" name="total" value="{{ $total }}">
                    <input hidden id="descriptionInput" type="text" name="description" value="">
                    <input hidden id="vendorInput" type="text" name="vendor" value="">
                    <button type="submit" id="checkOUT" class="px-5 sm:px-10 py-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Check IN</button>
                </form>
                <button type="button" id="addButton" data-modal-target="ModalImportCheckin" data-modal-toggle="ModalImportCheckin" class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Import</button>
                <button type="button" id="addButton" data-modal-target="ModalAdd" data-modal-toggle="ModalAdd" class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md lg:hidden">Add Asset</button>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto w-full mt-5">
        <div class="grid gap-4 lg:grid-cols-2 grid-cols-1">
            <div class="overflow-hidden">
                <div class="overflow-x-auto overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                    <table id="tableList" class="table-auto w-full text-left">
                        <thead>
                            <tr class="sticky top-0 text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-800 shadow-md">
                                <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                                <th class="py-3 px-1 whitespace-nowrap">Nama Asset</th>
                                <th class="py-3 px-1 whitespace-nowrap">Unit Price</th>
                                <th class="py-3 px-1 whitespace-nowrap text-center">Quantity</th>
                                <th class="py-3 px-1 whitespace-nowrap">Price</th>
                                <th class="py-3 px-1 whitespace-nowrap text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="border-b border-slate-200 dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100">
                        @if (empty($cart))
                            <tr>
                                <td colspan="6" class="py-3 px-1 text-center">Empty Data</td>
                            </tr>
                        @else
                            @foreach ($cart as $index => $item)
                                <tr class="text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-700 rounded-md">
                                    <td class="py-3 px-1 whitespace-nowrap text-center">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-1 whitespace-nowrap">{{ $item['nameAsset'] ?? '' }}</td>
                                    <td class="py-3 px-1 whitespace-nowrap">Rp {{ number_format($item['unitPrice'], 0, ',', '.') ?? '' }}</td>
                                    <td class="py-3 px-1 whitespace-nowrap text-center">{{ $item['quantity'] ?? '' }}</td>
                                    <td class="py-3 px-1 whitespace-nowrap">Rp {{ number_format($item['unitPrice'] * $item['quantity'], 0, ',', '.') ?? '' }}</td>
                                    <td class="py-3 px-1 whitespace-nowrap text-center">
                                        <form action="{{ route('checkin.remove.action', $item['id']) }}" method="POST">
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
            <div id="formContent" class=" space-y-2">
                <div class="w-full p-4 border dark:border-0 shadow-md bg-white dark:bg-slate-800 rounded-lg space-y-2">
                    <div class="col-span-2">
                        <label for="vendor" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">vendor</label>
                        <select id="vendor" name="vendor" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500">
                            <option selected value="">select vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="Description" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Your Description</label>
                        <textarea id="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Write your thoughts here..."></textarea>
                    </div>
                </div>
                <div class="hidden lg:block w-full p-4 shadow-md border dark:border-0 bg-white dark:bg-slate-800 rounded-lg space-y-2">
                    <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Input Asset</h1>
                    <div id="containerFormAdd" class="">
                        <form id="inputCheckin" action="{{ route('checkin.add.action') }}" method="POST" class="space-y-2">
                            @csrf
                            <div id="bodyForm" class="space-y-2">
                                <input type="text" hidden name="slug" id="slug" value="{{ $nameMastarAsset->slug ?? '' }}">
                                <div class="col-span-2 relative">
                                    <label for="nameAsset" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Name Asset</label>
                                    <input type="text" name="nameAsset" id="nameAsset" list="assetList" value="{{ $nameMastarAsset->asset_name ?? '' }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Enter Asset name">
                                    <div id="autocompleteList" class="absolute z-10 w-full bg-white border border-slate-300 rounded-lg mt-1 max-h-48 overflow-y-auto hidden shadow-lg dark:bg-slate-700 dark:border-slate-600  scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100  dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <label for="unitPrice" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Unit Price</label>
                                    <input type="number" name="unitPrice" id="unitPrice" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Enter Unit Price">
                                </div> 
                                <div class="col-span-2">
                                    <label for="quantity" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Enter Quantity">
                                </div> 
                                <div class="col-span-2">
                                    <label for="condition" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Condition</label>
                                    <input type="text" name="condition" id="condition" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="New or Secondhand">
                                </div> 
                                
                            </div>
                            <button type="submit" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md" data-modal-hide="ModalAdd">
                                Add
                            </button>
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

    <!-- ImportModal -->
    <div id="ModalImportCheckin" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative  bg-white rounded-lg shadow-sm dark:bg-slate-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-slate-600 border-slate-200">
                    <h3 id="labelModal" class="text-lg font-semibold text-slate-900 dark:text-white">
                        Import Checkin
                    </h3>
                    <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-toggle="ModalImportCheckin">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="importForm" action="{{ route('checkin.import.action') }}" class="p-3 -mt-4 md:p-4 space-y-4" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="">
                        <label class="block mb-2 text-sm font-medium text-slate-900 dark:text-white" for="file_input">Upload file</label>
                        <input name="file" class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-slate-50 dark:text-slate-400 focus:outline-none dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400" id="file_input" type="file">
                    </div>
                    <button type="submit" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div> 

<script>
    document.addEventListener('input', (e) => {
        const textarea = document.getElementById('description').value;
        document.getElementById('descriptionInput').value = textarea;
        const vendor = document.getElementById('vendor').value;
        document.getElementById('vendorInput').value = vendor;
    });

    // Fungsi untuk menampilkan modal
    document.addEventListener('DOMContentLoaded', () => {
        // Clone form dan ubah ID-nya untuk modal
        const originalFormHTML = document.getElementById('containerFormAdd').innerHTML;
        const modalFormHTML = originalFormHTML.replace(/id="(.*?)"/g, 'id="$1-modal"');
        document.getElementById('formModal').innerHTML = modalFormHTML;
    });

    const assetMaster = @json($assetMaster);

    // Autocomplete untuk kedua form (asli dan modal)
    document.addEventListener('input', (e) => {
        if (e.target.matches('input[name="nameAsset"], input[name="nameAsset-modal"]')) {
            const inputValue = e.target.value.toLowerCase();
            const autocompleteContainer = e.target.nextElementSibling;
            autocompleteContainer.innerHTML = '';

            const filteredAssets = assetMaster.filter(asset =>
                asset.asset_name.toLowerCase().includes(inputValue)
            );

            filteredAssets.forEach(asset => {
                const option = document.createElement('div');
                option.textContent = asset.asset_name;
                option.classList.add('p-2', 'cursor-pointer', 'hover:bg-slate-100', 'dark:hover:bg-slate-600', 'text-slate-900', 'dark:text-white');
                option.addEventListener('click', () => {
                    e.target.value = asset.asset_name;
                    const form = e.target.closest('form');
                    const slugInput = form.querySelector('input[name="slug"]');
                    if (slugInput) {
                        slugInput.value = asset.slug;
                    }
                    autocompleteContainer.classList.add('hidden');
                });
                autocompleteContainer.appendChild(option);
            });

            autocompleteContainer.classList.toggle('hidden', filteredAssets.length === 0);

            const form = e.target.closest('form');
            const slugInput = form.querySelector('input[name="slug"]');
            const matchedAsset = assetMaster.find(asset => asset.asset_name.toLowerCase() === inputValue);
            if (slugInput) {
                slugInput.value = matchedAsset ? matchedAsset.slug : "";
            }
        }
    });


    // Validasi form
    function validateForm(form) {
        const nameAsset = form.querySelector('input[name="nameAsset"]').value.trim();
        const unitPrice = form.querySelector('input[name="unitPrice"]').value.trim();
        const quantity = form.querySelector('input[name="quantity"]').value.trim();
        const condition = form.querySelector('input[name="condition"]').value.trim();
        const errors = [];

        if (!nameAsset) errors.push('Nama Asset wajib diisi');
        else if (nameAsset.length > 70) errors.push('Nama Asset maksimal 70 karakter');
        if (!unitPrice) errors.push('Unit Price wajib diisi');
        else if (!/^\d+$/.test(unitPrice) || unitPrice <= 0) errors.push('Unit Price harus angka');
        if (!quantity) errors.push('Quantity wajib diisi');
        else if (!/^\d+$/.test(quantity) || quantity <= 0) errors.push('Quantity harus angka');
        if (!condition) errors.push('Condition wajib diisi');
        else if (condition.length > 100) errors.push('Condition maksimal 100 karakter');
        return errors;
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('submit', function (e) {
            if (e.target && (e.target.id === 'inputCheckin' || e.target.id === 'inputCheckin-modal')) {
                e.preventDefault();
                const errors = validateForm(e.target);
                if (errors.length > 0) showAlert('danger', errors); 
                else e.target.submit();
            }
        });
    });

    function validateFormsubmitCheckin(){
        const totalHarga = document.getElementById('totalHarga').value;
        const descriptionInput = document.getElementById('descriptionInput').value;
        const vendorInput = document.getElementById('vendorInput').value;
        const errors = [];

        if (!totalHarga || totalHarga <= 0) {
            errors.push('Tidak ada asset yang dipilih');
        } else {
            if (!descriptionInput) errors.push('description tidak boleh kosong');
            else if (descriptionInput.length < 3) errors.push('description minimal 3 karakter');
            else if (descriptionInput.length > 300) errors.push('description maksimal 300 karakter');
            if (!vendorInput) errors.push('vendor tidak boleh kosong');
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