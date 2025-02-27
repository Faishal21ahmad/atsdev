<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\ItemAsset;
use App\Models\MasterAsset;
use Illuminate\Support\Str;
use App\Services\DocService;
use Illuminate\Http\Request;
use App\Imports\CheckinImport;
use Illuminate\Support\Facades\DB;
use App\Models\CheckinMasterDetail;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CheckinCtrl extends Controller
{
    // Show Check In
    public function showCheckin(){
        $user = Auth::user();
        $assetMaster = MasterAsset::active()->get();

        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        $data = [
            'title' => 'Check In',
            'assetMaster' => $assetMaster,
            'cart' => $cart,
            'total' => $total,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('checkin', $data);
    }

    // Menampilkan halaman check-in
    // Menambahkan asset ke keranjang
    public function actionAddCheckinCart(Request $request)
    {
        $asset = [
            'id' => uniqid(), // ID unik untuk setiap item
            'slug' => $request->slug,
            'nameAsset' => $request->nameAsset,
            'unitPrice' => $request->unitPrice,
            'quantity' => $request->quantity,
            'condition' => $request->condition,
        ];

        $cart = session()->get('cart', []);
        $cart[] = $asset;
        session()->put('cart', $cart);

        return back()->with('alert', [
            'type' => 'success',
            'messages' => [],
        ]);

        // return redirect()->route('showCheckIn')->with('success', 'Asset berhasil ditambahkan ke keranjang!');
    }

    // Menghapus asset dari keranjang
    public function actionRmfCheckinCart($id)
    {
        $cart = session()->get('cart', []);
        $cart = array_filter($cart, function ($item) use ($id) {
            return $item['id'] !== $id;
        });
        session()->put('cart', $cart);
        return back()->with('alert', [
            'type' => 'success',
            'messages' => ['remove'],
        ]);
        // return redirect()->route('showCheckIn')->with('success', 'Asset berhasil dihapus dari keranjang!');
    }

    public function actionSaveCheckinCart(Request $request){
        // Validasi data
        // $request->validate([
        //     'description' => 'required|string',
        //     'total' => 'required|numeric',
        // ]);

        // Ambil data cart dari session
        $cart = session()->get('cart', []);

        // Jika keranjang kosong, kembalikan ke halaman sebelumnya dengan pesan error
        if (count($cart) == 0) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Keranjang kosong, tidak ada asset yang dipilih.'],
            ])->onlyInput();
        }

        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Generate kode checkin
            $docCode = DocService::generateDocumentCodeCheckin();

            // Data Checkin
            $dataCheckin = [
                'codecheckin' => $docCode,
                'description' => $request->description,
                'total' => $request->total,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Input data Checkin ke tabel checkin
            $checkin = Checkin::create($dataCheckin);

            // Loop data cart
            foreach ($cart as $item) {
                // Proses Master Asset
                $dataMasterAsset = MasterAsset::updateOrCreate(
                    ['slug' => $item['slug']],
                    [
                        'asset_name' => $item['nameAsset'],
                        'slug' => $item['slug'] ?? Str::slug($item['nameAsset']),
                        'updated_at' => now(),
                    ]
                );

                // Update current_stock secara manual
                $dataMasterAsset->current_stock += $item['quantity'];
                $dataMasterAsset->save();

                // Data Checkin Master Detail
                $dataCheckinMasterDetail = CheckinMasterDetail::create([
                    'check_in_id' => $checkin->id,
                    'master_asset_id' => $dataMasterAsset->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unitPrice'],
                    'sub_total' => $item['quantity'] * $item['unitPrice'],
                    'created_at' => now(),
                ]);

                // Looping sebanyak nilai $item['quantity']
                $itemAssets = [];
                for ($i = 0; $i < $item['quantity']; $i++) {
                    $codeAsset = DocService::generateCodeAssets();

                    $qrPath = 'fileQR/' . $codeAsset . '.svg';
                    QrCode::size(300)->format('svg')->generate($codeAsset, storage_path('app/public/' . $qrPath));

                    $itemAssets[] = [
                        'master_asset_id' => $dataMasterAsset->id,
                        'checkin_master_detail_id' => $dataCheckinMasterDetail->id,
                        'code_assets' => $codeAsset, // Generate kode unik untuk setiap item
                        'status' => 'Available',
                        'condition' => $item['condition'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                // Bulk insert untuk item asset
                ItemAsset::insert($itemAssets);
            }
            // Commit transaksi
            DB::commit();

            // Hapus session cart
            session()->forget('cart');

            return redirect()->route('asset')->with('alert', [
                'type' => 'success',
                'messages' => ['Check IN Berhasil'],
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Terjadi kesalahan: ' . $e->getMessage()],
            ]);
        }
    }

    // Import data excel ke cart
    public function importCheckinExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new CheckinImport, $request->file('file'));
            return back()->with('success', 'Data berhasil diimport ke cart!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    // Menghitung total harga
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['unitPrice'] * $item['quantity'];
        }
        return $total;
    }

}



