<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">

<!-- Roles -->
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
                <input type="text" id="inputSearch" class="block p-2 ps-10 text-sm text-slate-900 border border-slate-300 rounded-lg w-40 lg:w-80  bg-slate-50 focus:ring-slate-300 focus:border-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Search Role">
            </div>
        </div>
        @can('add-role')
            <button 
                id="addButton" 
                data-modal-target="ModalRole" 
                data-modal-toggle="ModalRole" 
                class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Add
            </button>
        @endcan
    </div>

    <div class="w-full overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
        {{-- tabel list role --}}
        <table id="tabelData" class="table-auto w-full text-left">
            <thead>
                <tr class="sticky top-0 text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-700 shadow-md">
                    <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                    <th class="py-3 px-1 whitespace-nowrap">Nama Roles</th>
                    <th class="py-3 px-1 whitespace-nowrap">Description</th>
                    @canany(['delete-role','edit-role'])
                        <th class="py-3 px-1 whitespace-nowrap text-center">Action</th>
                    @endcanany
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse ($roles as $item)
                    <tr class="text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-700 rounded-md">
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $item->role_name }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $item->description }}</td>
                        @canany(['delete-role','edit-role'])
                        <td class="py-2 px-1 whitespace-nowrap text-center">
                            @can('edit-role')
                                <button 
                                type="button"
                                data-modal-target="ModalRole" 
                                data-modal-toggle="ModalRole"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->role_name }}"
                                data-description="{{ $item->description }}"
                                class="py-1 px-4 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md editButton">Edit</button>
                            @endcan
                            @can('delete-role')
                                <button
                                type="button"
                                data-modal-target="modalDelete" 
                                data-modal-toggle="modalDelete"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->role_name }}"
                                class="py-1 px-4 shadow-md bg-red-100 hover:bg-red-200 dark:bg-red-800 dark:hover:bg-red-700 dark:text-white rounded-md deleteButton">Delete</button>
                            @endcan

                            {{-- button modal pengaturan permission role, mengirimkan id role  --}}
                            @can('role-permission-management')
                            <a href="{{ route('permission', $item->id) }}">
                                <button
                                    type="button"
                                    class="py-1 px-4 shadow-md bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-800 dark:hover:bg-yellow-700 dark:text-white rounded-md permissionButton">Permission</button>
                            </a>
                            @endcan
                        </td>
                        @endcanany
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3 text-slate-500 dark:text-slate-400">
                            not found roles
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    @canany(['add-role','edit-role'])
        <!-- ModalAddEdit -->
        <div id="ModalRole" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-slate-800">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-slate-600 border-slate-200">
                        <h3 id="labelModal" class="text-lg font-semibold text-slate-900 dark:text-white"></h3>
                        <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-toggle="ModalRole">
                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form id="formRole" class="p-3 md:p-4" action="" method="POST">
                        @csrf
                        <div class="grid gap-3 mb-3 grid-cols-2">
                            <input hidden  name="modalId" id="modalId" value="">
                            <div class="col-span-2">
                                <label for="nameRole" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Name Role</label>
                                <input type="text" name="nameRole" id="nameRole" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Name Role Items">
                            </div>
                            <div class="col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Role Description</label>
                                <textarea id="description" name="description" rows="4" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Write Role description here"></textarea>                    
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
    
    @can('delete-role')
        <div id="modalDelete" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-slate-800">
                    <button type="button" class="absolute top-3 end-2.5 text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="modalDelete">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-slate-400 w-12 h-12 dark:text-slate-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-slate-500 dark:text-slate-400">Are you sure you want to delete this Role ?</h3>
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" id="deleteId" value="">
                            <div class="space-x-2">
                                <button type="submit" class="px-5 py-2.5 text-white bg-red-600 hover:bg-red-800 shadow-md font-medium rounded-lg text-sm text-center">
                                    Yes, I'm sure
                                </button>
                                <button data-modal-hide="modalDelete" type="button" class="py-2.5 px-5 ms-3 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md">No, cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

<script>
// Event listener untuk tombol delete
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.deleteButton');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const { id, name } = this.dataset;
            document.getElementById('deleteId').value = id;
            const form = document.getElementById('deleteForm'); 
            form.action = `{{ route('role.delete.action', ['id' => ':id']) }}`.replace(':id', id); 
        });
    });
});

// Event listener untuk tombol edit
document.addEventListener('DOMContentLoaded', function () {
    // Ambil semua tombol dengan class 'edit-button'
    const editButtons = document.querySelectorAll('.editButton');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const { id, name, description } = this.dataset;
            document.getElementById('labelModal').textContent = 'Edit Roles';
            document.getElementById('modalId').value = id;
            document.getElementById('nameRole').value = name;
            document.getElementById('description').value = description;
            const form = document.getElementById('formRole');
            form.action = `{{ route('role.edit.action') }}`;
        });
    });
});

// Event listener untuk tombol add
document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.getElementById('addButton');
    if (addButton) {
        addButton.addEventListener('click', function () {
            document.getElementById('labelModal').textContent = 'Add Roles';
            const form = document.getElementById('formRole');
            form.action = `{{ route('role.add.action') }}`; 
            document.getElementById('modalId').value = ''; 
            document.getElementById('nameRole').value = '';
            document.getElementById('description').value = '';
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formRole').addEventListener('submit', function(e) {
        e.preventDefault();
        const errors = validateForm();
        if (errors.length > 0) showAlert('danger', errors);
        else this.submit();
    });
});

// Fungsi untuk validasi client-side
function validateForm() {
    const errors = [];
    const nameRole = document.getElementById('nameRole').value;
    const description = document.getElementById('description').value;

    if (!nameRole) errors.push('Name Role tidak boleh kosong');
    else if (nameRole.length > 60)  errors.push('Name Role maksimal 60 karakter');
    if (!description) errors.push('Description tidak boleh kosong');
    else if (description.length > 300) errors.push('Description maksimal 300 karakter');
    
    return errors;
}

// Event listener untuk Search
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('inputSearch');
    const tableBody = document.getElementById('tableBody');
    const rows = tableBody.getElementsByTagName('tr');
    const noResultsMessage = document.createElement('tr');
    noResultsMessage.innerHTML = '<td colspan="4" class="text-center py-3 text-slate-500 dark:text-slate-400">Data not found</td>';

    noResultsMessage.style.display = 'none';
    tableBody.appendChild(noResultsMessage);

    searchInput.addEventListener('keyup', function () {
        const searchText = searchInput.value.toLowerCase();
        let found = false;
        
        for (let row of rows) {
            if (row === noResultsMessage) continue;
            const name = row.cells[1]?.textContent.toLowerCase().trim() || '';
            const description = row.cells[2]?.textContent.toLowerCase().trim() || '';
            
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