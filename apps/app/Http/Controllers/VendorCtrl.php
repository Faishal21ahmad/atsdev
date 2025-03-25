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
            'vendorName' => 'required|max:60',
            'contact' => 'required|string|max:20',
            'address' => 'required|string|max:300',
            'description' => 'nullable|max:300',
        ], [
            'vendorName.required' => 'Vendor Name is required',
            'vendorName.max' => 'Vendor Name maximal 60 characters',
            'contact.required' => 'Contact is required',
            'contact.max' => 'Contact maximal 20 characters',
            'contact.string' => 'Contact must be a string',
            'address.required' => 'Address is required',
            'address.max' => 'Address maximal 300 characters',
            'address.string' => 'Address must be a string',
            'description.max' => 'Description maximal 300 characters'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
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
            'modalId' => 'required|numeric',
            'vendorName' => 'nullable|string|max:60',
            'contact' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:300',
            'description' => 'nullable|string|max:300',
        ], [
            'modalId.required' => 'Vendor is not valid',
            'modalId.numeric' => 'Vendor is not valid',
            'vendorName.required' => 'Vendor Name is required',
            'vendorName.max' => 'Vendor Name maximal 60 characters',
            'contact.required' => 'Contact is required',
            'contact.max' => 'Contact maximal 20 characters',
            'contact.string' => 'Contact must be a string',
            'address.required' => 'Address is required',
            'address.max' => 'Address maximal 300 characters',
            'address.string' => 'Address must be a string',
            'description.max' => 'Description maximal 300 characters'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
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
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx,csv|max:500',
        ], [
            'file.required' => 'File is required',
            'file.mimes' => 'File must be a file of type: xls, xlsx, csv',
            'file.max' => 'File size must be less than 500 KB',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
        }

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
