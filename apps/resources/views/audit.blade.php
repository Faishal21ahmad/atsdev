<x-layoutdsbd title="{{ $title }}" user="{{ $user['name'] }}" role="{{ $user['role'] }}">

    <div class="mx-auto w-full overflow-x-auto h-16 scrollbar-thin scrollbar-thumb-rounded-full  scrollbar-thumb-slate-300  scrollbar-track-slate-100  dark:scrollbar-thumb-slate-300  dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full  scrollbar-track-rounded-full">
        <div class="w-full flex gap-3">
            <button id="checkinbtn" class="tab-button px-5 sm:px-10 py-2 shadow-md bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-md">CheckIn</button>
            <button id="checkoutbtn" class="tab-button px-5 sm:px-10 py-2 shadow-md bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-md">CheckOut</button>
            <button id="maintenancebtn" class="tab-button px-5 sm:px-10 py-2 shadow-md bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-md">Mantenece</button>
        </div>
    </div>

    <section id="checkin" class="mx-auto w-full text-white overflow-hidden">
        <div class="w-full flex justify-between">
            <h1 class="text-2xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap">Check in</h1>
        </div>
        <div class="w-full overflow-x-auto max-h-screen overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full  scrollbar-thumb-slate-300  scrollbar-track-slate-100  dark:scrollbar-thumb-slate-300  dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full  scrollbar-track-rounded-full">
            <table id="tableList" class="table-auto w-full text-left overflow-x-auto">
                <thead>
                    <tr class="sticky top-0 text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-800 shadow-md">
                        <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Checkin</th>
                        <th class="py-3 px-1 whitespace-nowrap">Date In</th>
                        <th class="py-3 px-1 whitespace-nowrap">Master Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Item Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Total Price</th>
                        <th class="py-3 px-1 whitespace-nowrap text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="border-b border-slate-200 dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100">
                    @if (empty($dataCheckinDetail))
                        <tr>
                            <td colspan="6" class="py-3 px-1 text-center">Empty Data .</td>
                        </tr>
                    @else
                        @foreach ($dataCheckinDetail as $index => $item)
                            <tr class="text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-700 rounded-md">
                                <td class="py-3 px-1 whitespace-nowrap text-center">{{ $loop->iteration }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->codecheckin }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->created_at)->format('d / M / Y') }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->total_master_asset }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->total_item_asset }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                                <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-center">
                                    <a href="{{ route('audit.checkin', $item->codecheckin ) }}" class="py-2 px-4 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md ">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <section id="checkout" class="hidden mx-auto w-full text-white">
        <div class="w-full flex justify-between">
            <h1 class="text-2xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap overflow-hidden">Check out</h1>
        </div>
        <div class="w-full overflow-x-auto max-h-screen overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full  scrollbar-thumb-slate-300  scrollbar-track-slate-100  dark:scrollbar-thumb-slate-300  dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full  scrollbar-track-rounded-full">
            <table id="tableList" class="table-auto w-full text-left">
                <thead>
                    <tr class="sticky top-0 text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-800 shadow-md">
                        <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Checkout</th>
                        <th class="py-3 px-1 whitespace-nowrap">Item Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Date out</th>
                        <th class="py-3 px-1 whitespace-nowrap">Vendor</th>
                        <th class="py-3 px-1 whitespace-nowrap text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="border-b border-slate-200 dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100">
                    @if (empty($dataCheckoutDetail))
                    <tr>
                        <td colspan="6" class="py-3 px-1 text-center">Empty Data .</td>
                    </tr>
                @else
                    @foreach ($dataCheckoutDetail as $index => $item)
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <td class="py-3 px-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $item['codecheckout'] }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $item->total_item_asset }}</td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->created_at)->format('d / m / Y') }} </td>
                            <td class="py-3 px-1 whitespace-nowrap">{{ $item->vendor_name }}</td>
                            <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-center">
                                <a href="{{ route('audit.checkout', $item->codecheckout ) }}" class="py-2 px-4 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md ">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        
    </section>

    <section id="maintenance" class="hidden mx-auto w-full">
        <div class="w-full flex justify-between">
            <h1 class="text-2xl py-2 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap overflow-hidden">Maintenance</h1>
        </div>

        <div class="w-full overflow-x-auto max-h-screen overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full  scrollbar-thumb-slate-300  scrollbar-track-slate-100  dark:scrollbar-thumb-slate-300  dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full  scrollbar-track-rounded-full">
            <table id="tableList" class="table-auto w-full text-left">
                <thead>
                    <tr class="sticky top-0 text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-900 border-b-2 border-slate-200 dark:border-slate-800 shadow-md">
                        <th class="py-3 px-1 whitespace-nowrap text-center">No</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Maintenance</th>
                        <th class="py-3 px-1 whitespace-nowrap">Date Report</th>
                        <th class="py-3 px-1 whitespace-nowrap">Name Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Code Asset</th>
                        <th class="py-3 px-1 whitespace-nowrap">Status</th>
                        <th class="py-3 px-1 whitespace-nowrap text-center">Action</th>
                    </tr>
                </thead>
               
                <tbody id="tableBody" class="border-b  border-slate-200 dark:border-slate-700 rounded-md text-slate-900 dark:text-slate-100  ">
                    @if (empty($dataMaintenance))
                        <tr>
                            <td colspan="6" class="py-3 px-1 text-center">Empty Data .</td>
                        </tr>
                    @else
                        @foreach ($dataMaintenance as $index => $item)
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <td class="py-3 px-1 whitespace-nowrap text-center">{{ $loop->iteration }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item['code_maintenance'] }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->created_at)->format('d / m / Y') }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->itemAsset->masterAsset->asset_name }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->itemAsset->code_assets }}</td>
                                <td class="py-3 px-1 whitespace-nowrap">{{ $item->status_mainten }}</td>
                                <td class="py-3 px-2 whitespace-nowrap max-w-[20ch] truncate text-center">
                                    <a href="{{ route('audit.mainten', $item->code_maintenance ) }}" class="py-2 px-4 text-center shadow-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white rounded-md ">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.tab-button');

            // Ambil tab terakhir dari localStorage, jika tidak ada default ke 'checkinbtn'
            let activeTab = localStorage.getItem('activeTab') || 'checkinbtn';

            // Fungsi untuk mengaktifkan tab berdasarkan ID
            function activateTab(tabId) {
                // Simpan status ke localStorage
                localStorage.setItem('activeTab', tabId);

                // Reset semua tombol ke warna default
                buttons.forEach(btn => {
                    btn.classList.remove('bg-slate-300', 'dark:bg-slate-600');
                    btn.classList.add('bg-slate-100', 'hover:bg-slate-200', 'dark:bg-slate-800', 'dark:hover:bg-slate-700', 'dark:text-white');
                });

                // Aktifkan tombol yang diklik
                const activeButton = document.getElementById(tabId);
                if (activeButton) {
                    activeButton.classList.remove('bg-slate-100', 'hover:bg-slate-200', 'dark:bg-slate-800', 'dark:hover:bg-slate-700');
                    activeButton.classList.add('bg-slate-300', 'dark:bg-slate-600');
                }

                // Sembunyikan semua div konten
                document.getElementById('checkin').classList.add('hidden');
                document.getElementById('checkout').classList.add('hidden');
                document.getElementById('maintenance').classList.add('hidden');

                // Tampilkan div yang sesuai
                if (tabId === 'checkinbtn') document.getElementById('checkin').classList.remove('hidden');
                else if (tabId === 'checkoutbtn') document.getElementById('checkout').classList.remove('hidden');
                else if (tabId === 'maintenancebtn') document.getElementById('maintenance').classList.remove('hidden');
            }
            // Set tab terakhir saat halaman dimuat
            activateTab(activeTab);
            // Event listener untuk setiap tombol
            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    activateTab(this.id);
                });
            });

            // Pastikan tab tetap aktif ketika pengguna kembali dari halaman lain
            window.addEventListener('pageshow', function () {
                let savedTab = localStorage.getItem('activeTab') || 'checkinbtn';
                activateTab(savedTab);
            });
        });
    </script>
</x-layoutdsbd>