<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">
    <x-btnback href="javascript:history.back()" />

    <div class="container mt-2 w-full  dark:text-white ">
        <div class="flex justify-between">
            <div class="">
                <p class="text-2xl">{{ $datacheckout->codecheckout }}</p>
                <p class="text-2xl font-semibold"><span class="">Officer : </span>{{ $datacheckout->user->username }}</p>
                <p class="text-lg"><span class="">Date : </span>{{ \Carbon\Carbon::parse( $datacheckout->created_at )->format('d / M / Y H:i') }}</p>
                <br>
            </div>
            <div class="">
                <p class="text-2xl font-semibold">Rp. {{ number_format($datacheckout->total, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="py-1">
            <span class="text-lg font-semibold">Vendor :</span>
            <p class="text-md">{{ $datacheckout->vendor->vendor_name }}</p>
            <p class="text-md">{{ implode('-', str_split($datacheckout->vendor->contact, 4)); }}</p>
            <p class="text-md">{{ $datacheckout->vendor->address }}</p>
        </div>
        <div class="py-1">
            <span class="text-lg font-semibold">Reason :</span>
            <p class="text-md">{{ $datacheckout->reason }}</p>
        </div>
        <div class="py-1">
            <span class="text-lg font-semibold">Description :</span>
            <p class="text-md min-h-16 max-h-32 overflow-hidden overflow-x-auto overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">{{ $datacheckout->description }}</p>
        </div>
        
    </div>

    <section id="checkin" class="max-w-3xl text-white overflow-hidden">
        <div class="w-full flex justify-between">
            <h1 class="text-2xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap">Detail Asset</h1>
        </div>
        <div class="w-full overflow-x-auto max-h-screen overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
            <table id="tableList" class="table-auto w-full text-left overflow-x-auto">
                <thead>
                    <tr class="sticky top-0 border-b border-slate-200 bg-white dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100 dark:bg-slate-900">
                        <th class="py-3 px-1 whitespace-nowrap">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Name Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Unit Price</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="border-b border-slate-200 dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100">
                    @if (empty($datadetailcheckout))
                        <tr>
                            <td colspan="6" class="py-3 px-1 text-center">Empty Data .</td>
                        </tr>
                    @else
                        @foreach ($datadetailcheckout as $item)
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <td class="py-3 px-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->itemAsset->masterAsset->asset_name }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->itemAsset->code_assets }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>
</x-layoutdsbd>