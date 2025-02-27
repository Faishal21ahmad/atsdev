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
            'nameLocation' => 'required',
            'description' => 'required',
        ], [
            'nameLocation.required' => 'Name Location is required',
            'description.required' => 'Description is required',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
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
            'modalId' => 'required',
            'nameLocation' => 'required',
            'description' => 'required',
        ], [
            'modalId.required' => 'Modal Id is required',
            'nameLocation.required' => 'Name Location is required',
            'description.required' => 'Description is required',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
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
            
            // abort(400, 'Bad Request: HTTP method is required.');
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
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

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
