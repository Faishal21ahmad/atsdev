<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Imports\VendorsImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class VendorCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showVendor()
    {

        $user = Auth::user();
        $vendors = Vendor::active()->get();

        $data = [
            'title' => 'Vendor',
            'vendors'  => $vendors,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];

        return view('vendor', $data);
    }

    public function actionAddVendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendorName' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'description' => 'nullable'
        ], [
            'vendorName.required' => 'Vendor Name is required',
            'contact.required' => 'Contact is required',
            'address.required' => 'Address is required'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataVendor = [
            'vendor_name' => $request->vendorName,
            'contact' => $request->contact,
            'address' => $request->address,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Vendor::create($dataVendor);

        return redirect()->route('vendor')->with('alert', [
            'type' => 'success',
            'messages' => ['Vendor Berhasil ditambahkan !!'],
        ]);
    }


    public function actionUpdateVendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modalId' => 'required',
            'vendorName' => 'nullable',
            'contact' => 'nullable',
            'address' => 'nullable',
            'description' => 'nullable',
        ], [
            'modalId.required' => 'Modal ID is required'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataVendor = [
            'vendor_name' => $request->vendorName,
            'contact' => $request->contact,
            'address' => $request->address,
            'description' => $request->description,
            'updated_at' => now(),
        ];

        Vendor::where('id', $request->modalId)->update($dataVendor);

        return redirect()->route('vendor')->with('alert', [
            'type' => 'success',
            'messages' => ['Vendor Berhasil diubah !!'],
        ]);
    }


    public function actionDeleteVendor(string $id)
    {
        $Vendor = Vendor::find($id);

        if (!$Vendor) {
            return redirect()->back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Vendor not found.'],
            ]);
            
        }
        // Hapus dengan soft delete
        $Vendor->delete();

        return redirect()->route('vendor')->with('alert', [
            'type' => 'success',
            'messages' => ['Vendor deleted !!'],
        ]);
    }

    public function importVendorExcel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        try {
            Excel::import(new VendorsImport, $request->file('file'));
            return back()->with('alert', [
                'type' => 'success',
                'messages' => ['Data berhasil diimport!'],
            ]);
        } catch (Exception $e) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Import Gagal',$e->getMessage()],
            ]);
        }
    }
}
