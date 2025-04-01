<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <div class="container mx-auto w-full gap-3 flex flex-col">
        <div class="w-full flex gap-3">
            <button id="editProfileButton"
                data-modal-target="ModalEdit" 
                data-modal-toggle="ModalEdit"
                class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Edit Profile
            </button>

            <button id="ForgotButton"
                data-modal-target="ModalForgot"
                data-modal-toggle="ModalForgot"
                class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Forgot Password
            </button>
        </div>

        <div class="w-full lg:w-1/2 border dark:border-0 text-slate-900 dark:text-white space-y-6 p-6 bg-white dark:bg-slate-800 shadow-lg rounded-md">
            <!-- Foto Profil -->
            <div class="flex w-full h-20 ml-0 lg:ml-32 items-center">
                <p class="font-semibold text-3xl text-black dark:text-white">Hai, {{ $profile->username }}</p>
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
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-slate-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-slate-600 border-slate-200">
                    <h3 id="labelModalEdit" class="text-lg font-semibold text-slate-900 dark:text-white">Edit Profil</h3>
                    <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-toggle="ModalEdit">
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
                            <label for="username" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Username</label>
                            <input type="text" name="username" id="username" value="{{ $profile->username }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Username Name">
                        </div>
                        <div class="col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Email</label>
                            <input type="text" disabled id="email" value="{{ $profile->email }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="email">
                        </div>
                        <div class="col-span-2">
                            <label for="role" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Role</label>
                            <input type="text" disabled value="{{ $profile->role->role_name }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Role">
                        </div>
                        <div class="col-span-2">
                            <label for="department" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Department</label>
                            <input type="text" disabled value="{{ $profile->department->department_name }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="department">
                        </div>
                        <div class="col-span-2">
                            <label for="bio" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Description / Bio</label>
                            <textarea id="bio" name="bio" rows="4" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Write Description / Bio here">{{ $profile->bio }}</textarea>                    
                        </div>
                    </div>
                    <button type="submit" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md">
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
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-slate-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-slate-600 border-slate-200">
                    <h3 id="labelModalForgot" class="text-lg font-semibold text-slate-900 dark:text-white">Forgot Password</h3>
                    <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-toggle="ModalForgot">
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
                            <label for="passwordOLD" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Password old</label>
                            <input type="password" name="passwordOLD" id="passwordOLD" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Old Password">
                        </div>
                        <div class="col-span-2">
                            <label for="newPassword" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Password New</label>
                            <input type="password" name="newPassword" id="newPassword" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="New Password">
                        </div>
                        <div class="col-span-2">
                            <label for="confirmPassword" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Password Confirm</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Confirm Password">
                        </div>
                    </div>
                    <button type="submit" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div> 

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('formProfile').addEventListener('submit', function (e) {
                e.preventDefault(); // Mencegah pengiriman form secara default
                const errors = validateProfileForm();
                if (errors.length > 0) showAlert('danger', errors);
                else this.submit();
            });
        });

        function validateProfileForm() {
            const errors = [];
            const username = document.getElementById('username').value.trim();
            const bio = document.getElementById('bio').value.trim();

            if (!username) errors.push('Username tidak boleh kosong');
            if (bio.length > 250) errors.push('Deskripsi / Bio tidak boleh lebih dari 250 karakter');

            return errors;
        }

        

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('formForgotPassword').addEventListener('submit', function (e) {
                e.preventDefault(); // Mencegah pengiriman form secara default
                const errors = validateForgotPasswordForm();
                if (errors.length > 0) showAlert('danger', errors);
                else this.submit();
            });
        });

        function validateForgotPasswordForm() {
            const errors = [];
            const passwordOLD = document.getElementById('passwordOLD').value.trim();
            const newPassword = document.getElementById('newPassword').value.trim();
            const confirmPassword = document.getElementById('confirmPassword').value.trim();

            if (!passwordOLD) errors.push('Password lama tidak boleh kosong');
            if (!newPassword) errors.push('Password baru tidak boleh kosong');
            else if (newPassword.length < 8) errors.push('Password baru harus minimal 8 karakter');
            if (!confirmPassword) errors.push('Konfirmasi password tidak boleh kosong');
            else if (confirmPassword !== newPassword) errors.push('Konfirmasi password harus sama dengan password baru');
            return errors;
        }
    </script>
</x-layoutdsbd>