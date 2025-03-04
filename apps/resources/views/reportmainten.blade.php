<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />
    
    <div class="container mx-auto w-full mt-5 text-gray-900 dark:text-gray-100">
        <div class="w-3/4">
            <div class="flex gap-4">
                <p id="codeasset" class="text-lg">{{ $ItemAsset->code_assets }}</p>
                <p id="location" class="text-lg">{{ $ItemAsset->location->location_name ?? 'location Unknown'  }}</p>
            </div>
            <p id="nameasset" class="text-3xl font-semibold">{{ $ItemAsset->masterAsset->asset_name }}</p>
        </div>
        {{-- {{ $ItemAsset }} --}}
    </div>
    <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>

    <div class="container mx-auto w-full">
        <form id="reportMainten" action="{{ route('mainten.report.action') }}" method="POST" class="flex flex-col gap-4" enctype="multipart/form-data">
            @csrf
            <input type="text" hidden id="codeAsset" name="codeAsset" value="{{ $ItemAsset->code_assets }}">
            <input type="text" hidden id="itemAsset" name="itemAsset" value="{{ $ItemAsset->id }}">
            <input type="text" hidden id="masterAsset" name="masterAsset" value="{{ $ItemAsset->master_asset_id }}">
            <input type="text" hidden id="location" name="location" value="{{ $ItemAsset->location_id  }}">
            <input type="text" hidden id="statusMainten" name="statusMainten" value="Reported">

            <label for="problemDetail" class="block text-lg font-medium text-gray-900 dark:text-white">Problem Details</label>
            <textarea id="problemDetail" 
                        name="problemDetail"
                        rows="4" 
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" 
                        placeholder="ex: Exploding components emit smoke and sparks"></textarea>

            <span class="block text-lg font-medium text-gray-900 dark:text-white">Image Upload</span>
            <div class="flex items-center justify-center w-full">
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

            <label for="reportType" class="block text-lg font-medium text-gray-900 dark:text-white">Report Type</label>
            <ul class="grid lg:w-2/4 gap-4 md:grid-cols-2">
                <li>
                    <input type="radio" id="Repair" name="reportType" value="Repair" class="hidden peer"/>
                    <label id="reportType" for="Repair" class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-gray-200 peer-checked:text-gray-900 peer-checked:border-gray-500
                    dark:peer-checked:bg-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-800
                    hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-0">                           
                        <div class="block">
                            <div class="w-full text-lg font-semibold">Repair</div>
                        </div>
                        <svg id="iconChecked-Repair" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 507.506 507.506" class="w-5 h-5 ms-3 rtl:rotate-180 hidden" fill="currentColor">
                            <g>
                                <path stroke="currentColor" d="M163.865,436.934c-14.406,0.006-28.222-5.72-38.4-15.915L9.369,304.966c-12.492-12.496-12.492-32.752,0-45.248l0,0   c12.496-12.492,32.752-12.492,45.248,0l109.248,109.248L452.889,79.942c12.496-12.492,32.752-12.492,45.248,0l0,0   c12.492,12.496,12.492,32.752,0,45.248L202.265,421.019C192.087,431.214,178.271,436.94,163.865,436.934z"/>
                            </g>
                        </svg>
                    </label>
                </li>
                <li>
                    <input type="radio" id="Maintenance" name="reportType" value="Maintenance" class="hidden peer">
                    <label id="reportType" for="Maintenance" class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-gray-200 peer-checked:text-gray-900 peer-checked:border-gray-500
                    dark:peer-checked:bg-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-800
                    hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-0">
                        <div class="block">
                            <div class="w-full text-lg font-semibold">Maintenance</div>
                        </div>
                        <svg id="iconChecked-Maintenance" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 507.506 507.506" class="w-5 h-5 ms-3 rtl:rotate-180 hidden" fill="currentColor">
                            <g>
                                <path stroke="currentColor" d="M163.865,436.934c-14.406,0.006-28.222-5.72-38.4-15.915L9.369,304.966c-12.492-12.496-12.492-32.752,0-45.248l0,0   
                                    c12.496-12.492,32.752-12.492,45.248,0l109.248,109.248L452.889,79.942c12.496-12.492,32.752-12.492,45.248,0l0,0   
                                    c12.492,12.496,12.492,32.752,0,45.248L202.265,421.019C192.087,431.214,178.271,436.94,163.865,436.934z"/>
                            </g>
                        </svg>
                    </label>
                </li>
                
            </ul>
            <button type="submit" class="w-32 py-2 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">Report</button>
        </form>
    </div>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const radioButtons = document.querySelectorAll('input[name="reportType"]');

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


        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('reportMainten').addEventListener('submit', function(e) {
                e.preventDefault();
                const errors = validateForm();

                if (errors.length > 0) {
                    showAlert('danger', errors);
                } else {
                    this.submit();
                }
            });
        });

        function validateForm() {
            const errors = [];

            // Ambil nilai input
            const itemAsset = document.getElementById('itemAsset').value;
            const codeAsset = document.getElementById('codeAsset').value;
            const masterAsset = document.getElementById('masterAsset').value;
            const location = document.getElementById('location').value;
            const statusMainten = document.getElementById('statusMainten').value;
            const problemDetail = document.getElementById('problemDetail').value;
            const reportTypeRadios = document.querySelectorAll('input[name="reportType"]');

            // Validasi
            if (!itemAsset) errors.push('Item Asset tidak boleh kosong');
            if (!codeAsset) errors.push('Code Asset tidak boleh kosong');
            if (!masterAsset) errors.push('Master Asset tidak boleh kosong');
            if (!location) errors.push('Location Asset belum di atur');
            if (!statusMainten) errors.push('Status Maintenance tidak boleh kosong');
            if (!problemDetail) errors.push('Problem Detail tidak boleh kosong');

            // Validasi radio button
            const isReportTypeChecked = [...reportTypeRadios].some(radio => radio.checked);
            if (!isReportTypeChecked) errors.push('Tipe Report tidak boleh kosong');

            return errors;
        }
    </script>

</x-layoutdsbd>