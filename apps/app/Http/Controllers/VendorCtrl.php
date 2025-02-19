<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'description' => 'required',
        ], [
            'vendorName.required' => 'Vendor Name is required',
            'contact.required' => 'Contact is required',
            'address.required' => 'Address is required',
            'description.required' => 'Description is required',
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
            'vendorName' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'description' => 'required',
        ], [
            'modalId.required' => 'Modal ID is required',
            'vendorName.required' => 'Vendor Name is required',
            'contact.required' => 'Contact is required',
            'address.required' => 'Address is required',
            'description.required' => 'Description is required',
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



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
