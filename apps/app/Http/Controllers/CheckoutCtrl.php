<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\ItemAsset;
use App\Services\DocService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutCtrl extends Controller
{    
    // Show Check Out
    public function showCheckOut(){
        $user = Auth::user();
        $assetItem = ItemAsset::getItemAssetsWithMasterAsset();
        $itemCheckout = session()->get('itemCheckout', []);

        $data = [
            'title' => 'Check Out',
            'itemCheckout' => $itemCheckout,
            'assetItem' => $assetItem,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('checkout', $data);
    }

    public function actionAddcheckoutCart(Request $request)
    {
        $asset = [
            'id' => uniqid(), // ID unik untuk setiap item
            'codeAsset' => $request->codeAsset,
            'nameAsset' => $request->nameAsset,
        ];
        $itemCheckout = session()->get('itemCheckout', []);
        $itemCheckout[] = $asset;
        session()->put('itemCheckout', $itemCheckout);

        return back()->with('alert', [
            'type' => 'success',
            'messages' => [],
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
            // Ambil data cart dari session
        $itemCheckout = session()->get('itemCheckout', []);

        // Jika keranjang kosong, kembalikan ke halaman sebelumnya dengan pesan error
        if (count($itemCheckout) == 0) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Keranjang kosong, tidak ada asset yang dipilih.'],
            ])->onlyInput();
        }

        // Mulai database transaction
        DB::beginTransaction();
        try {
            $docCode = DocService::generateDocumentCodeCheckOut();
            $dataCheckout = [
                'codecheckout' => $docCode,
                'description' => $request->description,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Simpan data checkin ke tabel checkin
            $checkin = Checkout::create($dataCheckout);

            // Rubah data status item asset menjadi checked out dan menambhkan id checout

            foreach ($itemCheckout as $item) {
                
                $dataUpdateItemAsset = [
                    'status' => 'Checked_out',
                    'check_out_id' => $checkin->id,
                    'updated_at' => now(),
                ];

                $itemAsset = ItemAsset::where('code_assets', $item['codeAsset'])->first();
                $itemAsset->update($dataUpdateItemAsset);
            }
            
            // Commit transaksi
            DB::commit();

            // Hapus session cart
            session()->forget('itemCheckout');

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


}
