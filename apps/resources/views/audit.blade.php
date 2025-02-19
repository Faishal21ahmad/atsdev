<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">

    <div class="container mx-auto w-full">
        <div class="w-full overflow-y-auto flex gap-4 p-2 lg:p-0
        scrollbar-thin
        scrollbar-thumb-slate-300 
        scrollbar-track-slate-100 
        dark:scrollbar-thumb-slate-300 
        dark:scrollbar-track-slate-500">
            <a href="#" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">CheckIn</a>
            <a href="#" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">CheckOut</a>
            <a href="#" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Mantenece</a>
            <a href="#" class="px-5 sm:px-10 py-2 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Mantenece</a>
        </div>
    </div>


    <section id="checkin" class="container mx-auto mt-4 w-full text-white overflow-hidden">
        <div class="w-full flex justify-between">
            <h1 class="text-2xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap">Check in</h1>
        </div>
        <div class="w-full overflow-x-auto max-h-screen overflow-y-auto
            scrollbar-thin
            scrollbar-thumb-rounded-full 
            scrollbar-thumb-slate-300 
            scrollbar-track-slate-100 
            dark:scrollbar-thumb-slate-300 
            dark:scrollbar-track-slate-500
            scrollbar-thumb-rounded-full 
            scrollbar-track-rounded-full">
            <table id="tableList" class="table-auto w-full text-left overflow-x-auto">
                <thead>
                    <tr class="sticky top-0 border-b border-gray-200 bg-white dark:border-gray-700 rounded-md text-gray-900 dark:text-gray-100 dark:bg-slate-900">
                        <th class="py-3 px-1 whitespace-nowrap">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Checkin</th>
                        <th class="py-3 px-1 whitespace-nowrap">Date In</th>
                        <th class="py-3 px-1 whitespace-nowrap">Master Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Item Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Total Price</th>
                        <th class="py-3 px-1 whitespace-nowrap">Status</th>
                        <th class="py-3 px-1 whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="border-b border-gray-200 dark:border-gray-700 rounded-md text-gray-900 dark:text-gray-100">
                    @if (empty($dataCheckin))
                        <tr>
                            <td colspan="6" class="py-3 px-1 text-center">Empty Data .</td>
                        </tr>
                    @else
                        @foreach ($dataCheckin as $index => $item)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="py-3 px-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item['codecheckin'] }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->created_at)->format('d / m / Y') }} </td>
                                <td class="py-3 px-1 whitespace-nowrap">50</td>
                                <td class="py-3 px-1 whitespace-nowrap">50</td>
                                <td class="py-3 px-1 whitespace-nowrap">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">Success</td>
                                <td class="py-3 px-1 whitespace-nowrap">
                                    <form action="{{ route('checkin.remove.action', $item['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 sm:px-5 py-1 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>


    <section id="checkout" class="container mx-auto mt-4 w-full text-white">
        <div class="w-full flex justify-between">
            <h1 class="text-2xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Check out</h1>
        </div>
        <div class="w-full overflow-x-auto max-h-screen overflow-y-auto
            scrollbar-thin
            scrollbar-thumb-rounded-full 
            scrollbar-thumb-slate-300 
            scrollbar-track-slate-100 
            dark:scrollbar-thumb-slate-300 
            dark:scrollbar-track-slate-500
            scrollbar-thumb-rounded-full 
            scrollbar-track-rounded-full">
            <table id="tableList" class="table-auto w-full text-left">
                <thead>
                    <tr class="sticky top-0 border-b border-gray-200 bg-white dark:border-gray-700 rounded-md text-gray-900 dark:text-gray-100 dark:bg-slate-900">
                        <th class="py-3 px-1 whitespace-nowrap">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Checkout</th>
                        <th class="py-3 px-1 whitespace-nowrap">Item Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Date out</th>
                        <th class="py-3 px-1 whitespace-nowrap">Vendor</th>
                        <th class="py-3 px-1 whitespace-nowrap">Status</th>
                        <th class="py-3 px-1 whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="border-b border-gray-200 dark:border-gray-700 rounded-md text-gray-900 dark:text-gray-100">
                    @if (empty($dataCheckout))
                    <tr>
                        <td colspan="6" class="py-3 px-1 text-center">Empty Data .</td>
                    </tr>
                @else
                    @foreach ($dataCheckout as $index => $item)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $item['codecheckout'] }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">50</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->created_at)->format('d / m / Y') }} </td>
                            <td class="py-3 px-1 whitespace-nowrap">50</td>
                            <td class="py-3 px-1 whitespace-nowrap">Success</td>
                            <td class="py-3 px-1 whitespace-nowrap">
                                <form action="{{ route('checkin.remove.action', $item['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 sm:px-5 py-1 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        
    </section>

    <section id="maintenance" class="container mx-auto mt-4 w-full">
        <div class="w-full flex justify-between">
            <h1 class="text-2xl py-2 font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap overflow-hidden">Maintenance</h1>
        </div>

        <div class="w-full overflow-x-auto max-h-screen overflow-y-auto
            scrollbar-thin
            scrollbar-thumb-rounded-full 
            scrollbar-thumb-slate-300 
            scrollbar-track-slate-100 
            dark:scrollbar-thumb-slate-300 
            dark:scrollbar-track-slate-500
            scrollbar-thumb-rounded-full 
            scrollbar-track-rounded-full">
            <table id="tableList" class="table-auto w-full text-left">
                <thead>
                    <tr class="sticky top-0 border-b border-gray-200 bg-white dark:border-gray-700 rounded-md text-gray-900 dark:text-gray-100 dark:bg-slate-900">
                        <th class="py-3 px-1 whitespace-nowrap">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Maintenance</th>
                        <th class="py-3 px-1 whitespace-nowrap">Date Report</th>
                        <th class="py-3 px-1 whitespace-nowrap">Name Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Status</th>
                        <th class="py-3 px-1 whitespace-nowrap">Action</th>
                    </tr>
                </thead>
               
                <tbody id="tableBody" class="border-b  border-gray-200 dark:border-gray-700 rounded-md text-gray-900 dark:text-gray-100  ">
                    @if (empty($dataMaintenance))
                        <tr>
                            <td colspan="6" class="py-3 px-1 text-center">Empty Data .</td>
                        </tr>
                    @else
                        @foreach ($dataMaintenance as $index => $item)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="py-3 px-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item['code_maintenance'] }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->created_at)->format('d / m / Y') }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->masterAsset->asset_name }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->itemAsset->code_assets }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->status_mainten }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">
                                    <form action="{{ route('checkin.remove.action', $item['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 sm:px-5 py-1 rounded-md border-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-0 dark:text-white">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
      
    </section>

    


</x-layoutdsbd>