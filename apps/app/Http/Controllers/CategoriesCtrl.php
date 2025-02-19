<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CategoriesCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showCategory()
    {
        $user = Auth::user();
        $categories = Category::active()->get();
    
        $data = [
            'title' => 'Category',
            'categories'  => $categories,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];

        return view('category', $data);
    }



    public function actionAddCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nameCategory' => 'required',
            'description' => 'required',
        ], [
            'nameCategory.required' => 'Name Category is required',
            'description.required' => 'Description is required',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataCategory = [
            'category_name' => $request->nameCategory,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Category::create($dataCategory);

        return redirect()->route('category')->with('alert', [
            'type' => 'success',
            'messages' => ['Category Berhasil ditambahkan !!'],
        ]);
    }


    public function actionUpdateCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modalId' => 'required',
            'nameCategory' => 'required',
            'description' => 'required',
        ], [
            'modalId.required' => 'Modal Id is required',
            'nameCategory.required' => 'Name Category is required',
            'description.required' => 'Description is required',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataCategory = [
            'category_name' => $request->nameCategory,
            'description' => $request->description,
            'updated_at' => now(),
        ];

        Category::where('id', $request->modalId)->update($dataCategory);

        return redirect()->route('category')->with('alert', [
            'type' => 'success',
            'messages' => ['Category Berhasil diubah !!'],
        ]);
    }

    public function actionDeleteCategory(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Category not found.'],
            ]);
            
        }

        // Hapus dengan soft delete
        $category->delete();

        return redirect()->route('category')->with('alert', [
            'type' => 'success',
            'messages' => ['Category deleted !!'],
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
