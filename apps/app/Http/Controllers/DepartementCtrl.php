<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'description' => 'required',
        ], [
            'nameDepartment.required' => 'Name Department is required',
            'description.required' => 'Description is required',
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
            'nameDepartment' => 'required',
            'description' => 'required',
        ], [
            'modalId.required' => 'Modal Id is required',
            'nameDepartment.required' => 'Name Department is required',
            'description.required' => 'Description is required',
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
