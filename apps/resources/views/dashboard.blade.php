<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <!-- Dashboard -->
    <div class="container mx-auto">
        <div class="grid grid-rows-2 gap-1 grid-flow-col sm:grid-rows-2 sm:grid-flow-col lg:grid-cols-3 lg:grid-rows-1">
            <!-- Kotak 1 -->
            <div class="col-span-1 flex items-center">
                <div class="">
                    <h1 class="text-5xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalasset }}</h1>
                    <span class="text-gray-600 dark:text-gray-400">Total Asset</span>
                </div>
            </div>
            <!-- Kotak 2 -->
            <div class="col-span-1 flex items-center">
                <div class="">
                    <h1 class="text-5xl font-semibold text-gray-900 dark:text-gray-100">{{ $countlowStock }}</h1>
                    <span class="text-gray-600 dark:text-gray-400">Stok low</span>
                </div>
            </div>
            <!-- Kotak 3 -->
            <div class="row-span-2 lg:row-span-1 grid gap-1 text-xl">
                <a href="{{ route('scanAsset') }}" class="p-2 w-full text-center border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">Scan</a>
                <a href="{{ route('showCheckIn') }}" class="p-2 w-full text-center border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">Check in</a>
                <a href="{{ route('showCheckOut') }}" class="p-2 w-full text-center border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">Check out</a>
                <a href="{{ route('scanReportMaintence') }}" class="p-2 w-full text-center border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">Maintenance</a>
            </div>
        </div>
    </div>


    <!-- Maintenance Schedule -->
    <div class="container mx-auto w-full mt-5">
        <h1 class="text-xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Maintenance Schedule</h1>
        {{-- {{ $getReportedMaintenances }} --}}
        <div class="w-full h-64 overflow-x-auto
            scrollbar-thin
            scrollbar-thumb-rounded-full 
            scrollbar-thumb-slate-300 
            scrollbar-track-slate-100 
            dark:scrollbar-thumb-slate-300 
            dark:scrollbar-track-slate-500
            scrollbar-thumb-rounded-full 
            scrollbar-track-rounded-full
        ">
            <table class="table-auto w-full text-left ">
                <thead class="">
                    <tr class="sticky top-0 bg-white dark:bg-gray-900 border-b-2 border-gray-200 dark:border-gray-700 rounded-md ">
                        <th class="py-3 px-2 whitespace-nowrap text-gray-900 dark:text-gray-100">No</th>
                        <th class="py-3 px-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Code Mainten</th>
                        <th class="py-3 px-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Code Asset</th>
                        <th class="py-3 px-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Asset Name</th>
                        <th class="py-3 px-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Location</th>
                        <th class="py-3 px-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Date Report</th>
                        <th class="py-3 px-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Type Report</th>
                        <th class="py-3 px-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Problem Detail</th>
                        <th class="py-3 px-2 whitespace-nowrap text-gray-900 dark:text-gray-100">Action</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse($getReportedMaintenances as $maintenance)
                        @php
                            $createdAt = \Carbon\Carbon::parse($maintenance->created_at);
                            $twoDaysAgo = \Carbon\Carbon::now()->subDays(2);
                            $twoDaysLater = \Carbon\Carbon::now()->addDays(2);
                            $isHighlighted = $createdAt->lessThanOrEqualTo($twoDaysAgo) || $createdAt->greaterThanOrEqualTo($twoDaysLater);
                        @endphp
                    <tr class="border-b border-gray-200 dark:border-gray-700 rounded-md {{ $isHighlighted ? 'bg-red-300 dark:bg-red-700' : '' }}">
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $maintenance->code_maintenance ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $maintenance->itemasset->code_assets ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $maintenance->masterasset->asset_name ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $maintenance->location->location_name ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($maintenance->created_at)->format('d/m/Y') }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $maintenance->report_type }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $maintenance->problem_detail ?? '-' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">
                            <a href="{{ route('mainten.resolve', $maintenance->code_maintenance ) }}" class="py-2 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">do the task</a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-gray-500 dark:text-gray-400">
                                No maintenance schedule found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
{{-- <x-table :columns="$columns" :data="$data" />
--}}

<!-- Stok Low -->
<div class="container mx-auto w-full mt-5">
    <h1 class="text-xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Stok Low</h1>
    <div class="w-full overflow-x-auto scrollbar-thin
                scrollbar-thumb-rounded-full 
                scrollbar-thumb-slate-300 
                scrollbar-track-slate-100 
                dark:scrollbar-thumb-slate-300 
                dark:scrollbar-track-slate-500
                scrollbar-thumb-rounded-full 
                scrollbar-track-rounded-full">
        <table class="table-auto w-full text-left">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 rounded-md">
                    <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">No</th>
                    <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">Name Asset</th>
                    <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">Stock</th>
                    <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($getLowStockAssets as $index => $item)
                    <tr class="border-b border-gray-200 dark:border-gray-700 rounded-md">
                        <td class="py-3 px-1 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                        <td class="py-3 px-1 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $item->asset_name }}</td>
                        <td class="py-3 px-1 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $item->current_stock }}</td>
                        <td class="py-3 px-1 whitespace-nowrap">
                            <a href="#" class="py-2 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">do the task</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-3 text-gray-500 dark:text-gray-400">
                            No Stok Low found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan alert
    function showAlert(type, messages) {
            const container = document.getElementById('js-alert-container');

            // Buat elemen alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert-message'; // Tambahkan class untuk styling
            alertDiv.innerHTML = `
                <div class="flex p-4 text-sm rounded-lg shadow-lg ${getAlertColor(type)}" role="alert">
                    <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">${type}</span>
                    <div>
                        <span class="font-medium">${getAlertTitle(type)}</span>
                        <ul class="mt-1.5 list-disc list-inside">
                            ${messages.map(msg => `<li>${msg}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            `;

            // Tambahkan ke container
            container.appendChild(alertDiv);

            // Tampilkan alert
            alertDiv.classList.remove('hidden');

            // Sembunyikan alert setelah 5 detik
            setTimeout(() => {
                alertDiv.classList.add('hidden');
                setTimeout(() => alertDiv.remove(), 300); // Hapus elemen setelah animasi selesai
            }, 5000);
        }

        // Fungsi untuk menentukan warna alert berdasarkan type
        function getAlertColor(type) {
            const colors = {
                danger: 'bg-red-50 text-red-800 dark:bg-gray-800 dark:text-red-400',
                alert: 'bg-yellow-50 text-yellow-800 dark:bg-gray-800 dark:text-yellow-400',
                success: 'bg-green-50 text-green-800 dark:bg-gray-800 dark:text-green-400',
                info: 'bg-blue-50 text-blue-800 dark:bg-gray-800 dark:text-blue-400',
            };
            return colors[type] || colors.info;
        }

        // Fungsi untuk menentukan judul alert berdasarkan type
        function getAlertTitle(type) {
            const titles = {
                danger: 'Please fix the following errors:',
                alert: 'Attention needed:',
                success: 'Success!',
                info: 'Info:',
            };
            return titles[type] || 'Info';
        }



</script>

</x-layoutdsbd>