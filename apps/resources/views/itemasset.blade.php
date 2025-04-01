<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />
    <div class="container mx-auto w-full mt-5">
        {{-- {{ $dataItem }} --}}
        <div class="flex gap-4 justify-between">
            <div id="qrmain" class="hidden lg:block flex-none">
                <img width="200" height="200" src="{{ asset('storage/fileQR/' . $dataItem->code_assets .'.svg'); }}" class="p-2 object-contain rounded-md bg-white" alt="">
            </div>
            <!-- Left Section -->
            <div class="w-3/4 text-slate-900 dark:text-slate-100">
                <div class="flex gap-4">
                    <p class="text-lg">{{ $dataItem->code_assets }}</p>
                    <p class="text-lg">{{ $dataItem->location->location_name ?? 'Unknown' }}</p>
                </div>
                <p class="text-3xl font-semibold">{{ $dataItem->masterAsset->asset_name }}</p>
                <div class="flex w-full text-lg text-slate-600 dark:text-slate-200 space-x-1">
                    <div class="">
                        <p class="truncate">Date In </p>
                        <p class="truncate">Date Out </p>
                        <p class="truncate">Condition </p>
                        <p class="truncate">Department </p>
                        <p class="truncate">Status </p>
                    </div>
                    <div class="">
                        <p class="truncate"> : {{ \Carbon\Carbon::parse($dataItem->created_at)->format('d / M / Y H:i') }}</p>
                        <p class="truncate"> : {{ $dataItem->check_out_id ?? '--' }}</p>
                        <p class="truncate"> : {{ $dataItem->condition }}</p>
                        <p class="truncate"> : {{ $dataItem->department->department_name ?? 'Unknown' }}</p>
                        <p class="truncate"> : 
                            <span class="px-3 py-1 rounded-md text-white text-sm 
                                {{ $dataItem->status == 'Available' ? 'bg-green-500' : 
                                    ($dataItem->status == 'Maintenance' ? 'bg-yellow-500' : 
                                    ($dataItem->status == 'Damaged' ? 'bg-red-500' : 'bg-blue-500')) }}">
                                {{ ucfirst(str_replace('_', ' ', $dataItem->status)) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        
            <!-- Right Section -->
            <div class="w-1/2 lg:w-1/4">
                <div class="flex flex-col items-start gap-2 text-lg">
                    @can('edit-item-asset')
                    <button id="updateItemAssetButton" data-modal-target="updateItemAssetModal" data-modal-toggle="updateItemAssetModal" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Edit</button>
                    @endcan
                    @can('printqr-item-asset')
                        <a href="{{ route('printbycode', $dataItem->code_assets ) }}"  target="blank"  class="w-full">
                            <button class="p-2 w-full  text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Print QR</button>
                        </a>
                    @endcan
                    @can('report-maintenance')
                        @if ($dataItem->status == 'Available')
                            <a href="{{ route('mainten.report', $dataItem->code_assets ) }}" 
                                class="p-2 w-full truncate text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">
                                Report Mainten
                            </a>
                        @endif
                    @endcan
                </div>
            </div>
            
        </div>
    </div>
    <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>
    <div class="container mx-auto w-full flex">
        <div class="w-full">
            <h1 class="font-semibold text-2xl text-slate-900 dark:text-slate-100">Deskripsi</h1>
            <p class="text-lg text-slate-900 dark:text-slate-100">{{ $dataItem->description ?? 'Unknown'}}</p>
        </div>
        <div id="qr" class="flex-non lg:hidden block">
        </div>
    </div>
    <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>

    <!-- Asset List -->
    <div class="container mx-auto w-full">
        <div class="w-full flex justify-between mb-2">
            <h1 class="text-2xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap overflow-hidden">Maintenance History</h1>
        </div>
    
        <div class="w-full overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr class="sticky top-0 text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-700 shadow-md">
                        <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Mantence</th>
                        <th class="py-3 px-1 whitespace-nowrap">Date</th>
                        <th class="py-3 px-1 whitespace-nowrap">Type Maint</th>
                        <th class="py-3 px-1 whitespace-nowrap">Problem Detail</th>
                        <th class="py-3 px-1 whitespace-nowrap">Repair Detail</th>
                        <th class="py-3 px-1 whitespace-nowrap">Cost</th>
                        <th class="py-3 px-1 whitespace-nowrap">Vendor</th>
                        @can('detail-maintenance')
                        <th class="py-3 px-1 whitespace-nowrap text-center">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataMaintenenceItem as $item)
                        <tr class="text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-700 rounded-md">
                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $item->code_maintenance }}</td>
                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ \Carbon\Carbon::parse($item->created_at)->format('d / M / Y') }}</td>
                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $item->report_type }}</td>
                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $item->problem_detail }}</td>
                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $item->repaire_detail ?? 'Reported' }}</td>
                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ number_format($item->cost, 2) ?? '-' }}</td>
                            <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $item->vendor->vendor_name ?? 'Reported' }}</td>
                            @can('detail-maintenance')
                            <td class="py-3 px-1 whitespace-nowrap text-center">
                                <a href="{{ route('showDetailMainten', $item->code_maintenance ) }}" class="py-1.5 px-4 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">
                                    Detail
                                </a>
                            </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-slate-500 dark:text-slate-400">
                                not found maintenance
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
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-slate-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-3 mb-3 border-b rounded-t sm:mb-3 dark:border-slate-600">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                        Update Item Asset
                    </h3>
                    <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-toggle="updateItemAssetModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="dark:text-white mb-5">
                    <p class="text-lg">{{ $dataItem->code_assets }}</p>
                    <h1 class="text-3xl font-semibold"> {{ $dataItem->masterAsset->asset_name }}</h1>
                </div>
                <form id="editItemAsset" action="{{ route('itemAsset.edit.action') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <input id="codeAsset" hidden type="text" value="{{ $dataItem->code_assets }}" name="codeAsset">
                        <div>
                            <label for="condition" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Condition</label>
                            <input type="text" name="condition" id="condition" value="{{ $dataItem->condition }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="GOOD / New">
                        </div>
                        <div>
                            <label for="location" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Location</label>
                            <select id="location" name="location" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500">
                                <option selected="" value="{{ $dataItem->location_id ?? '' }}">{{ $dataItem->location->location_name ?? 'Selecte Location' }}</option>
                                @foreach($location as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->location_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="departement" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Departement</label>
                            <select id="departement" name="departement" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500">
                                <option selected="" value="{{ $dataItem->department_id ?? '' }}">{{ $dataItem->department->department_name ?? 'Selecte Departement' }}</option>
                                @foreach($department as $dprt)
                                    <option value="{{ $dprt->id }}">{{ $dprt->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Description</label>
                            <textarea id="description" name="description" rows="5" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-slate-50 focus:border-slate-600 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-slate-500 dark:focus:border-slate-500" placeholder="Write a description...">{{ $dataItem->description }}</textarea>                    
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-white rounded-md">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ============================================== --}}
<script>
    const qrmain = document.getElementById('qrmain').innerHTML;
    document.getElementById('qr').innerHTML = qrmain;

    // Fungsi untuk validasi client-side
    function validateForm() {
        const codeAsset = document.getElementById('codeAsset').value.trim();
        const condition = document.getElementById('condition').value.trim();
        const location = document.getElementById('location').value.trim();
        const departement = document.getElementById('departement').value.trim();
        const errors = [];

        if (!codeAsset) errors.push('Item Asset tidak valid');
        else if (codeAsset.length != 8) errors.push('Item Asset tidak valid');
        if (!condition) errors.push('Condition tidak boleh kosong');
        if (!location) errors.push('Location tidak boleh kosong');
        if (!departement) errors.push('Departement tidak boleh kosong');
        return errors;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('editItemAsset').addEventListener('submit', function (e) {
            e.preventDefault(); // Mencegah form di-submit secara default
            const errors = validateForm();
            if (errors.length > 0) showAlert('danger', errors);
            else this.submit();
        });
    });
</script>
</x-layoutdsbd>