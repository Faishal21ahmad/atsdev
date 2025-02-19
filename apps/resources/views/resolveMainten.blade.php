

<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    
    
    <x-btnback href="javascript:history.back()" />
   
    <div id="containerInfo" class="container mt-2 w-full  text-gray-900 dark:text-gray-100 grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Informasi Maintenance -->
        <div id="infoMainten" class="">
            <div class="container w-full flex gap-3 text-white">
                {{-- {{ $dataItem }} --}}
                <div class="flex gap-4 justify-between">
                    <!-- Left Section -->
                    <div class="text-gray-900 dark:text-gray-100 ">
                        <div class="flex gap-4">
                            <p id="codeasset" class="text-lg">{{ $dataMainten->itemAsset->code_assets }}</p>
                            <p id="location" class="text-lg">{{ $dataMainten->location->location_name }}</p>
                        </div>
                        <p id="nameasset" class="text-3xl font-semibold">{{ $dataMainten->masterAsset->asset_name }}</p>
                    </div>
                </div>
            </div>
            <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>
        
            <div class="my-2">
                <label class="text-lg font-semibold">Code Maintenance</label>
                <p class="text-md">{{ $dataMainten->code_maintenance }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Date Issue</label>
                <p class="text-md">{{ \Carbon\Carbon::parse($dataMainten->created_at)->format('d / m / Y') }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Type Maintenance</label>
                <p class="text-md">{{ $dataMainten->report_type }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Problem Details</label>
                <p class="text-md">{{ $dataMainten->problem_detail }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Status</label>
                <p class="text-md">{{ $dataMainten->status_mainten }}</p>
            </div>
            <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>

        </div> 
    

        <!-- Gambar -->
        <div id="default-carousel" class="relative w-full hover:cursor-pointer  " data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative  overflow-hidden rounded-lg  lg:h-full h-96">
                @if ($imagesFile != null)
                    @foreach ($imagesFile as $file)
                        <!-- Item 2 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('storage/fileMainten/' . $file->nameFile) }}" class="absolute object-cover h-full w-full -translate-x-1/2 -translate-y-1/2 top-[50%] left-1/2" alt="...">
                        </div>
                    @endforeach
                
                @else
                     <!-- Item 1 -->
                     <div class="duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('storage/Default.jpg') }}" class="absolute object-cover h-full w-full -translate-x-1/2 -translate-y-1/2 top-[50%] left-1/2" alt="...">
                    </div>
                @endif

            </div>
            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                @if ($imagesFile)
                    @foreach ($imagesFile as $file)
                        <button type="button" class="w-3 h-3 rounded-full"  aria-current="{{ $loop->first ? 'true' : 'false' }}"  aria-label="Slide {{ $loop->iteration }}" data-carousel-slide-to="{{ $loop->iteration }}"></button>
                    @endforeach
                @endif
            </div>
         

            <!-- Slider controls -->
            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
            @if ($imagesFile != null)
                <div class="group">
                    <div class="absolute inset-0 bg-slate-400 z-30 w-[70%] mx-auto opacity-0 h-10">
                    </div>
                
                    <!-- Modal toggle (Tersembunyi secara default) -->
                    <button data-modal-target="default-modal-11" data-modal-toggle="default-modal-11"
                        class="absolute z-30 inset-0 mx-auto w-[70%] opacity-0 group-hover:opacity-70 transition-opacity duration-300 text-white bg-gray-700 hover:bg-gray-800 font-medium rounded-lg text-sm text-center dark:bg-gray-600 dark:hover:bg-gray-700 "
                        type="button">
                        Open
                    </button>
                </div>
            @endif

            
            
        </div>
    </div>




    <form id="formResolveMainten" action="{{ route('mainten.resolve.action') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input hidden id="idcodeMaintence" name="idcodeMaintence" value="{{ $dataMainten->id }}">
        <input hidden id="codeMaintence" name="codeMaintence" value="{{ $dataMainten->code_maintenance }}">
        <input hidden id="itemAsset" name="itemAsset" value="{{ $dataMainten->itemAsset->id }}">
        <input hidden id="codeitemAsset" name="codeitemAsset" value="{{ $dataMainten->itemAsset->code_assets }}">
        
        <div class="mt-3">
            <label for="repairDetail" class="block mb-2 mt-5 text-lg font-medium text-gray-900 dark:text-white">Repair Details</label>
            <textarea id="repairDetail" 
                    name="repairDetail"
                    rows="4"
                    class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-md border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" 
                    placeholder="ex: Exploding components emit smoke and sparks"></textarea>
        </div>

        <div class="mt-3">
            <label for="vendor" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Vendor</label>
            <select id="vendor" name="vendor" class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-md focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                <option selected value="">select</option>
                @foreach ($vendors as $item)
                <option value="{{ $item->id }}">{{ $item->vendor_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-3">
            <label for="cost" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Cost</label>
            <input type="number" name="cost"  id="cost" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-gray-500 focus:border-gray-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
        </div>

        <div class="mt-3">
            <span class="block text-lg font-medium text-gray-900 dark:text-white">Repare Upload</span>
            <div class="flex items-center mt-3 justify-center w-full">
                <label for="fileReport" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 transition overflow-hidden">
                    <div id="contentUpload" class="justify-center pt-5 pb-6">
                        {{-- stste (file selected) --}}
                        <div id="fileON" class=" gap-2 hidden">
                            <div id="cardimg1" class="flex flex-col gap-2 p-2 items-center">
                                <div id="box1" class="border-4 border-slate-400 text-lg text-gray-900 dark:text-slate-200 rounded-md dark:bg-gray-700">img
                                </div>
                                <p class="text-gray-900 dark:text-slate-200 whitespace-nowrap max-w-[10ch] truncate"> file1.png </p>
                            </div>
                        </div>
                        
                        <!-- Default state (no file selected) -->
                        <div id="fileOFF" class="flex flex-col items-center">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M8.5,5c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5Zm7.32,3.18l-.35-1.42c-.11-.44-.51-.76-.97-.76s-.86,.31-.97,.76l-.35,1.41-1.4,.32c-.45,.1-.77,.5-.77,.96,0,.46,.3,.86,.74,.98l1.43,.39,.36,1.43c.11,.44,.51,.76,.97,.76s.86-.31,.97-.76l.35-1.42,1.42-.35c.44-.11,.76-.51,.76-.97s-.31-.86-.76-.97l-1.42-.35Zm.79-3.3l1.76,.74,.7,1.75c.15,.38,.52,.63,.93,.63s.78-.25,.93-.63l.7-1.74,1.74-.7c.38-.15,.63-.52,.63-.93s-.25-.78-.63-.93l-1.74-.7-.7-1.74c-.15-.38-.52-.63-.93-.63s-.78,.25-.93,.63l-.69,1.73-1.73,.66c-.38,.14-.64,.51-.65,.92,0,.41,.23,.78,.61,.94Zm7.39,4.12v10c0,2.76-2.24,5-5,5H5c-2.76,0-5-2.24-5-5V5C0,2.24,2.24,0,5,0H15c.55,0,1,.45,1,1s-.45,1-1,1H5c-1.65,0-3,1.35-3,3v6.59l.56-.56c1.34-1.34,3.53-1.34,4.88,0l5.58,5.58c.54,.54,1.43,.54,1.97,0l.58-.58c1.34-1.34,3.53-1.34,4.88,0l1.56,1.56V9c0-.55,.45-1,1-1s1,.45,1,1Zm-2.24,11.17l-2.74-2.74c-.56-.56-1.48-.56-2.05,0l-.58,.58c-1.32,1.32-3.48,1.32-4.8,0l-5.58-5.58c-.56-.56-1.48-.56-2.05,0l-1.98,1.98v4.59c0,1.65,1.35,3,3,3h14c1.24,0,2.3-.75,2.76-1.83Z" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or
                                drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                    </div>
                    <input id="fileReport" name="fileReport[]" type="file" class="hidden" multiple/>
                </label>
            </div>
        </div>

        <div class="mt-3">
            <label for="statusResolve" class="block text-lg font-medium text-gray-900 dark:text-white">Repair Result</label>
            <ul class="grid lg:w-2/4 gap-4 md:grid-cols-2">
                <li>
                    <input type="radio" id="Finish" name="statusResolve" value="Finish" class="hidden peer"/>
                    <label id="statusResolve" for="Finish" class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-gray-200 peer-checked:text-gray-900 peer-checked:border-gray-500
                    dark:peer-checked:bg-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-800
                    hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-0">                           
                        <div class="block">
                            <div class="w-full text-lg font-semibold">Finish</div>
                        </div>
                        <svg id="iconChecked-Finish" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 507.506 507.506" class="w-5 h-5 ms-3 rtl:rotate-180 hidden" fill="currentColor">
                            <g>
                                <path stroke="currentColor" d="M163.865,436.934c-14.406,0.006-28.222-5.72-38.4-15.915L9.369,304.966c-12.492-12.496-12.492-32.752,0-45.248l0,0   c12.496-12.492,32.752-12.492,45.248,0l109.248,109.248L452.889,79.942c12.496-12.492,32.752-12.492,45.248,0l0,0   c12.492,12.496,12.492,32.752,0,45.248L202.265,421.019C192.087,431.214,178.271,436.94,163.865,436.934z"/>
                            </g>
                        </svg>
                    </label>
                </li>
                <li>
                    <input type="radio" id="Damaged" name="statusResolve" value="Damaged" class="hidden peer">
                    <label id="statusResolve" for="Damaged" class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-gray-200 peer-checked:text-gray-900 peer-checked:border-gray-500
                    dark:peer-checked:bg-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-800
                    hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-0">
                        <div class="block">
                            <div class="w-full text-lg font-semibold">Damaged</div>
                        </div>
                        <svg id="iconChecked-Damaged" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 507.506 507.506" class="w-5 h-5 ms-3 rtl:rotate-180 hidden" fill="currentColor">
                            <g>
                                <path stroke="currentColor" d="M163.865,436.934c-14.406,0.006-28.222-5.72-38.4-15.915L9.369,304.966c-12.492-12.496-12.492-32.752,0-45.248l0,0   
                                    c12.496-12.492,32.752-12.492,45.248,0l109.248,109.248L452.889,79.942c12.496-12.492,32.752-12.492,45.248,0l0,0   
                                    c12.492,12.496,12.492,32.752,0,45.248L202.265,421.019C192.087,431.214,178.271,436.94,163.865,436.934z"/>
                            </g>
                        </svg>
                    </label>
                </li>
                
            </ul>
        </div>

        <br>
        <button type="submit" class="py-1 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">Finish</button>
    </form>


    @if ($imagesFile != null)
        <!-- Main modal -->
        <div id="default-modal-11" data-modal-id="11" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] ">
            <div class="relative p-4 w-full max-w-[85%] mx-auto max-h-full">
                
                <!-- Modal content -->
                <div class="relative w-full bg-white rounded-lg shadow-sm dark:bg-gray-700">

                    <!-- Modal header -->
                    <div class="flex items-center justify-between py-2 px-3 md:px-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Image Documents
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal-11">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="relative py-2 px-3 md:px-5 flex space-y-4 ">
                        <div id="indicators-carousel-11" class="relative w-full" data-carousel="static">
                            <!-- Carousel wrapper -->
                            <div class="relative h-[700px] overflow-hidden rounded-lg">
                                @if ($imagesFile == null)
                                    <!-- Item 1 -->
                                    <div class="duration-700 ease-in-out" data-carousel-item>
                                        <img src="{{ asset('storage/Default.jpg') }}" class="absolute object-cover h-full w-full -translate-x-1/2 -translate-y-1/2 top-[50%] left-1/2" alt="...">
                                    </div>
                                @else
                                    @foreach ($imagesFile as $index => $file)
                                        <!-- Item -->
                                        <div class="hidden duration-700 ease-in-out" data-carousel-item data-index="{{ $index }}">
                                            <img src="{{ asset('storage/fileMainten/' . $file->nameFile) }}" class="absolute object-cover h-full w-full -translate-x-1/2 -translate-y-1/2 top-[50%] left-1/2" alt="...">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <!-- Slider controls -->
                            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Slider indicators via all list img -->
                    <div id="indicators_imageList-11" class=" w-full flex z-60 py-2 px-3 md:px-5">
                        <div class="flex w-full  mx-auto gap-2 rounded-lg">
                            @if ($imagesFile == null)
                                <!-- Item 1 -->
                                <div class="rounded-md object-cover cursor-pointer" data-carousel-item>
                                    <img src="{{ asset('storage/fileMainten/Default.jpg') }}" class="absolute object-cover w-full -translate-x-1/2 -translate-y-1/2 top-[50%] left-1/2" alt="...">
                                </div>
                            @else
                                @foreach ($imagesFile as $index => $file)
                                    <div class="rounded-md object-cover cursor-pointer pb-3 " data-indicator-index="{{ $index }}" data-modal-id="11">
                                        <img src="{{ asset('storage/fileMainten/'.  $file->nameFile) }}" class="border rounded-md object-cover h-24 " alt="...">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const radioButtons = document.querySelectorAll('input[name="statusResolve"]');

            radioButtons.forEach((radio) => {
                radio.addEventListener("change", function () {
                    // Sembunyikan semua ikon
                    document.querySelectorAll('[id^="iconChecked"]').forEach((icon) => {
                        icon.classList.add("hidden");
                    });

                    // Tampilkan ikon yang sesuai dengan radio yang dipilih
                    const selectedIcon = document.querySelector(`#iconChecked-${this.id}`);
                    if (selectedIcon) {
                        selectedIcon.classList.remove("hidden");
                    }
                });
            });
        });



    // Fungsi untuk validasi client-side
    function validateForm() {
        const codeMaintence = document.getElementById('codeMaintence').value.trim();
        const itemAsset = document.getElementById('itemAsset').value.trim();
        const repairDetail = document.getElementById('repairDetail').value.trim();
        const vendor = document.getElementById('vendor').value.trim();
        const cost = document.getElementById('cost').value.trim();
        const statusResolve = document.querySelectorAll('input[name="statusResolve"]');
        const fileReport = document.getElementById('fileReport').files;

        const errors = [];

        // Validasi file jika ada
        if (fileReport.length > 0) {
            const allowedExtensions = ['pdf','png', 'jpg', 'jpeg'];
            
            for (let i = 0; i < fileReport.length; i++) {
                const file = fileReport[i]; // Ambil file ke-i
                const fileSize = file.size;
                const fileExt = file.name.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExt)) {
                    errors.push(`Format file "${file.name}" harus berupa PNG, JPG, atau JPEG`);
                }

                if (fileSize > 2 * 1024 * 1024) { // 2MB dalam bytes
                    errors.push(`Ukuran file "${file.name}" terlalu besar (maks. 2 MB)`);
                }
            }
        }


        // Cek apakah ada radio button yang dipilih
        let isstatusResolveChecked = false;
        statusResolve.forEach(radio => {
            if (radio.checked) {
                isstatusResolveChecked = true;
            }
        });

        if (!isstatusResolveChecked) {
            errors.push('Repair Result tidak boleh kosong');
        }

        if (codeMaintence === '') {
            errors.push('codeMaintence tidak boleh kosong');
        }

        if (itemAsset === '') {
            errors.push('Item Asset tidak boleh kosong');
        }

        if (repairDetail === '') {
            errors.push('Detail Repair tidak boleh kosong');
        }

        if (vendor === '') {
            errors.push('Vendor tidak boleh kosong');
        }

        if (cost === '') {
            errors.push('Cost tidak boleh kosong');
        } else if (!/^\d+$/.test(cost)) {
            errors.push('Cost hanya boleh berisi angka');
        }

        return errors;
    }

        // Event listener untuk form submission
        document.getElementById('formResolveMainten').addEventListener('submit', function (e) {
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


        document.addEventListener("DOMContentLoaded", function () {
            const fileInput = document.getElementById("fileReport");
            const contentUpload = document.getElementById("contentUpload");
            const fileON = document.getElementById("fileON");
            const fileOFF = document.getElementById("fileOFF");
            const cardImgContainer = fileON; // Tempat untuk menampilkan gambar

            fileInput.addEventListener("change", function () {
                const files = fileInput.files;

                // Hapus semua elemen sebelumnya
                cardImgContainer.innerHTML = "";

                if (files.length > 0) {
                    fileOFF.style.display = "none"; // Sembunyikan jika ada file
                    fileON.style.display = "flex"; // Tampilkan area file
                    
                    Array.from(files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const card = document.createElement("div");
                            card.className = "flex flex-col gap-2 p-2 items-center";
                            card.innerHTML = `
                                <div class="border-4 border-slate-400 text-lg text-gray-900 dark:text-slate-200 rounded-md  dark:bg-gray-700">
                                    <img src="${e.target.result}" class="w-16 h-20 object-cover"/>
                                </div>
                                <p class="text-gray-900 dark:text-slate-200 whitespace-nowrap max-w-[10ch] truncate">${file.name}</p>
                            `;
                            cardImgContainer.appendChild(card);
                        };
                        reader.readAsDataURL(file);
                    });
                } else {
                    fileOFF.style.display = "flex"; // Tampilkan kembali jika tidak ada file
                    fileON.style.display = "none"; // Sembunyikan area file
                }
            });
        });

        // document.addEventListener("DOMContentLoaded", function () {
        //     const modal = document.getElementById("imageModal");
        //     const openModalBtn = document.getElementById("openModalBtn");
        //     const closeModalBtn = document.getElementById("closeModalBtn");

        //     // Buka Modal
        //     openModalBtn.addEventListener("click", function () {
        //         modal.classList.remove("hidden");
        //     });

        //     // Tutup Modal
        //     closeModalBtn.addEventListener("click", function () {
        //         modal.classList.add("hidden");
        //     });

        //     // Carousel dalam Modal
        //     let slides = document.querySelectorAll(".carousel-slide");
        //     let currentIndex = 0;

        //     function showSlide(index) {
        //         slides.forEach((slide, i) => {
        //             slide.classList.toggle("hidden", i !== index);
        //         });
        //     }

        //     document.getElementById("prevSlide").addEventListener("click", function () {
        //         currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        //         showSlide(currentIndex);
        //     });

        //     document.getElementById("nextSlide").addEventListener("click", function () {
        //         currentIndex = (currentIndex + 1) % slides.length;
        //         showSlide(currentIndex);
        //     });

        //     // Tampilkan slide pertama
        //     showSlide(currentIndex);
        // });


    </script>
</x-layoutdsbd>