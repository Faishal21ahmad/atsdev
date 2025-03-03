<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Imports\DepartmentsImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class DepartementCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showDepartment()
    {
        $user = Auth::user();
        $departments = Department::active()->get();

        $data = [
            'title' => 'Department',
            'departments'  => $departments,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];

        return view('department', $data);
    }


    public function actionAddDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nameDepartment' => 'required',
            'description' => 'nullable',
        ], [
            'nameDepartment.required' => 'Name Department is required',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataDepartment = [
            'department_name' => $request->nameDepartment,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Department::create($dataDepartment);

        return redirect()->route('department')->with('alert', [
            'type' => 'success',
            'messages' => ['Department Berhasil ditambahkan !!'],
        ]);
    }


    public function actionUpdateDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modalId' => 'required',
            'nameDepartment' => 'nullable',
            'description' => 'nullable',
        ], [
            'modalId.required' => 'Modal Id is required',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataDepartment = [
            'department_name' => $request->nameDepartment,
            'description' => $request->description,
            'updated_at' => now(),
        ];

        Department::where('id', $request->modalId)->update($dataDepartment);

        return redirect()->route('department')->with('alert', [
            'type' => 'success',
            'messages' => ['Department Berhasil diubah !!'],
        ]);
    }

    public function actionDeleteDepartment(string $id)
    {
        $Department = Department::find($id);

        if (!$Department) {
            return redirect()->back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Department not found.'],
            ]);
            
        }
        // Hapus dengan soft delete
        $Department->delete();

        return redirect()->route('department')->with('alert', [
            'type' => 'success',
            'messages' => ['Department deleted !!'],
        ]);
    }


    public function importDeparmentExcel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        try {
            Excel::import(new DepartmentsImport, $request->file('file'));
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
