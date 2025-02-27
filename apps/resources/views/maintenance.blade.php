<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />

    <!-- Maintenance Schedule -->
    <div class="container mx-auto w-full mt-5">
        <div class="flex justify-between">
            <h1 class="text-xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Maintenance Schedule</h1>
            <a href="{{ route('refreshSchedule') }}">
                <button type="button" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Refresh Schedule</button>
            </a>
        </div>
        <div class="w-full h-64 overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300  scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full  scrollbar-track-rounded-full">
            <table class="table-auto w-full text-left ">
                <thead class="">
                    <tr class="sticky top-0 bg-slate-100 dark:bg-gray-900 border-b-2 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100 shadow-md">
                        <th class="py-3 px-2 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-2 whitespace-nowrap">Code Mainten</th>
                        <th class="py-3 px-2 whitespace-nowrap">Code Asset</th>
                        <th class="py-3 px-2 whitespace-nowrap">Asset Name</th>
                        <th class="py-3 px-2 whitespace-nowrap">Location</th>
                        <th class="py-3 px-2 whitespace-nowrap">Date Report</th>
                        <th class="py-3 px-2 whitespace-nowrap">Type Report</th>
                        <th class="py-3 px-2 whitespace-nowrap">Problem Detail</th>
                        <th class="py-3 px-2 whitespace-nowrap">Action</th>
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
                    <tr class="border-b text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-700 rounded-md {{ $isHighlighted ? 'bg-red-300 dark:bg-red-700' : '' }}">
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->code_maintenance ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->itemasset->code_assets ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->masterasset->asset_name ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->location->location_name ?? 'Unknown' }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ \Carbon\Carbon::parse($maintenance->created_at)->format('d/m/Y') }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->report_type }}</td>
                        <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->problem_detail ?? '-' }}</td>
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

    <!-- Maintenance ALL -->
    <div class="container mx-auto w-full mt-5">
        <h1 class="text-xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Maintenance</h1>
        {{-- {{ $getReportedMaintenances }} --}}
        <div class="w-full h-screen overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300  scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full  scrollbar-track-rounded-full">
            <table class="table-auto w-full text-left ">
                <thead class="">
                    <tr class="sticky top-0 bg-slate-100 dark:bg-gray-900 border-b-2 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100 shadow-md">
                        <th class="py-3 px-2 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-2 whitespace-nowrap">Code Mainten</th>
                        <th class="py-3 px-2 whitespace-nowrap">Code Asset</th>
                        <th class="py-3 px-2 whitespace-nowrap">Asset Name</th>
                        <th class="py-3 px-2 whitespace-nowrap">Location</th>
                        {{-- <th class="py-3 px-2 whitespace-nowrap">Date Report</th> --}}
                        <th class="py-3 px-2 whitespace-nowrap">Type Report</th>
                        <th class="py-3 px-2 whitespace-nowrap">Status</th>
                        <th class="py-3 px-2 whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse($maintenFinish as $maintenance)
                        @php
                            $createdAt = \Carbon\Carbon::parse($maintenance->created_at);
                            $twoDaysAgo = \Carbon\Carbon::now()->subDays(2);
                            $twoDaysLater = \Carbon\Carbon::now()->addDays(2);
                            $isHighlighted = $createdAt->lessThanOrEqualTo($twoDaysAgo) || $createdAt->greaterThanOrEqualTo($twoDaysLater);
                        @endphp
                        <tr class="border-b text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-700 rounded-md {{ $isHighlighted ? 'bg-red-300 dark:bg-red-700' : '' }}">
                            <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->code_maintenance ?? 'Unknown' }}</td>
                            <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->itemasset->code_assets ?? 'Unknown' }}</td>
                            <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->masterasset->asset_name ?? 'Unknown' }}</td>
                            <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->location->location_name ?? 'Unknown' }}</td>
                            {{-- <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ \Carbon\Carbon::parse($maintenance->created_at)->format('d/m/Y') }}</td> --}}
                            <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->report_type }}</td>
                            <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">{{ $maintenance->status_mainten ?? '-' }}</td>
                            <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate">
                                <a href="{{ route('showDetailMainten', $maintenance->code_maintenance ) }}" class="py-2 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">Detail</a>
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
</x-layoutdsbd>