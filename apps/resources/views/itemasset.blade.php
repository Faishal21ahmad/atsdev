<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />

    <div class="container mx-auto w-full mt-5">
       
        {{-- {{ $dataItem }} --}}
        <div class="flex gap-4 justify-between">
            <div id="qrmain" class="hidden lg:block flex-none">
                <img width="200" height="200" src="{{ asset('storage/fileQR/' . $dataItem->code_assets .'.svg'); }}" class="p-2 object-contain rounded-md bg-white" alt="">
            </div>
            <!-- Left Section -->
            <div class="w-3/4 text-gray-900 dark:text-gray-100">
                <div class="flex gap-4">
                    <p class="text-lg">{{ $dataItem->code_assets }}</p>
                    <p class="text-lg">{{ $dataItem->location->location_name ?? 'Unknown' }}</p>
                </div>
                <p class="text-3xl font-semibold">{{ $dataItem->masterAsset->asset_name }}</p>
                <p class="text-lg">Date In : {{ \Carbon\Carbon::parse($dataItem->created_at)->format('d / m / Y') }} </p>
                <p class="text-lg">Date Out : {{ $dataItem->check_out_id ?? '- -' }}</p>
                <p class="text-lg">Condition : {{ $dataItem->condition }}</p>
                <p class="text-lg">Department : {{ $dataItem->department->department_name ?? 'Unknown' }}</p>
                <p class="text-lg">Status :
                    <span class="px-3 py-1 rounded-md text-white text-sm 
                    {{ $dataItem->status == 'Available' ? 'bg-green-500' : 
                       ($dataItem->status == 'Maintenance' ? 'bg-yellow-500' : 
                       ($dataItem->status == 'Damaged' ? 'bg-red-500' : 'bg-blue-500')) }}">
                    {{ ucfirst(str_replace('_', ' ', $dataItem->status)) }}
                </span>
                </p>
            </div>
        
            <!-- Right Section -->
            <div class="w-1/2 lg:w-1/4">
                <div class="flex flex-col items-start gap-2 text-lg">
                    <button id="updateItemAssetButton" data-modal-target="updateItemAssetModal" data-modal-toggle="updateItemAssetModal" class="p-2 w-full text-center border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">Edit</button>
                    
                    <a href="{{ route('printbycode', $dataItem->code_assets ) }}"  target="blank"  class="w-full">
                        <button class="p-2 w-full  text-center border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">Print QR</button>
                    </a>
                    @if ($dataItem->status == 'Available')
                        <a href="{{ route('mainten.report', $dataItem->code_assets ) }}" 
                            class="p-2 w-full text-center border-2 bg-slate-100 hover:bg-slate-200 
                            dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">
                            Maintenance Report
                        </a>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
    <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>
    <div class="container mx-auto w-full flex">
        <div class="w-full">
            <h1 class="font-semibold text-2xl text-gray-900 dark:text-gray-100">Deskripsi</h1>
            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $dataItem->description ?? 'Unknown'}}</p>
        </div>
        <div id="qr" class="flex-non lg:hidden block">
        </div>
    </div>
    <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>



    <!-- Asset List -->
    <div class="container mx-auto w-full">
        <div class="w-full flex justify-between mb-2">
            <h1 class="text-2xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Maintenance History</h1>
        </div>
    
        <div class="w-full overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 rounded-md">
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">No</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Code Mantence</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Date</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Type Maint</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Problem Detail</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Repair Detail</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Cost</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Vendor</th>
                        <th class="p-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataMaintenenceItem as $item)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-1 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                            <td class="py-3 px-1 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $item->code_maintenance }}</td>
                            <td class="py-3 px-1 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d / m / Y') }}
                            </td>
                            <td class="py-3 px-1 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                {{ $item->report_type }}
                            </td>
                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">
                                {{ $item->problem_detail }}
                            </td>

                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">
                                {{ $item->repaire_detail ?? 'Reported' }}
                            </td>
                            <td class="py-3 px-1 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                {{ number_format($item->cost, 2) ?? '-' }}
                            </td>
                            <td class="py-3 px-1 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                {{ $item->vendor->vendor_name ?? 'Reported' }}
                            </td>
                            <td class="py-3 px-1 whitespace-nowrap">
                                <a href="{{ route('showDetailMainten', $item->code_maintenance ) }}" class="py-1 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-gray-500 dark:text-gray-400">
                                No maintenance found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>




{{-- ============================================== --}}

<div class="container mx-auto w-full mt-5">
    <!-- Main modal -->
    <div id="updateItemAssetModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-3 mb-3 border-b rounded-t sm:mb-3 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Update Item Asset
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateItemAssetModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="text-white mb-5">
                    <p class="text-lg">{{ $dataItem->code_assets }}</p>
                    <h1 class="text-3xl font-semibold"> {{ $dataItem->masterAsset->asset_name }}</h1>
                </div>
                <form id="editItemAsset" action="{{ route('itemAsset.edit.action') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <input id="codeAsset" hidden type="text" value="{{ $dataItem->code_assets }}" name="codeAsset">
                        <div>
                            <label for="condition" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Condition</label>
                            <input type="text" name="condition" id="condition" value="{{ $dataItem->condition }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="GOOD / New">
                        </div>
                        <div>
                            <label for="location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                            <select id="location" name="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                <option selected="" value="{{ $dataItem->location_id }}">{{ $dataItem->location->location_name ?? 'Unknown' }}</option>
                                @foreach($location as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->location_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="departement" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departement</label>
                            <select id="departement" name="departement" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                <option selected="" value="{{ $dataItem->department_id }}">{{ $dataItem->department->department_name ?? 'Unknown' }}</option>
                                @foreach($department as $dprt)
                                    <option value="{{ $dprt->id }}">{{ $dprt->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea id="description" name="description" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Write a description...">{{ $dataItem->description }}</textarea>                    
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
</div>



<script>
    disableSubmitIfNoChanges('editItemAsset');

    const qrmain = document.getElementById('qrmain').innerHTML;
    document.getElementById('qr').innerHTML = qrmain;


    // Fungsi untuk validasi client-side
    function validateForm() {
        const codeAsset = document.getElementById('codeAsset').value;
        const errors = [];

        if (codeAsset === '') {
            errors.push('Kode Asset tidak boleh kosong');
        }
        return errors;
    }
    
    // Event listener untuk form submission
    document.getElementById('editItemAsset').addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah form di-submit secara default
        // Validasi client-side
        const errors = validateForm();

        if (errors.length > 0) {
            showAlert('danger', errors);
        }  else {
            // Jika tidak ada error, submit form secara manual
            this.submit();
        }
    });

    
</script>

</x-layoutdsbd>