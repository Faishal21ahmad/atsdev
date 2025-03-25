<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Imports\LocationsImport;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class LocationCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showLocation()
    {
        $user = Auth::user();
        $locations = Location::active()->get();
        $data = [
            'title' => 'Location',
            'locations'  => $locations,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];

        return view('location', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function actionAddLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nameLocation' => 'required|max:60',
            'description' => 'nullable|max:300',
        ], [
            'nameLocation.required' => 'Name Location is required',
            'nameLocation.max' => 'Name Location maximal 60 characters',
            'description.max' => 'Description maximal 300 characters'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
        }

        $dataLocation = [
            'location_name' => $request->nameLocation,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Location::create($dataLocation);

        return redirect()->route('location')->with('alert', [
            'type' => 'success',
            'messages' => ['Location Berhasil ditambahkan !!'],
        ]);
    }


    public function actionUpdateLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modalId' => 'required|numeric',
            'nameLocation' => 'nullable|max:60',
            'description' => 'nullable|max:300',
        ], [
            'modalId.required' => 'Location is not valid !!.',
            'modalId.numeric' => 'Location is not valid !!.',
            'nameLocation.max' => 'Name Location maximal 60 characters !!.',
            'description.max' => 'Description maximal 300 characters !!.'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert !!.', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
        }

        $dataLocation = [
            'location_name' => $request->nameLocation,
            'description' => $request->description,
            'updated_at' => now(),
        ];

        Location::where('id', $request->modalId)->update($dataLocation);

        return redirect()->route('location')->with('alert', [
            'type' => 'success',
            'messages' => ['Location Berhasil diubah !!'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function actionDeleteLocation(Request $request, $id)
    {
        if (!$request->method()) {
            return redirect()->back()->with('alert', [
                'type' => 'danger',
                'messages' => ['400 Bad Request: HTTP method is required.'],
            ]);
        }
        
        $location = Location::findOrFail($id);

        if (!$location) {
            return redirect()->back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Location not found.'],
            ]);
            
        }

        // Hapus dengan soft delete
        $location->delete();

        return redirect()->route('location')->with('alert', [
            'type' => 'success',
            'messages' => ['Location deleted !!'],
        ]);
    }

    public function importLocationExcel(Request $request){
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
            Excel::import(new LocationsImport, $request->file('file'));
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
