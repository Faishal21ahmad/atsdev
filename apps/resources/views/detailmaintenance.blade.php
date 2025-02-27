<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />
    {{-- Main Content --}}  
    <div class="container w-full mt-3 grid grid-cols-1 lg:grid-cols-2 gap-3">
        {{-- Informati Content --}}
        <div class="container mx-auto text-gray-900 dark:text-gray-100">
            {{-- {{ $mainten }} --}}
            <div class="md:flex gap-4 justify-between">
                <!-- Left Section -->
                <div class="w-3/4">
                    <div class="flex gap-4">
                        <p id="codeasset" class="text-lg">{{ $mainten->itemAsset->code_assets }}</p>
                        <p id="location" class="text-lg">{{ $mainten->location->location_name  }}</p>
                    </div>
                    <p id="nameasset" class="text-3xl font-semibold">{{ $mainten->masterAsset->asset_name }}</p>
                </div>
            </div>
            <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>
            <div class="my-2">
                <label class="text-lg font-semibold">Code Maintenance</label>
                <p class="text-md">{{ $mainten->code_maintenance }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Date Issue</label>
                <p class="text-md">{{ \Carbon\Carbon::parse($mainten->created_at)->format('d / m / Y') }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Type Maintenance </label>
                <p class="text-md">{{ $mainten->report_type }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Problem Details</label>
                <p class="text-md">{{ $mainten->problem_detail }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Repaire Details</label>
                <p class="text-md">
                    @if ($mainten->repaire_detail != null)
                        {{ $mainten->repaire_detail }}
                    @else
                    -
                    @endif
                </p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Date Maintenance</label>
                <p class="text-md">{{ $mainten->date_mainten }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Status</label>
                <p class="text-md">{{ $mainten->status_mainten }}</p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Vendor</label>
                <p class="text-md">
                    @if ($mainten->vendor_id != null)
                        {{ $mainten->vendor->vendor_name ?? '-' }}
                    @else
                        -
                    @endif
                        
                </p>
            </div>
            <div class="my-2">
                <label class="text-lg font-semibold">Cost</label>
                <p class="text-md">Rp. {{ number_format($mainten->cost)}}</p>
            </div>

            <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>

        </div>
        
            {{-- image --}}
            <div id="img" class="relative w-full space-y-3">
                <p class="text-xl font-semibold text-gray-800 dark:text-white">Image Problem</p>
                <div class="relative space-y-3">
                    <div id="imageProblem" class="bg-slate-300 w-full h-[300px] relative  overflow-hidden rounded-lg">
                        @if (!empty($fileProblem) && $fileProblem->isNotEmpty())
                            @foreach ($fileProblem as $problem)
                                <div class="justify-center">
                                    <img src="{{ asset('storage/fileMainten/'.$problem->nameFile) }}" alt="" class="absolute object-cover h-full w-full -translate-x-1/2 -translate-y-1/2 top-[50%] left-1/2">
                                </div>
                            @endforeach
                        @else
                            <div class="justify-center">
                                <img src="{{ asset('storage/Default.jpg') }}" alt="" class="absolute object-cover h-full w-full -translate-x-1/2 -translate-y-1/2 top-[50%] left-1/2">
                            </div>
                        @endif
                    </div>
                    @if (!empty($fileProblem) && $fileProblem->isNotEmpty())
                        <div class="group">
                            <div class="absolute w-full h-full top-0">
                            
                            </div>
                            <button data-modal-target="modalFileProblem" data-modal-toggle="modalFileProblem"
                                    class="absolute z-30 inset-0 mx-auto w-100 opacity-0 group-hover:opacity-70 transition-opacity duration-300 text-white bg-gray-700 hover:bg-gray-800 font-medium rounded-lg text-sm text-center dark:bg-gray-600 dark:hover:bg-gray-700 "
                                    type="button">
                                    Open
                            </button>
                        </div>
                    @endif
                </div>
                <p class="text-xl font-semibold text-gray-800 dark:text-white">Image Repaire</p>
                <div class="relative space-y-3">
                    <div id="imageRepaire" class="bg-slate-300 w-full h-[300px] relative  overflow-hidden rounded-lg">
                        @if (!empty($fileRepaire) && $fileRepaire->isNotEmpty())
                            @foreach ($fileRepaire as $repaire)
                                <div class="justify-center">
                                    <img src="{{ asset('storage/fileMainten/'.$repaire->nameFile) }}" alt="" class="absolute object-cover h-full w-full -translate-x-1/2 -translate-y-1/2 top-[50%] left-1/2">
                                </div>
                            @endforeach
                        @else
                            <div class="justify-center">
                                <img src="{{ asset('storage/Default.jpg') }}" alt="" class="absolute object-cover h-full w-full -translate-x-1/2 -translate-y-1/2 top-[50%] left-1/2">
                            </div>
                        @endif
                    </div>
                    @if (!empty($fileRepaire) && $fileRepaire->isNotEmpty())
                        <div class="group">
                            <div class="absolute w-full h-full top-0">
                            
                            </div>
                            <button data-modal-target="modalFileRepaire" data-modal-toggle="modalFileRepaire"
                                    class="absolute z-30 inset-0 mx-auto w-100 opacity-0 group-hover:opacity-70 transition-opacity duration-300 text-white bg-gray-700 hover:bg-gray-800 font-medium rounded-lg text-sm text-center dark:bg-gray-600 dark:hover:bg-gray-700 "
                                    type="button">
                                    Open
                            </button>
                        </div>
                    @endif
                </div>
            </div>
    </div>

    

    @if (!empty($fileProblem) && $fileProblem->isNotEmpty())
        <div id="modalFileProblem" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full  lg:max-w-[85%] max-w-[99%] max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Detail Foto
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalFileProblem">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body dengan carousel -->
                    <div class="p-3 md:p-4">
                        <div id="carousel" class="relative w-full" data-carousel="slide">
                            <div class="relative  md:h-[700px] h-[400px] flex items-center justify-center overflow-hidden rounded-lg">
                                @foreach ($fileProblem as $index => $pbm)
                                    <div class="absolute inset-0 transition-opacity duration-700 ease-in-out rounded-lg" data-carousel-item>
                                        <img src="{{ asset('storage/fileMainten/'.$pbm->nameFile) }}" class="lg:object-cover object-contain transition-opacity duration-700 h-full w-full rounded-lg">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Tombol navigasi -->
                            <button type="button" class="absolute top-1/2 left-2 z-30 flex items-center justify-center w-10 h-10 bg-gray-800/30 rounded-full hover:bg-gray-800/50" data-carousel-prev>
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button type="button" class="absolute top-1/2 right-2 z-30 flex items-center justify-center w-10 h-10 bg-gray-800/30 rounded-full hover:bg-gray-800/50" data-carousel-next>
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-3 md:p-4 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="modalFileProblem" type="button" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if (!empty($fileRepaire) && $fileRepaire->isNotEmpty())
    <div id="modalFileRepaire" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full  lg:max-w-[85%] max-w-[99%] max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Detail Foto
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalFileRepaire">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body dengan carousel -->
                <div class="p-3 md:p-4">
                    <div id="carousel" class="relative w-full" data-carousel="slide">
                        <div class="relative  md:h-[700px] h-[400px] flex items-center justify-center overflow-hidden rounded-lg">
                            @foreach ($fileRepaire as $index => $rpe)
                                <div class="absolute inset-0 transition-opacity duration-700 ease-in-out rounded-lg" data-carousel-item>
                                    <img src="{{ asset('storage/fileMainten/'.$rpe->nameFile) }}" class="lg:object-cover object-contain transition-opacity duration-700 h-full w-full rounded-lg">
                                </div>
                            @endforeach
                        </div>
                        <!-- Tombol navigasi -->
                        <button type="button" class="absolute top-1/2 left-2 z-30 flex items-center justify-center w-10 h-10 bg-gray-800/30 rounded-full hover:bg-gray-800/50" data-carousel-prev>
                            <span class="sr-only">Previous</span>
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button type="button" class="absolute top-1/2 right-2 z-30 flex items-center justify-center w-10 h-10 bg-gray-800/30 rounded-full hover:bg-gray-800/50" data-carousel-next>
                            <span class="sr-only">Next</span>
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-3 md:p-4 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="modalFileRepaire" type="button" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
</x-layoutdsbd>
