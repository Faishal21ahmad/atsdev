<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">

    <!-- Maintenance Schedule -->
    <div class="container mx-auto w-full mt-5 space-y-4">
        <div class="flex justify-between">
            <h1 class="text-xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap overflow-hidden">Maintenance</h1>
            @can('refresh-schaduler-maintenance')
                <a href="{{ route('refreshSchedule') }}">
                    <button type="button" class="px-5 sm:px-10 py-2 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md ">Refresh Schedule</button>
                </a>
            @endcan
        </div>
        <div class="w-full h-svh overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300  scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full  scrollbar-track-rounded-full">
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
                        {{-- <th class="py-3 px-2 whitespace-nowrap">Problem Detail</th> --}}
                        <th class="py-3 px-2 whitespace-nowrap">Status Mainten</th>

                        @can('resolve-maintenance')
                            <th class="py-3 px-2 whitespace-nowrap text-center">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="">
                    @forelse($maintenReportProgress as $maintenance)
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
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ \Carbon\Carbon::parse($maintenance->created_at)->format('d/M/Y') }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->report_type }}</td>
                        {{-- <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->problem_detail ?? '-' }}</td> --}}
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->status_mainten ?? '-' }}</td>
                        
                        @can('resolve-maintenance')
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-center">
                            <a href="{{ route('mainten.resolve', $maintenance->code_maintenance ) }}" class="py-2 px-4 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md">handle</a>
                        </td>
                        @endcan
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-slate-500 dark:text-slate-400">
                                No maintenance schedule found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


</x-layoutdsbd>