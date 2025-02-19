<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    
    
    <div class="flex gap-4 justify-between">
        <x-btnback href="{{ route('asset') }}" /> 
        <div class="h-full">
            <button id="updateMasterAssetButton" data-modal-target="updateMasterAssetModal" data-modal-toggle="updateMasterAssetModal"  class="px-8 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">EDIT</button>
        </div>
    </div>

    <div class="container mx-auto w-full mt-5">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 items-start">
            <!-- Kotak 1 (Info) -->
            <div class="order-1 md:order-1 lg:order-1">
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $assetMaster->asset_name }}</h1>
                <p class="text-xl text-gray-600 dark:text-gray-200">Mainten Interval : {{ $assetMaster->interval_maintence ?? '-' }} M</p>
                <p class="text-xl text-gray-600 dark:text-gray-200">Stock Minimum : {{ $assetMaster->min_stock ?? '-' }}</p>
                <p class="text-xl text-gray-600 dark:text-gray-200">Stock Currrent : {{ $assetMaster->current_stock ?? '-' }}</p>
                <p class="text-xl text-gray-600 dark:text-gray-200">Category : {{ $assetMaster->category->category_name ?? '-' }}</p>
            </div>
        
            <!-- Kotak 2 (Deskripsi) -->
            <div class="order-2 md:order-2 lg:order-2">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Deskripsi</h1>
                <div class="h-56 text-gray-600 dark:text-gray-200 overflow-y-auto rounded-md
                    scrollbar-thin scrollbar-thumb-rounded-full 
                    scrollbar-thumb-slate-300 scrollbar-track-slate-100 
                    dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500">
                    <p>{{ $assetMaster->description }}</p>
                </div>
            </div>
        
            <!-- Kotak 3 (Gambar) -->
            <div class="relative order-3 md:col-span-2 md:order-3 lg:order-3 lg:col-span-1 ">
                <div class="relative h-60 bg-gray-200 flex rounded-md overflow-hidden">
                    @if ($assetMaster->image_name != null)
                        <div class="justify-center">
                            <img src="{{ asset('storage/fileMasterAsset/'.$assetMaster->image_name) }}" alt="" class="absolute object-cover h-full w-full">
                        </div>
                        
                    @else
                        <div class="justify-center">
                            <img src="{{ asset('storage/Default.jpg') }}" alt="" class="absolute object-cover h-full w-full">
                        </div>
                    @endif
                    {{-- <img src="{{ asset('storage/Default.jpg') }}" alt="" class="object-cover h-full w-full"> --}}
                    
                </div>
                @if ($assetMaster->image_name != null)
                    <div class="group">
                        <div class="absolute w-full h-full top-0">
                        
                        </div>
                        <button data-modal-target="modal_imgMasterAsset" data-modal-toggle="modal_imgMasterAsset"
                                class="absolute z-30 inset-0 mx-auto w-100 opacity-0 group-hover:opacity-70 transition-opacity duration-300 text-white bg-gray-700 hover:bg-gray-800 font-medium rounded-lg text-sm text-center dark:bg-gray-600 dark:hover:bg-gray-700 "
                                type="button">
                                Open
                        </button>
                    </div>
                @endif

            </div>
        </div>
        
    </div>
