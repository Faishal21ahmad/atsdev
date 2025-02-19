<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <div class="container mx-auto w-full">
        <div class="w-full overflow-y-auto flex gap-4 p-2 lg:p-0
        scrollbar-thin
        scrollbar-thumb-slate-300 
        scrollbar-track-slate-100 
        dark:scrollbar-thumb-slate-300 
        dark:scrollbar-track-slate-500">
            <a href="{{ route('showCheckIn') }}" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">CheckIn</a>
            <a href="{{ route('showCheckOut') }}" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">CheckOut</a>
            <a href="#" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Mantenece</a>
        </div>
    </div>

    <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>
    {{-- {{ $assetMaster }} --}}

    <!-- Assets -->
    <div class="container mx-auto w-full">
        <h1 class="text-xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Assets</h1>
        <div class="w-full overflow-x-auto
            scrollbar-thin
            scrollbar-thumb-rounded-full 
            scrollbar-thumb-slate-300 
            scrollbar-track-slate-100 
            dark:scrollbar-thumb-slate-300 
            dark:scrollbar-track-slate-500
            scrollbar-thumb-rounded-full 
            scrollbar-track-rounded-full">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr class="sticky top-0 bg-white dark:bg-gray-900 border-b-2 border-gray-200 dark:border-gray-700 rounded-md">
                        <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">No</th>
                        <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">Category</th>
                        <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">Description</th>
                        <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">Stock</th>
                        <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">Maint Duration</th>
                        <th class="py-3 px-1 whitespace-nowrap text-gray-900 dark:text-gray-100">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assetMaster as $asset)
                    <tr class="border-b border-gray-200 dark:border-gray-700 rounded-md">
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $asset->asset_name }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $asset->category->category_name ?? '-' }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $asset->description ?? '-' }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $asset->current_stock ?? '-'}}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-gray-800 dark:text-gray-200">{{ $asset->interval_maintence ?? '-'}} M</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">
                            <a href="{{ route('masterAsset', $asset->slug ) }}" class="py-2 px-4 border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white rounded-md">
                            Detail</a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-gray-500 dark:text-gray-400">
                                No Asset found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
</x-layoutdsbd> 