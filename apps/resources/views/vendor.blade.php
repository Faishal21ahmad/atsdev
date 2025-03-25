<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <div class="container mx-auto w-full">
        <div class="w-full flex justify-between mb-2 items-center">
            <div class="">
                <label for="inputSearch" class="sr-only">Search</label>
                <div class="w-20 relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="inputSearch" class="block p-2 ps-10 text-sm text-slate-900 border border-slate-300 rounded-lg w-40 lg:w-80  bg-slate-50 focus:ring-slate-300 focus:border-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Search Vendor">
                </div>
            </div>

            <div class="flex items-center space-x-2">
                @can('add-vendor')
                    <button id="addVendorButton"
                        data-modal-target="ModalVendor" 
                        data-modal-toggle="ModalVendor" 
                        class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md ">Add
                    </button>
                @endcan
                @can('import-vendor')
                    <button id="importButton"
                        data-modal-target="ModalImportVendor" 
                        data-modal-toggle="ModalImportVendor"
                        class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md ">Import
                    </button>
                @endcan
            </div>
        </div>
    
        <div class="w-full overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full h-screen">
            <table id="tabelData" class="table-auto w-full text-left">
                <thead>
                    <tr class="sticky top-0 text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-700 shadow-md">
                        <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Nama Vendor</th>
                        <th class="py-3 px-1 whitespace-nowrap">Contact</th>
                        <th class="py-3 px-1 whitespace-nowrap">Address</th>
                        <th class="py-3 px-1 whitespace-nowrap">Description</th>
                        @canany(['delete-vendor','edit-vendor'])
                            <th class="py-3 px-1 whitespace-nowrap text-center">Action</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse ($vendors as $vendor)
                        <tr class="text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-700 rounded-md">
                            <td class="py-3 px-1 whitespace-nowrap text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $vendor->vendor_name }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $vendor->contact }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $vendor->address }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $vendor->description }}</td>
                            @canany(['delete-vendor','edit-vendor'])
                            <td class="py-2 px-1 whitespace-nowrap text-center">
                                @can('edit-vendor')
                                <button
                                    type="button"
                                    data-modal-target="ModalVendor" 
                                    data-modal-toggle="ModalVendor"
                                    data-id="{{ $vendor->id }}"
                                    data-name="{{ $vendor->vendor_name }}"
                                    data-contact="{{ $vendor->contact }}"
                                    data-address="{{ $vendor->address }}"
                                    data-description="{{ $vendor->description }}"
                                    class="py-1 px-4 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md  edit-vendor-button">Edit</button>
                                @endcan
                                @can('delete-vendor')
                                <button
                                    type="button"
                                    data-id="{{ $vendor->id }}"
                                    data-modal-target="modalDeleteVendor" 
                                    data-modal-toggle="modalDeleteVendor"
                                    data-name="{{ $vendor->vendor_name }}"
                                    class="py-1 px-4 shadow-md bg-red-100 hover:bg-red-200 dark:bg-red-800 dark:hover:bg-red-700 dark:text-white rounded-md deleteVendorButton">Delete</button>
                                @endcan
                            </td>
                            @endcanany
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-slate-500 dark:text-slate-400">
                                not found vendor
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @canany(['add-vendor','edit-vendor'])
        {{-- Modal Vendor --}}
        <div id="ModalVendor" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-slate-800">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-slate-600 border-slate-200">
                        <h3 id="labelModalVendor" class="text-lg font-semibold text-slate-900 dark:text-white"></h3>
                        <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-toggle="ModalVendor">
                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form id="formVendor" class="p-3 md:p-4" action="" method="">
                        @csrf
                        <div class="grid gap-3 mb-3 grid-cols-1">
                            <input hidden  name="modalId" id="modalVendorId" value="">
                            <div class="col-span-2">
                                <label for="vendorName" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Vendor Name</label>
                                <input type="text" name="vendorName" id="vendorName" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Vendor Name">
                            </div>
                            <div class="col-span-2">
                                <label for="contact" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Contact</label>
                                <input type="number" name="contact" id="contact" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Contact">
                            </div>

                            <div class="col-span-2">
                                <label for="address" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Address</label>
                                <input type="text" id="address" name="address" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Write vendor address here">                   
                            </div>
                            <div class="col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Category Description</label>
                                <textarea id="description" name="description" rows="4" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Write Category description here"></textarea>                    
                            </div>
                        </div>
                        <button type="submit" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div> 
    @endcanany

    @can('delete-vendor')
        {{-- Modal Delete Vendor --}}
        <div id="modalDeleteVendor" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-slate-800">
                    <button type="button" class="absolute top-3 end-2.5 text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="modalDeleteVendor">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-slate-400 w-12 h-12 dark:text-slate-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-slate-500 dark:text-slate-400">Are you sure you want to delete this Vendor?</h3>
                        <form id="deleteVendorForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" id="deleteVendorId" value="">
                            <div class="space-x-2">
                                <button type="submit" class="px-5 py-2.5 text-white bg-red-600 hover:bg-red-800 shadow-md font-medium rounded-lg text-sm text-center">
                                    Yes, I'm sure
                                </button>
                                <button data-modal-hide="modalDeleteVendor" type="button" class="py-2.5 px-5 ms-3 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md">No, cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    @can('import-vendor')
        <!-- ImportModal -->
        <div id="ModalImportVendor" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-slate-800">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-slate-600 border-slate-200">
                        <h3 id="labelModal" class="text-lg font-semibold text-slate-900 dark:text-white">
                            Import Vendor
                        </h3>
                        <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-toggle="ModalImportVendor">
                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form id="importForm" action="{{ route('vendor.import.action') }}" class="p-3 md:p-4 space-y-4" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-slate-900 dark:text-white" for="file_input">Upload file</label>
                            <input name="file" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-600 focus:border-slate-600 block w-full dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" id="file_input" type="file">
                        </div>
                        <button type="submit" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div> 
    @endcan
   

    <script>
        // Event listener untuk tombol delete vendor
        document.addEventListener('DOMContentLoaded', function () {
            const deleteVendorButtons = document.querySelectorAll('.deleteVendorButton');
            deleteVendorButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const { id, name } = this.dataset;
                    document.getElementById('deleteVendorId').value = id;
                    const form = document.getElementById('deleteVendorForm');
                    form.action = `{{ route('vendor.delete.action', ['id' => ':id']) }}`.replace(':id', id); 
                });
            });
        });

        // Event listener untuk tombol edit vendor
        document.addEventListener('DOMContentLoaded', function () {
            const editVendorButtons = document.querySelectorAll('.edit-vendor-button');
            editVendorButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const { id, name, contact, address, description } = this.dataset;
                    document.getElementById('labelModalVendor').textContent = `Edit Vendor`;
                    document.getElementById('modalVendorId').value = id;
                    document.getElementById('vendorName').value = name;
                    document.getElementById('contact').value = contact;
                    document.getElementById('address').value = address;
                    document.getElementById('description').value = description;
                    const form = document.getElementById('formVendor');
                    form.action = `{{ route('vendor.edit.action') }}`;
                    form.method = `POST`;
                });
            });
        });

        // Event listener untuk tombol add vendor
        document.addEventListener('DOMContentLoaded', function () {
            const addVendorButton = document.getElementById('addVendorButton');
            if (addVendorButton) {
                addVendorButton.addEventListener('click', function () {
                    document.getElementById('labelModalVendor').textContent = `Add Vendor`;
                    const form = document.getElementById('formVendor');
                    form.action = `{{ route('vendor.add.action') }}`;
                    form.method = `POST`;
                    document.getElementById('modalVendorId').value = ''; 
                    document.getElementById('vendorName').value = '';
                    document.getElementById('contact').value = '';
                    document.getElementById('address').value = '';
                    document.getElementById('description').value = '';
                });
            }
        });

        function validateForm() {
            const errors = [];
            const vendorName = document.getElementById('vendorName').value.trim();
            const contact = document.getElementById('contact').value.trim();
            const address = document.getElementById('address').value.trim();
            const description = document.getElementById('description').value.trim();

            // Validasi
            if (!vendorName) errors.push('Vendor Name tidak boleh kosong');
            else if (vendorName.length > 60) errors.push('Vendor Name maksimal 60 karakter');
            if (!contact) errors.push('Contact tidak boleh kosong');
            if (!address) errors.push('Address tidak boleh kosong');
            else if (address.length > 300) errors.push('Address maksimal 300 karakter');
            if (description.length > 300) errors.push('Description maksimal 300 karakter');

            return errors;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('formVendor').addEventListener('submit', function(e) {
                e.preventDefault();
                const errors = validateForm();
                if (errors.length > 0) showAlert('danger', errors);
                else this.submit();
            });
        });

           // Event listener untuk Search
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('inputSearch');
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.getElementsByTagName('tr');
        const noResultsMessage = document.createElement('tr');
        noResultsMessage.innerHTML = '<td colspan="6" class="text-center py-3 text-slate-500 dark:text-slate-400">Data not found</td>';

        noResultsMessage.style.display = 'none';
        tableBody.appendChild(noResultsMessage);

        searchInput.addEventListener('keyup', function () {
            const searchText = searchInput.value.toLowerCase();
            let found = false;
            
            for (let row of rows) {
                if (row === noResultsMessage) continue;
                const name = row.cells[1]?.textContent.toLowerCase().trim() || '';
                const contact = row.cells[2]?.textContent.toLowerCase().trim() || '';
                const address = row.cells[3]?.textContent.toLowerCase().trim() || '';
                const description = row.cells[4]?.textContent.toLowerCase().trim() || '';
                if (name.includes(searchText) || description.includes(searchText) || contact.includes(searchText) || address.includes(searchText)) {
                    row.style.display = '';
                    found = true;
                } else {
                    row.style.display = 'none';
                }
            }
            noResultsMessage.style.display = found ? 'none' : '';
        });
    });
    </script>
</x-layoutdsbd>