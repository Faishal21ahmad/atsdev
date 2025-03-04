<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <div class="container mx-auto w-full gap-3 flex flex-col">
        <div class="w-full flex gap-3">
            <button id="editProfileButton"
                data-modal-target="ModalEdit" 
                data-modal-toggle="ModalEdit" 
                data-label="Edit Profile"
                data-action="{{ route('vendor.add.action') }}"
                data-method="POST"
                class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Edit Profile
            </button>

            <button id="ForgotButton"
                data-modal-target="ModalForgot" 
                data-modal-toggle="ModalForgot" 
                data-label="Forgot Password"
                data-action="{{ route('vendor.add.action') }}"
                data-method="POST"
                class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Forgot Password
            </button>
        </div>

        <div class="w-full lg:w-1/2 text-gray-900 dark:text-white space-y-6 p-6 bg-white dark:bg-gray-800 shadow-lg rounded-md">
            <!-- Foto Profil -->
            <div class="flex w-full h-20 ml-0 lg:ml-32 items-center">
                <p class="font-semibold text-3xl text-gray-500 dark:text-gray-100">Hai, {{ $profile->username }}</p>
            </div>
            
            <!-- Informasi Profil -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h2 class="text-xl font-semibold">Email</h2>
                    <p class="text-lg">{{ $profile->email }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Password</h2>
                    <p class="text-lg">***********</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Role</h2>
                    <p class="text-lg">{{ $profile->role->role_name }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Department</h2>
                    <p class="text-lg">{{ $profile->department->department_name }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Joined</h2>
                    <p class="text-lg">{{ date('d M Y', strtotime($profile->created_at)) }}</p>
                </div>
            </div>
            
            <!-- Bio -->
            <div>
                <h2 class="text-xl font-semibold">Bio</h2>
                <p class="text-lg">{{ $profile->bio ?? 'No bio available' }}</p>
            </div>
        </div>
    </div>


    {{-- Modal Vendor --}}
    <div id="ModalEdit" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 id="labelModalEdit" class="text-lg font-semibold text-gray-900 dark:text-white">Edit Profil</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="ModalEdit">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="formProfile" class="p-3 md:p-4" action="{{ route('profile.edit.action') }}" method="POST">
                    @csrf
                    <div class="grid gap-3 mb-3 grid-cols-1">
                        <input hidden name="modalId" id="ModalEditId" value="">
                        <div class="col-span-2">
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input type="text" name="username" id="username" value="{{ $profile->username }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Username Name">
                        </div>
                        <div class="col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="text" disabled name="email" id="email" value="{{ $profile->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="email">
                        </div>

                        <div class="col-span-2">
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                            <input type="text" disabled value="{{ $profile->role->role_name }}" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Role">
                        </div>
                        <div class="col-span-2">
                            <label for="department" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                            <input type="text" disabled value="{{ $profile->department->department_name }}" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="department">
                        </div>
                        <div class="col-span-2">
                            <label for="bio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description / Bio</label>
                            <textarea id="bio" name="bio" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Write Description / Bio here"></textarea>                    
                        </div>
                    </div>
                    <button type="submit" class="text-white  bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-gray-600 dark:hover:bg-gray-800 dark:focus:ring-gray-800 w-full">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div> 

    {{-- Modal Vendor --}}
    <div id="ModalForgot" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 id="labelModalForgot" class="text-lg font-semibold text-gray-900 dark:text-white">Forgot Password</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="ModalForgot">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="formForgotPassword" class="p-3 md:p-4" action="{{ route('profile.forgot.action') }}" method="POST">
                    @csrf
                    <div class="grid gap-3 mb-3 grid-cols-1">
                        <div class="col-span-2">
                            <label for="passwordOLD" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password old</label>
                            <input type="password" name="passwordOLD" id="passwordOLD" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Old Password">
                        </div>
                        <div class="col-span-2">
                            <label for="newPassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password New</label>
                            <input type="password" name="newPassword" id="newPassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="New Password">
                        </div>
                        <div class="col-span-2">
                            <label for="confirmPassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Confirm</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Confirm Password">
                        </div>
                    </div>
                    <button type="submit" class="text-white  bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-gray-600 dark:hover:bg-gray-800 dark:focus:ring-gray-800 w-full">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div> 

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            await disableSubmitIfNoChanges('formProfile');
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('formProfile').addEventListener('submit', function (e) {
                e.preventDefault(); // Mencegah pengiriman form secara default
                const errors = validateProfileForm();

                if (errors.length > 0) {
                    showAlert('danger', errors);
                } else {
                    this.submit(); // Submit form jika tidak ada error
                }
            });
        });

        function validateProfileForm() {
            const errors = [];

            // Ambil nilai input dan trim whitespace
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const bio = document.getElementById('bio').value.trim();

            // Validasi username
            if (!username) errors.push('Username tidak boleh kosong');

            // Validasi email
            if (!email) {
                errors.push('Email tidak boleh kosong');
            } else if (!validateEmail(email)) {
                errors.push('Format email tidak valid');
            }

            // Validasi bio (maksimal 250 karakter)
            if (bio.length > 250) errors.push('Deskripsi / Bio tidak boleh lebih dari 250 karakter');

            return errors;
        }

        // Fungsi untuk validasi format email
        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('formForgotPassword').addEventListener('submit', function (e) {
                e.preventDefault(); // Mencegah pengiriman form secara default
                const errors = validateForgotPasswordForm();

                if (errors.length > 0) {
                    showAlert('danger', errors);
                } else {
                    this.submit(); // Submit form jika tidak ada error
                }
            });
        });

        function validateForgotPasswordForm() {
            const errors = [];

            // Ambil nilai input dan trim whitespace
            const passwordOLD = document.getElementById('passwordOLD').value.trim();
            const newPassword = document.getElementById('newPassword').value.trim();
            const confirmPassword = document.getElementById('confirmPassword').value.trim();

            // Validasi password lama
            if (!passwordOLD) errors.push('Password lama tidak boleh kosong');

            // Validasi password baru
            if (!newPassword) {
                errors.push('Password baru tidak boleh kosong');
            } else if (newPassword.length < 8) {
                errors.push('Password baru harus minimal 8 karakter');
            }

            // Validasi konfirmasi password
            if (!confirmPassword) {
                errors.push('Konfirmasi password tidak boleh kosong');
            } else if (confirmPassword !== newPassword) {
                errors.push('Konfirmasi password harus sama dengan password baru');
            }

            return errors;
        }


    </script>



</x-layoutdsbd>