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
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CheckinCtrl extends Controller
{
    // Show Check In
    public function showCheckin($slug = null){
        if($slug) $nameMastarAsset = MasterAsset::where('slug', $slug)->first();
        else $nameMastarAsset = '';

        $user = Auth::user();
        $assetMaster = MasterAsset::active()->get();
        $vendors = Vendor::active()->get();

        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        $data = [
            'title' => 'Check In',
            'assetMaster' => $assetMaster,
            'nameMastarAsset' => $nameMastarAsset,
            'vendors' => $vendors,
            'cart' => $cart,
            'total' => $total,
            'user' => [
                'id' => $user->id,
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('checkin', $data);
    }

    // Menambahkan asset ke keranjang
    public function actionAddCheckinCart(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(),[
            'nameAsset' =>'required|max:60',
            'slug' =>'nullable',
            'unitPrice' =>'required|numeric',
            'quantity' =>'required|numeric|max:500',
            'condition' =>'required|max:60',
        ], [
            'nameAsset.required' => 'Name Asset is required',
            'nameAsset.max' => 'Name Asset maximal 60 characters',
            'unitPrice.required' => 'Unit Price is required',
            'unitPrice.numeric' => 'Unit Price is number',
            'quantity.required' => 'Quantity is required',
            'quantity.numeric' => 'Quantity is number',
            'quantity.max' => 'Quantity max 500',
            'condition.required' => 'Condition is required',
            'condition.max' => 'Condition maximal 60 characters',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
        }

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
            'messages' => ['Asset berhasil ditambahkan'],
        ]);
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
            'messages' => ['Asset berhasil Remove'],
        ]);
    }

    public function actionSaveCheckinCart(Request $request){
        // Validasi data
        $validator = Validator::make($request->all(),[
            'description' => 'nullable|max:300',
            'vendor' =>'required|numeric',
            'total' => 'required|numeric',
        ], [
            'description.max' => 'Description maximal 300 characters',
            'vendor.numeric' => 'Vendor tidak valid !!.',
            'vendor.required' => 'Vendor is required !!.',
            'total.required' => 'Total is required !!.',
            'total.numeric' => 'Total tidak valid !!.',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
        }

        $cart = session()->get('cart', []);

        // Jika keranjang kosong, kembalikan ke halaman sebelumnya dengan pesan error
        if (count($cart) == 0) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Keranjang kosong, tidak ada asset yang dipilih.'],
            ]);
        }

        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Generate kode checkin
            $docCode = DocService::generateDocumentCodeCheckin();

            // Data Checkin
            $dataCheckin = [
                'codecheckin' => $docCode,
                'user_id' => Auth::id(),
                'vendor_id' => $request->vendor,
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
                'messages' => ['Check In Berhasil'],
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
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:500',
        ],[
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'File harus berupa excel',
            'file.max' => 'File maksimal 500KB',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
        }

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
