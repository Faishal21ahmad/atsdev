<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />

    <div class="container mt-2 w-full  dark:text-white ">
        <div class="flex justify-between">
            <div class="">
                <p class="text-2xl">{{ $datacheckin->codecheckin }}</p>
                <p class="text-2xl font-semibold"><span class="">Officer : </span>{{ $datacheckin->user->username }}</p>
                <p class="text-lg"><span class="">Date : </span>{{ \Carbon\Carbon::parse( $datacheckin->created_at )->format('d / M / Y H:i') }}</p>
                <br>
            </div>
            <div class="">
                <p class="text-2xl font-semibold">Rp. {{ number_format($datacheckin->total, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="">
            <span class="text-lg font-semibold">Description :</span>
            <p class="text-md min-h-16 max-h-32 overflow-hidden overflow-x-auto overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">{{ $datacheckin->description }}</p>
        </div>
    </div>

    <br>
    <section id="checkin" class="mx-auto w-full text-white overflow-hidden">
        <div class="w-full flex justify-between">
            <h1 class="text-2xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap">Detail Asset</h1>
        </div>
        <div class="w-full overflow-x-auto max-h-screen overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
            <table id="tableList" class="table-auto w-full text-left overflow-x-auto">
                <thead>
                    <tr class="sticky top-0 border-b border-slate-200 bg-white dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100 dark:bg-slate-900">
                        <th class="py-3 px-1 whitespace-nowrap">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Name Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Unit Price</th>
                        <th class="py-3 px-1 whitespace-nowrap">Quantity</th>
                        <th class="py-3 px-1 whitespace-nowrap">Sub Total</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="border-b border-slate-200 dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100">
                    @if (empty($datadetailcheckin))
                        <tr>
                            <td colspan="6" class="py-3 px-1 text-center">Empty Data .</td>
                        </tr>
                    @else
                        @foreach ($datadetailcheckin as $item)
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <td class="py-3 px-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->masterAsset->asset_name }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->quantity }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>


    <br>
    <section id="checkin" class="mx-auto w-full text-white overflow-hidden">
        <div class="w-full flex justify-between">
            <h1 class="text-2xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap">Detail Item</h1>
        </div>
        <div class="w-full overflow-x-auto max-h-screen overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
            <table id="tableList" class="table-auto w-full text-left overflow-x-auto">
                <thead>
                    <tr class="sticky top-0 border-b border-slate-200 bg-white dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100 dark:bg-slate-900">
                        <th class="py-3 px-1 whitespace-nowrap">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Name Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Location</th>
                        <th class="py-3 px-1 whitespace-nowrap">Departement</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="border-b border-slate-200 dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100">
                    @if (empty($dataitemasset))
                        <tr>
                            <td colspan="6" class="py-3 px-1 text-center">Empty Data .</td>
                        </tr>
                    @else
                        @foreach ($dataitemasset as $item)
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <td class="py-3 px-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->masterAsset->asset_name }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->code_assets }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->location->location_name ?? 'unset' }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->department->department_name ?? 'unset' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>
</x-layoutdsbd>


