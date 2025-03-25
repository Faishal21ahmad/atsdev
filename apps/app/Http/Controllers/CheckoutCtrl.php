<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\CheckoutItemDetail;
use App\Models\ItemAsset;
use App\Services\DocService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutCtrl extends Controller
{    
    // Show Check Out
    public function showCheckOut(){
        $user = Auth::user();
        $assetItem = ItemAsset::getItemAssetsWithMasterAsset();
        $vendors = Vendor::all();
        $itemCheckout = session()->get('itemCheckout', []);
        $total = $this->calculateTotal($itemCheckout);
        $data = [
            'title' => 'Check Out',
            'itemCheckout' => $itemCheckout,
            'vendors' => $vendors,
            'assetItem' => $assetItem,
            'total' => $total,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('checkout', $data);
    }

    public function actionAddcheckoutCart(Request $request)
    {   
        $validator = Validator::make($request->all(),[
            'codeAsset' =>'required|max:8',
            'price' =>'required|numeric',
            'nameAsset' =>'required|max:60',
        ],[
            'codeAsset.required' => 'Code Asset harus diisi !!.',
            'codeAsset.max' => 'Code Asset tidak valid !!.',
            'price.required' => 'Harga harus diisi !!.',
            'price.numeric' => 'Harga harus berupa angka !!.',
            'nameAsset.required' => 'Nama Asset harus diisi !!.',
            'nameAsset.max' => 'Nama Asset maksimal 60 karakter !!.',
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
            'codeAsset' => $request->codeAsset,
            'price' => $request->price,
            'nameAsset' => $request->nameAsset,
        ];
        $itemCheckout = session()->get('itemCheckout', []);
        $itemCheckout[] = $asset;
        session()->put('itemCheckout', $itemCheckout);

        return back()->with('alert', [
            'type' => 'success',
            'messages' => ['Berhasil ditambahkan'],
        ]);
    }

    public function actionRmfcheckoutCart(string $id)
    {
        $itemCheckout = session()->get('itemCheckout', []);
        $itemCheckout = array_filter($itemCheckout, function ($item) use ($id) {
            return $item['id'] !== $id;
        });
        session()->put('itemCheckout', $itemCheckout);
        return back()->with('alert', [
            'type' => 'success',
            'messages' => ['remove'],
        ]);
    }

    public function actionSavecheckoutCart(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'description' =>'required|max:300',
            'reason' =>'required|max:50',
            'vendor' =>'required|numeric',
            'pricetotal' =>'required|numeric',
        ], [
            'description.required' => 'Deskripsi harus diisi !!.',
            'description.max' => 'Deskripsi maksimal 300 karakter !!.',
            'reason.required' => 'Alasan harus diisi !!.',
            'reason.max' => 'Alasan maksimal 50 karakter !!.',
            'vendor.required' => 'Vendor harus diisi !!.',
            'vendor.numeric' => 'Vendor tidak valid !!.',
            'pricetotal.required' => 'Total Harga harus diisi !!.',
            'pricetotal.numeric' => 'Total Harga harus berupa angka !!.',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
        }

        // Ambil data cart dari session
        $itemCheckout = session()->get('itemCheckout', []);
        // Jika keranjang kosong, kembalikan ke halaman sebelumnya dengan pesan error
        if (count($itemCheckout) == 0) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Data item checkout kosong', 'Silahkan tambahkan item terlebih dahulu'],
            ]);
        }

        $user = Auth::user();

        // Mulai database transaction
        DB::beginTransaction();
        try {
            $docCode = DocService::generateDocumentCodeCheckOut();
            $dataCheckout = [
                'codecheckout' => $docCode,
                'user_id' => $user->id,
                'vendor_id' => $request->vendor,
                'reason' => $request->reason,
                'total' => $request->pricetotal,
                'description' => $request->description,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Simpan data checkout ke tabel checkout
            $checkout = Checkout::create($dataCheckout);
            
            // Rubah data status item asset menjadi checked out dan menambhkan id checout
            foreach ($itemCheckout as $item) {
                $itemAsset = ItemAsset::where('code_assets', $item['codeAsset'])->first();

                $dataCheckoutItemDetail = [
                    'checkout_id' => $checkout->id,
                    'item_asset_id' => $itemAsset->id,
                    'unit_price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Simpan data checkout item detail ke tabel checkout item detail
                CheckoutItemDetail::create($dataCheckoutItemDetail);

                // Update hanya kolom status
                $itemAsset->update([
                    'status' => 'Checked_out',
                    'updated_at' => now(),
                ]);
            }
            
            // Commit transaksi
            DB::commit();

            // Hapus session cart
            session()->forget('itemCheckout');

            return redirect()->route('asset')->with('alert', [
                'type' => 'success',
                'messages' => ['Check Out Berhasil'],
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

    // Menghitung total harga
    private function calculateTotal($itemCheckout)
    {
        $total = 0;
        foreach ($itemCheckout as $item) {
            $total += $item['price'];
        }
        return $total;
    }
}
