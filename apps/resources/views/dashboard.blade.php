<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <!-- Dashboard -->
    <div class="container mx-auto">
        <div class="grid grid-rows-2 gap-1 grid-flow-col sm:grid-rows-2 sm:grid-flow-col lg:grid-cols-3 lg:grid-rows-1">
            <!-- Kotak 1 -->
            <div class="col-span-1 flex items-center">
                <div class="">
                    <h1 class="text-5xl font-semibold text-slate-900 dark:text-slate-100">{{ $totalasset }}</h1>
                    <span class="text-slate-600 dark:text-slate-400">Total Asset</span>
                </div>
            </div>
            <!-- Kotak 2 -->
            <div class="col-span-1 flex items-center">
                <div class="">
                    <h1 class="text-5xl font-semibold text-slate-900 dark:text-slate-100">{{ $countlowStock }}</h1>
                    <span class="text-slate-600 dark:text-slate-400">Stok low</span>
                </div>
            </div>
            <!-- Kotak 3 -->
            <div class="row-span-2 lg:row-span-1 grid gap-1 text-xl">
                @can('scan-item-asset')
                    <a href="{{ route('scanAsset') }}" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Scan</a>
                @endcan
                @can('checkin')
                    <a href="{{ route('showCheckIn') }}" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Check in</a>
                @endcan
                @can('checkout')
                    <a href="{{ route('showCheckOut') }}" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Check out</a>
                @endcan
                @can('scan-maintenance-report')
                    <a href="{{ route('scanReportMaintence') }}" class="p-2 w-full text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">Maintenance</a>
                @endcan
            </div>
        </div>
    </div>
    @can('maintenance-schedule')
    <!-- Maintenance Schedule -->
    <div class="container mx-auto w-full mt-5">
        <h1 class="text-xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap overflow-hidden">Maintenance Schedule</h1>
        {{-- {{ $getReportedMaintenances }} --}}
        <div class="w-full max-h-72 overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300  scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full  scrollbar-track-rounded-full">
            <table class="table-auto w-full text-left ">
                <thead class="">
                    <tr class="sticky top-0 bg-slate-100 dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 shadow-md">
                        <th class="py-3 px-2 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-2 whitespace-nowrap">Code Mainten</th>
                        <th class="py-3 px-2 whitespace-nowrap">Code Asset</th>
                        <th class="py-3 px-2 whitespace-nowrap">Asset Name</th>
                        <th class="py-3 px-2 whitespace-nowrap">Location</th>
                        <th class="py-3 px-2 whitespace-nowrap">Date Report</th>
                        <th class="py-3 px-2 whitespace-nowrap">Type Report</th>
                        <th class="py-3 px-2 whitespace-nowrap">Problem Detail</th>
                        <th class="py-3 px-2 whitespace-nowrap">Status Mainten</th>

                        @can('resolve-maintenance')
                        <th class="py-3 px-2 whitespace-nowrap text-center">Action</th>
                        @endcan
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
                    <tr class="border-b text-slate-800 dark:text-slate-200 border-slate-200 dark:border-slate-700 rounded-md {{ $isHighlighted ? 'bg-red-300 dark:bg-red-700' : '' }}">
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->code_maintenance ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->itemasset->code_assets ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->itemasset->masterasset->asset_name ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->itemasset->location->location_name ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ \Carbon\Carbon::parse($maintenance->created_at)->format('d / M / Y') }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->report_type }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->problem_detail ?? '-' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->status_mainten ?? '-' }}</td>
                        
                        @can('resolve-maintenance')
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-center">
                            <a href="{{ route('mainten.resolve', $maintenance->code_maintenance ) }}" class="py-2 px-4  text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">handle</a>
                        </td>
                        @endcan
                    </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-3 text-slate-500 dark:text-slate-400">
                                No maintenance schedule was found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endcan

<!-- Stok Low -->
<div class="container mx-auto w-full mt-5">
    <h1 class="text-xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap overflow-hidden">Low Stock</h1>
    <div class="w-full max-h-72 overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
        <table class="table-auto w-full text-left">
            <thead>
                <tr class="sticky text-slate-900 dark:text-slate-100 top-0 bg-slate-100 dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-700 shadow-md">
                    <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                    <th class="py-3 px-1 whitespace-nowrap">Name Asset</th>
                    <th class="py-3 px-1 whitespace-nowrap">Stock current</th>
                    @can('checkin')
                    <th class="py-3 px-1 whitespace-nowrap">Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @forelse ($getLowStockAssets as $index => $item)
                    <tr class="text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-700 rounded-md">
                        <td class="py-3 px-1 whitespace-nowrap text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-1 whitespace-nowrap">{{ $item->asset_name }}</td>
                        <td class="py-3 px-1 whitespace-nowrap">{{ $item->current_stock }}</td>
                        @can('checkin')
                        <td class="py-3 px-1 whitespace-nowrap">
                            <a href="{{ route('showCheckIn', $item->slug) }}" class="py-2 px-4 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">add</a>
                        </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3 text-slate-500 dark:text-slate-400">
                            not found Low Stock
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</x-layoutdsbd>