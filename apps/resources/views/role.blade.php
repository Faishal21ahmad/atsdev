<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
<!-- Roles -->
<div class="container mx-auto w-full">
    <div class="w-full flex justify-between mb-2 items-center">
        <div class="">
            <label for="inputSearch" class="sr-only">Search</label>
            <div class="w-20 relative">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="inputSearch" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-40 lg:w-80  bg-gray-50 focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Search Role">
            </div>
        </div>
        <button id="addButton" 
                data-modal-target="ModalRole" 
                data-modal-toggle="ModalRole" 
                data-label="Add Roles"
                data-action="{{ route('role.add.action') }}"
                data-method="POST"
                class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Add
        </button>
    </div>

    <div class="w-full overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
        <table id="tabelData" class="table-auto w-full text-left">
            <thead>
                <tr class="sticky top-0 text-gray-900 dark:text-gray-100 bg-slate-100 dark:bg-gray-900 border-b-2 border-gray-200 dark:border-gray-700 shadow-md">
                    <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                    <th class="py-3 px-1 whitespace-nowrap">Nama Roles</th>
                    <th class="py-3 px-1 whitespace-nowrap">Description</th>
                    <th class="py-3 px-1 whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse ($roles as $role)
                    <tr class="text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 rounded-md">
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $role->role_name }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $role->description }}</td>
                        <td class="py-2 px-1 whitespace-nowrap max-w-[20ch] truncate">
                            <button 
                                data-modal-target="ModalRole" 
                                data-modal-toggle="ModalRole" 
                                data-label="Edit Roles"
                                data-id="{{ $role->id }}"
                                data-name="{{ $role->role_name }}"
                                data-description="{{ $role->description }}"
                                data-action="{{ route('role.edit.action') }}"
                                data-method="POST"
                                class="py-1 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md edit-button">Edit</button>
                            <button
                                type="button"
                                data-id="{{ $role->id }}"
                                data-modal-target="modalDelete" 
                                data-modal-toggle="modalDelete"
                                data-name="{{ $role->role_name }}"
                                data-action="{{ route('role.delete.action', $role->id ) }}"
                                class="py-1 px-4 border-2 bg-red-100 hover:bg-red-200 dark:bg-red-800 dark:hover:bg-red-700 dark:border-0 dark:text-white rounded-md deleteButton">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3 text-gray-500 dark:text-gray-400">
                            No Roles found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    <!-- ModalAdd -->
    <div id="ModalRole" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 id="labelModal" class="text-lg font-semibold text-gray-900 dark:text-white">
                        
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="ModalRole">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="formRole" class="p-3 md:p-4" action="" method="">
                    @csrf
                    <div class="grid gap-3 mb-3 grid-cols-2">
                        <input hidden  name="modalId" id="modalId" value="">
                        <div class="col-span-2">
                            <label for="nameRole" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name Role</label>
                            <input type="text" name="nameRole" id="nameRole" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Name Role Items">
                        </div>
                    
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role Description</label>
                            <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Write Role description here"></textarea>                    
                        </div>
                    </div>
                    <button type="submit" class="text-white  bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-gray-600 dark:hover:bg-gray-800 dark:focus:ring-gray-800 w-full">
                        Submit Role
                    </button>
                </form>
            </div>
        </div>
    </div> 

    <div id="modalDelete" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalDelete">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this Role ?</h3>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="deleteId" value="">
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, I'm sure
                        </button>
                        <button data-modal-hide="modalDelete" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium rounded-lg  text-slate-800 bg-slate-200 hover:bg-slate-300 dark:bg-gray-600 dark:hover:bg-gray-800 dark:text-white">No, cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
// Event listener untuk tombol delete
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.deleteButton');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Ambil data dari atribut tombol
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const action = button.getAttribute('data-action');
            // Isi input hidden di form delete
            document.getElementById('deleteId').value = id;
            // Update action form sesuai dengan ID
            const form = document.getElementById('deleteForm');
            form.action = `${action}`; 
        });
    });
});

// Event listener untuk tombol edit
document.addEventListener('DOMContentLoaded', function () {
    // Ambil semua tombol dengan class 'edit-button'
    const editButtons = document.querySelectorAll('.edit-button');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Ambil data dari atribut tombol
            const label = button.getAttribute('data-label');
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');
            const action = button.getAttribute('data-action');
            const method = button.getAttribute('data-method');
            // Isi data ke dalam form modal
            document.getElementById('labelModal').textContent = label;
            document.getElementById('modalId').value = id;
            document.getElementById('nameRole').value = name;
            document.getElementById('description').value = description;
            // Update action form (jika diperlukan)
            const form = document.getElementById('formRole');
            form.action = `${action}`; // Sesuaikan dengan route Anda
            form.method = method ; // Sesuaikan dengan method yang Anda inginkan
        });
    });
});

// Event listener untuk tombol add
document.addEventListener('DOMContentLoaded', function () {
    // Ambil semua tombol dengan class ''
    const addButton = document.getElementById('addButton');
    if (addButton) {
        addButton.addEventListener('click', function () {
            // Ambil data dari atribut tombol
            const label = addButton.getAttribute('data-label');
            const action = addButton.getAttribute('data-action');
            const method = addButton.getAttribute('data-method');
            document.getElementById('labelModal').textContent = label;
            // Update action form (jika diperlukan)
            const form = document.getElementById('formRole');
            form.action = action; // Sesuaikan dengan route Anda
            form.method = method; // Sesuaikan dengan method yang Anda inginkan
            // Kosongkan inputan modal (karena ini untuk Add)
            document.getElementById('modalId').value = ''; 
            document.getElementById('nameRole').value = '';
            document.getElementById('description').value = '';
        });
    }
});

// Fungsi untuk validasi client-side
function validateForm() {
    const nameRole = document.getElementById('nameRole').value;
    const description = document.getElementById('description').value;
    const errors = [];

    if (nameRole === '') {
        errors.push('Name Location tidak boleh kosong');
    }

    if (description === '') {
        errors.push('Description tidak boleh kosong');
    }
    return errors;
}

// Event listener untuk form submission
document.getElementById('formRole').addEventListener('submit', function (e) {
    e.preventDefault(); 
    const errors = validateForm();

    if (errors.length > 0) {
        showAlert('danger', errors);
    }  else {
        // Jika tidak ada error, submit form secara manual
        this.submit();
    }
});

// Event listener untuk Search
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('inputSearch');
    const tableBody = document.getElementById('tableBody');
    const rows = tableBody.getElementsByTagName('tr');
    const noResultsMessage = document.createElement('tr');
    noResultsMessage.innerHTML = '<td colspan="4" class="text-center py-3 text-gray-500 dark:text-gray-400">No Role nfound.</td>';

    noResultsMessage.style.display = 'none';
    tableBody.appendChild(noResultsMessage);

    searchInput.addEventListener('keyup', function () {
        const searchText = searchInput.value.toLowerCase();
        let found = false;
        
        for (let row of rows) {
            if (row === noResultsMessage) continue;
            
            const name = row.cells[1]?.textContent.toLowerCase() || '';
            const description = row.cells[2]?.textContent.toLowerCase() || '';
            
            if (name.includes(searchText) || description.includes(searchText)) {
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