<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">

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
                    <input type="text" id="inputSearch" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-40 lg:w-80  bg-gray-50 focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Search Account">
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button id="addButton"
                    data-modal-target="ModalAccount" 
                    data-modal-toggle="ModalAccount"
                    class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Add</button>
                <button id="importButton"
                    data-modal-target="ModalImportAccount" 
                    data-modal-toggle="ModalImportAccount"
                    class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Import</button>
            </div>
        </div>
    
        <div class="w-full overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full h-screen">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr class="sticky top-0 text-gray-900 dark:text-gray-100 bg-slate-100 dark:bg-gray-900 border-b-2 border-gray-200 dark:border-gray-700 shadow-md">
                        <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Name</th>
                        <th class="py-3 px-1 whitespace-nowrap">Email</th>
                        <th class="py-3 px-1 whitespace-nowrap">Role</th>
                        <th class="py-3 px-1 whitespace-nowrap">Department</th>
                        <th class="py-3 px-1 whitespace-nowrap">Status</th>
                        <th class="py-3 px-1 whitespace-nowrap">Is Disable</th>
                        <th class="py-3 px-1 whitespace-nowrap text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse ($userall as $user)
                        <tr class="text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 rounded-md">
                            <td class="py-3 px-1 whitespace-nowrap text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $user->username }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $user->role->role_name }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $user->department->department_name }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $user->is_disable ? 'Disable' : 'Enable' }}</td>
                            <td class="py-2 px-1 whitespace-nowrap text-center">
                                <button
                                    data-modal-target="ModalAccount" 
                                    data-modal-toggle="ModalAccount" 
                                    data-label="Edit Account"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->username }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ $user->role->role_name }}"
                                    data-role-id="{{ $user->role->id }}"
                                    data-department="{{ $user->department->department_name }}"
                                    data-department-id="{{ $user->department->id }}"
                                    data-disable="{{ $user->is_disable }}"
                                    class="py-1 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md edit-button">Edit</button>
                                
                                <button
                                    type="button"
                                    data-id="{{ $user->id }}"
                                    data-modal-target="modalDelete" 
                                    data-modal-toggle="modalDelete"
                                    data-name="{{ $user->username }}"
                                    data-action="{{ route('account.delete.action', $user->id) }}"
                                    class="py-1 px-4 border-2 bg-red-100 hover:bg-red-200 dark:bg-red-800 dark:hover:bg-red-700 dark:border-0 dark:text-white rounded-md deleteButton">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-gray-500 dark:text-gray-400">
                                No user found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    



    <!-- ModalAdd -->
    <div id="ModalAccount" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 id="labelModal" class="text-lg font-semibold text-gray-900 dark:text-white">
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="ModalAccount">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="formAccount" class="p-3 md:p-4" action="" method="">
                    @csrf
                    <div class="grid gap-3 mb-3 grid-cols-1">
                        <input hidden  name="modalId" id="modalId" value="">
                        <div class="col-span-1">
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name Account</label>
                            <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Joko Suwardi">
                        </div>
                        <div id="colEml" class="col-span-1">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="xxxx@gmail.com">
                        </div>
                        <div id="colPass" class="col-span-1">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" value="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Password">
                        </div>
                        <div id="colRol" class="col-span-1">
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selete Role</label>
                            <select name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Name Account Items">
                                <option id="role" selected="" value="">select role</option>
                                @foreach ($dataRole as $item)
                                    <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="colDpart" class="col-span-1">
                            <label for="department" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selete department</label>
                            <select name="department" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Name Account Items">
                                <option id="department" selected="" value="">select department</option>
                                @foreach ($dataDepartment as $item)
                                    <option value="{{ $item->id }}">{{ $item->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex gap-2">
                        <button type="submit" class="text-white  bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-gray-600 dark:hover:bg-gray-800 dark:focus:ring-gray-800 w-full">
                            Submit
                        </button>
                        <button type="button" 
                                id="btn-rst"
                                data-modal-target="modalExeData" 
                                data-modal-toggle="modalExeData" 
                                data-modal-hide="ModalAccount"
                                class=" text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800 w-full">
                            Reset
                        </button>
                        <button type="button" 
                                id="btn-disable"
                                data-modal-target="modalExeData" 
                                data-modal-toggle="modalExeData" 
                                data-modal-hide="ModalAccount"
                                class="hidden text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 w-full">
                            Disable
                        </button>
                        <button type="button" 
                                id="btn-enable"
                                data-modal-target="modalExeData" 
                                data-modal-toggle="modalExeData" 
                                data-modal-hide="ModalAccount"
                                class="hidden text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 w-full">
                            Enable
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ModalExeData -->
    <div id="modalExeData" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalExeData">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 id="labelexe" class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"></h3>
                    <form id="dataExeForm" action="" method="">
                        @csrf
                        <input type="hidden" name="idexedata" id="idexedata" value="">
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, I'm sure
                        </button>
                        <button data-modal-hide="modalExeData" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modaldelete -->
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
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this Account?</h3>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        <input type="hidden" name="deleteID" id="deleteID" value="">
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, I'm sure
                        </button>
                        <button data-modal-hide="modalDelete" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium rounded-lg  text-slate-800 bg-slate-200 hover:bg-slate-300 dark:bg-gray-600 dark:hover:bg-gray-800 dark:text-white">No, cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ImportModal -->
    <div id="ModalImportAccount" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 id="labelModal" class="text-lg font-semibold text-gray-900 dark:text-white">
                        Import Account
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="ModalImportAccount">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="importForm" action="{{ route('account.import.action') }}" class="p-3 md:p-4 space-y-4" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                        <input name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
                    </div>
                    <button type="submit" class="text-white  bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-gray-600 dark:hover:bg-gray-800 dark:focus:ring-gray-800 w-full">
                        Submit Account
                    </button>
                </form>
            </div>
        </div>
    </div> 

<script>

    // Event listener untuk tombol add
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil semua tombol dengan class ''
        const addButton = document.getElementById('addButton');
        if (addButton) {
            addButton.addEventListener('click', function () {
                // Ambil data dari atribut tombol
                const label = addButton.getAttribute('data-label');
                document.getElementById('btn-rst').classList.add('hidden');
                document.getElementById('colPass').classList.remove('hidden');
                // Update action form (jika diperlukan)
                const form = document.getElementById('formAccount');
                form.action = `{{ route('account.add.action') }}`; // Sesuaikan dengan route Anda
                form.method = 'POST'; // Sesuaikan dengan method yang Anda inginkan
                // Kosongkan inputan modal (karena ini untuk Add)
                document.getElementById('labelModal').textContent = 'Add Account';
                document.getElementById('modalId').value = '';
                document.getElementById('username').value = '';
                document.getElementById('email').value = '';
                document.getElementById('email').disabled = false;
                document.getElementById('role').value = '';
            });
        }
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
                const email = button.getAttribute('data-email');
                const role = button.getAttribute('data-role');
                const roleId = button.getAttribute('data-role-id');
                const department = button.getAttribute('data-department');
                const departmentId = button.getAttribute('data-department-id');
                const isdisable = button.getAttribute('data-disable');
                // Isi data ke dalam form modal
                document.getElementById('colPass').classList.add('hidden');
                document.getElementById('btn-rst').classList.remove('hidden');
                document.getElementById('labelModal').textContent = label;
                document.getElementById('modalId').value = id;
                document.getElementById('username').value = name;
                document.getElementById('email').value = email;
                document.getElementById('role').value = roleId;
                document.getElementById('role').textContent = role;
                document.getElementById('department').value = departmentId;
                document.getElementById('department').textContent = department;
                document.getElementById('email').isdisable = true;
                if(isdisable == true){
                    document.getElementById('btn-enable').classList.remove('hidden');
                    document.getElementById('btn-disable').classList.add('hidden');
                } else {
                    document.getElementById('btn-enable').classList.add('hidden');
                    document.getElementById('btn-disable').classList.remove('hidden');
                }

                // Update action form (jika diperlukan)
                const form = document.getElementById('formAccount');
                form.action = `{{ route('account.edit.action') }}`; // Sesuaikan dengan route Anda
                form.method = 'POST' ; // Sesuaikan dengan method yang Anda inginkan
            });
        });
    });

    // Event listener untuk tombol reset
    document.addEventListener('DOMContentLoaded', function () {
        const exeButtons = document.getElementById('btn-rst');
        if(exeButtons){
            exeButtons.addEventListener('click', function () {
                document.getElementById('labelexe').textContent = 'Are you sure you want to Reset this Account?';
                const resetForm = document.getElementById('dataExeForm');
                resetForm.action = `{{ route('account.reset.action') }}`;
                resetForm.method = 'POST';
                const idexedata = document.getElementById('idexedata');
                idexedata.value = document.getElementById('modalId').value;
            });
        }
    });

    // Event listener untuk tombol reset
    document.addEventListener('DOMContentLoaded', function () {
        const exeButtons = document.getElementById('btn-disable');
        if(exeButtons){
            exeButtons.addEventListener('click', function () {
                document.getElementById('labelexe').textContent = 'Are you sure you want to disable this Account?';
                const resetForm = document.getElementById('dataExeForm');
                resetForm.action = `{{ route('account.disable.action') }}`;
                resetForm.method = 'POST';
                const idexedata = document.getElementById('idexedata');
                idexedata.value = document.getElementById('modalId').value;
            });
        }
    });

    // Event listener untuk tombol reset
    document.addEventListener('DOMContentLoaded', function () {
        const exeButtons = document.getElementById('btn-enable');
        if(exeButtons){
            exeButtons.addEventListener('click', function () {
                document.getElementById('labelexe').textContent = 'Are you sure you want to enable this Account?';
                const resetForm = document.getElementById('dataExeForm');
                resetForm.action = `{{ route('account.enable.action') }}`;
                resetForm.method = 'POST';
                const idexedata = document.getElementById('idexedata');
                idexedata.value = document.getElementById('modalId').value;
            });
        }
    });


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
                    document.getElementById('deleteID').value = id;
                    // Update action form sesuai dengan ID
                    const form = document.getElementById('deleteForm');
                    form.action = action;

                });
            });
        });


    // Event listener untuk Search
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('inputSearch');
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.getElementsByTagName('tr');
        const noResultsMessage = document.createElement('tr');
        noResultsMessage.innerHTML = '<td colspan="7" class="text-center py-3 text-gray-500 dark:text-gray-400">No Category found.</td>';

        noResultsMessage.style.display = 'none';
        tableBody.appendChild(noResultsMessage);

        searchInput.addEventListener('keyup', function () {
            const searchText = searchInput.value.toLowerCase();
            let found = false;
            
            for (let row of rows) {
                if (row === noResultsMessage) continue;
                
                const name = row.cells[1]?.textContent.toLowerCase() || '';
                const email = row.cells[2]?.textContent.toLowerCase() || '';
                const role = row.cells[3]?.textContent.toLowerCase() || '';
                const department = row.cells[4]?.textContent.toLowerCase() || '';
                const status = row.cells[5]?.textContent.toLowerCase() || '';
                
                if (name.includes(searchText) || email.includes(searchText) || role.includes(searchText) || department.includes(searchText) || status.includes(searchText)) {
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