// Menyimpan keranjang (checkout)
    // public function actionSaveCheckinCart(Request $request)
    // {
    //     // get data cart form session
    //     $cart = session()->get('cart', []);

    //     // Jika keranjang kosong, kembalikan ke halaman sebelumnya dengan pesan error
    //     if(count($cart) == 0){
    //         return back()->with('alert', [
    //             'type' => 'danger',
    //             'messages' => ['Keranjang kosong, tidak ada asset yang dipilih.'],
    //         ])->onlyInput();
    //     }
    //     // generate code check in
    //     $docCode = DocService::generateDocumentCodeCheckin();

    //     $dataCheckin = [
    //         'codecheckin' => $docCode,
    //         'description' => $request['description'],
    //         'total' => $request['total'],
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ];
    //     // Input data Checkin ke tabel checkin
    //     $checkin = Checkin::create($dataCheckin);

    //     // Loop data cart untuk input data dan pengecekan data master asset
    //     foreach ($cart as $item) {
    //         // Cek apakah slug ada di tabel master asset
    //         // Untuk keperluan penambahan data master aset baru maupun pembaruan data yang sudah ada.
    //         if ($item['slug']) {
    //             // Slug ada Update data master asset
    //             $dataMasterAsset = MasterAsset::where('slug', $item['slug'])->first();
    //             // Susunan data Update master asset
    //             $dataMaster = [
    //                 'current_stock' => $dataMasterAsset->current_stock + $item['quantity'],
    //                 'updated_at' => now(),
    //             ];
    //             // Update data master asset
    //             $dataMasterAsset->update($dataMaster);

    //         } else { // Slug = null
    //             // Generate slug
    //             $slug = Str::slug($item['nameAsset']);
    //             // Susunan data input master asset
    //             $dataMaster = [
    //                 'asset_name' => $item['nameAsset'],
    //                 'slug' => $slug,
    //                 'category_id' => null,
    //                 'interval_maintence' => null,
    //                 'min_stock' => null,
    //                 'current_stock' => $item['quantity'],
    //                 'description' => null,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //             // Input data ke master asset 
    //             $dataMasterAsset = MasterAsset::create($dataMaster);
    //         }
    //         // Susunan data checkin_master_detail
    //         $dataCheckinMasterDetail = [
    //             'check_in_id' => $checkin['id'],
    //             'master_asset_id' => $dataMasterAsset['id'],
    //             'quantity' => $item['quantity'],
    //             'unit_price' => $item['unitPrice'],
    //             'sub_total' => $item['quantity'] * $item['unitPrice'],
    //             'created_at' => now(),
    //         ];
    //         // Input data Tabel Privot checkin_master_detail
    //         $dataCheckinMasterDetail = CheckinMasterDetail::create($dataCheckinMasterDetail);

    //         // Looping sebanyak nilai $item['quantity']
    //         for ($i = 0; $i < $item['quantity']; $i++) {
    //             // Susunan data item asset
    //             $dataNewItemAsset = [
    //                 'master_asset_id' => $dataMasterAsset['id'],
    //                 'checkin_master_detail_id' => $dataCheckinMasterDetail['id'],
    //                 'code_assets' => DocService::generateCodeAssets(), // Generate kode unik untuk setiap item
    //                 'status' => 'Available',
    //                 'condition' => $item['condition'],
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //             // Input data item asset
    //             ItemAsset::create($dataNewItemAsset);
    //         }
    //     };
    //     session()->forget('cart'); // Kosongkan keranjang setelah checkout

    //     return redirect()->route('asset')->with('alert', [
    //         'type' => 'success',
    //         'messages' => ['Check IN Berhasil'],
    //     ]);
    // }