<br><br><div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>

    <!-- Asset List -->
    <div class="container mx-auto w-full">
        <div class="w-full flex justify-between mb-2">
            <h1 class="text-xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Asset</h1>
            <button class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Add Asset</button>
        </div>
    
        <div class="w-full overflow-x-auto
            scrollbar-thin
            scrollbar-thumb-rounded-full 
            scrollbar-thumb-slate-300 
            scrollbar-track-slate-100 
            dark:scrollbar-thumb-slate-300 
            dark:scrollbar-track-slate-500
            scrollbar-thumb-rounded-full 
            scrollbar-track-rounded-full
        ">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 rounded-md">
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">No</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Code Asset</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Location</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Condition</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Description</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Status</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataItemByAms as $item)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="p-2 text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                            <td class="p-2 text-gray-800 dark:text-gray-200">{{ $item->code_assets }}</td>
                            <td class="p-2 text-gray-800 dark:text-gray-200">{{ $item->location->location_name ?? 'Unknown' }}</td>
                            <td class="p-2 text-gray-800 dark:text-gray-200">{{ $item->condition ?? 'N/A' }}</td>
                            <td class="p-2 text-gray-800 dark:text-gray-200">{{ $item->description ?? '-' }}</td>
                            <td class="p-2 text-gray-800 dark:text-gray-200">
                                <span class="px-3 py-1 rounded-md text-white text-sm 
                                    {{ $item->status == 'Available' ? 'bg-green-500' : 
                                       ($item->status == 'Maintenance' ? 'bg-yellow-500' : 
                                       ($item->status == 'Damaged' ? 'bg-red-500' : 'bg-blue-500')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                            <td class="p-2">
                                <a href="{{ route('itemAsset', $item->code_assets ) }}" class="py-1 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


{{-- ============================================== --}}

<div class="container mx-auto w-full mt-5">
    {{-- {{ $location }} --}}

    <!-- Main modal -->
    <div id="updateMasterAssetModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-3 mb-3 border-b rounded-t sm:mb-3 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Update Master Asset
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateMasterAssetModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="text-white mb-5">
                    <h1 class="text-3xl font-semibold">{{ $assetMaster->asset_name }}</h1>

                </div>
                <form id="editItemAsset" action="{{ route('masterAsset.edit.action') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <input id="slug" hidden type="text" name="slug" value="{{ $assetMaster->slug }}">
                        <input id="fileOld" hidden type="text" name="fileOld" value="{{ $assetMaster->image_name }}">
                        <div>
                            <label for="nameAsset" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name Asset</label>
                            <input type="text" name="nameAsset" id="nameAsset" value="{{ $assetMaster->asset_name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="name asset">
                        </div>
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                            <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                <option selected="" value="{{ $assetMaster->category_id ?? '-' }}">{{ $assetMaster->category->category_name ?? 'Selecte Category' }}</option>
                                @foreach($dataCategory as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="maintenInterval" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mainten Interval</label>
                            <input type="text" name="maintenInterval" id="maintenInterval" value="{{ $assetMaster->interval_maintence }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Mont">
                        </div>
                        <div>
                            <label for="stockMinimum" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Minimum Stock</label>
                            <input type="text" name="stockMinimum" id="stockMinimum" value="{{ $assetMaster->interval_maintence }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Mont">
                        </div>
                        
                        <div class="sm:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="fileImg">Upload Image Asset</label>
                            <input id="fileImg" name="fileImg" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="fileImg_help" id="fileImg" type="file">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="fileImg_help">SVG, PNG, JPG (MAX. 800x400px).</p>
                        </div>
                        
                    
                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea id="description" name="description" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Write a description...">{{ $assetMaster->description }}</textarea>                    
                        </div>
                       
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            Update
                        </button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>





    @if ($assetMaster->image_name != null)
    <!-- Main modal -->
    <div id="modal_imgMasterAsset" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-[85%] max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Detail Foto
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal_imgMasterAsset">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-3 md:p-4 space-y-4">
                    @if ($assetMaster->image_name != null)

                        <img src="{{ asset('storage/fileMasterAsset/'.$assetMaster->image_name) }}" alt="" class=" object-cover h-full w-full">
                    @endif
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-3 md:p-4 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="modal_imgMasterAsset" type="button" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Close</button>
                   
                </div>
            </div>
        </div>
    </div>
    @endif

</div>



<script>

    // Fungsi untuk validasi client-side
    function validateForm() {
        const slug = document.getElementById('slug').value;
        
        const nameAsset = document.getElementById('nameAsset').value;
        const category = document.getElementById('category').value;
        const maintenInterval = document.getElementById('maintenInterval').value;
        const stockMinimum = document.getElementById('stockMinimum').value;
        const description = document.getElementById('description').value;
        const fileImg = document.getElementById('fileImg').files;
        

        const errors = [];

        if (slug === '') {
            errors.push('Slug tidak boleh kosong');
        }

     

        if (nameAsset === '') {
            errors.push('Name Asset tidak boleh kosong');
        }
        
        if (category === '') {
            errors.push('Category tidak boleh kosong');
        }

        if (maintenInterval === '') {
            errors.push('Mainten Interval tidak boleh kosong');
        } else if (!/^\d+$/.test(maintenInterval)) {
            errors.push('Mainten Interval hanya boleh berisi angka');
        }

        if (stockMinimum === '') {
            errors.push('Stock Minimum tidak boleh kosong');
        } else if (!/^\d+$/.test(stockMinimum)) {
            errors.push('Stock Minimum hanya boleh berisi angka');
        }

        if (description === '') {
            errors.push('Description tidak boleh kosong');
        }

        // Validasi file jika ada
        if (fileImg.length > 0) {
            const allowedExtensions = ['png', 'jpg', 'jpeg'];
            const file = fileImg[0]; // Ambil file pertama
            const fileSize = file.size;
            const fileExt = file.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(fileExt)) {
                errors.push('Format file harus berupa PDF, PNG, JPG, atau JPEG');
            }

            if (fileSize > 2 * 1024 * 1024) { // 2MB dalam bytes
                errors.push('Ukuran file terlalu besar (maks. 2 MB)');
            }
        }



        return errors;
    }

    // Event listener untuk form submission
    document.getElementById('editItemAsset').addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah form di-submit secara default
        // Validasi client-side
        const errors = validateForm();

        if (errors.length > 0) {
            // showErrors(errors);
            showAlert('danger', errors);
        }  else {
            // Jika tidak ada error, submit form secara manual
            this.submit();
        }
    });

</script>



</x-layoutdsbd>