<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <div class="container mx-auto w-full">
        <div class="w-full dark:text-white overflow-y-auto flex gap-4 p-2 lg:p-0 scrollbar-thin scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500">
            <a href="{{ route('showCheckIn') }}" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0">CheckIn</a>
            <a href="{{ route('showCheckOut') }}" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0">CheckOut</a>
            {{-- <a href="#" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0">Mantenece</a> --}}
        </div>
    </div>
    <div class="w-full h-1 my-4 bg-slate-200 dark:bg-slate-800 rounded-md"></div>

    <!-- Assets -->
    <div class="container mx-auto w-full space-y-4">
        <div class="">
            <label for="inputSearch" class="sr-only">Search</label>
            <div class="w-20 relative">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="inputSearch" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-40 lg:w-80  bg-gray-50 focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Search Asset">
            </div>
        </div>
        
        <div class="w-full overflow-x-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300  scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full  scrollbar-track-rounded-full h-screen">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr class="sticky top-0 text-gray-900 dark:text-gray-100 bg-slate-100 dark:bg-gray-900 border-b-2 border-gray-200 dark:border-gray-700 shadow-md">
                        <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Category</th>
                        <th class="py-3 px-1 whitespace-nowrap">Description</th>
                        <th class="py-3 px-1 whitespace-nowrap">Stock</th>
                        <th class="py-3 px-1 whitespace-nowrap">Maint Duration</th>
                        <th class="py-3 px-1 whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse ($assetMaster as $asset)
                    <tr class="text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 rounded-md">
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $asset->asset_name }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $asset->category->category_name ?? '-' }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $asset->description ?? '-' }}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $asset->current_stock ?? '-'}}</td>
                        <td class="py-3 px-1 whitespace-nowrap max-w-[20ch] truncate">{{ $asset->interval_maintence ?? '-'}} M</td>
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


    <script>
        // Event listener untuk Search
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('inputSearch');
            const tableBody = document.getElementById('tableBody');
            const rows = tableBody.getElementsByTagName('tr');
            const noResultsMessage = document.createElement('tr');
            noResultsMessage.innerHTML = '<td colspan="7" class="text-center py-3 text-gray-500 dark:text-gray-400">No Aset found.</td>';

            noResultsMessage.style.display = 'none';
            tableBody.appendChild(noResultsMessage);

            searchInput.addEventListener('keyup', function () {
                const searchText = searchInput.value.toLowerCase();
                let found = false;
                
                for (let row of rows) {
                    if (row === noResultsMessage) continue;
                    
                    const asset = row.cells[1]?.textContent.toLowerCase().trim() || '';
                    const category = row.cells[2]?.textContent.toLowerCase().trim() || '';
                    const description = row.cells[3]?.textContent.toLowerCase().trim() || '';
                    const stock = row.cells[4]?.textContent.toLowerCase().trim() || '';
                    const maintDuration = row.cells[5]?.textContent.toLowerCase().trim() || '';
                    
                    if (asset.includes(searchText) || category.includes(searchText) || description.includes(searchText) || stock.includes(searchText) || maintDuration.includes(searchText) ) {
                        row.style.display = '';
                        found = true;
                    } else {
                        row.style.display = 'none';
                    }
                }
                
                noResultsMessage.style.display = found ? 'none' : '';
            });
        });
    </script>
    
</x-layoutdsbd> 