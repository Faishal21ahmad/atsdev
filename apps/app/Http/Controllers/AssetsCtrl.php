<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\ItemAsset;
use App\Models\Department;
use App\Models\Maintenance;
use App\Models\MasterAsset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssetsCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAsset()
    {
        $user = Auth::user();
        $assetMaster = MasterAsset::active()->get();

        $data = [
            'title' => 'Asset',
            'assetMaster'  => $assetMaster,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('asset', $data);
    }
    // Show Master Asset
    public function showMasterAsset(string $slug)
    {
        $user = Auth::user();
        $assetMaster = MasterAsset::where('slug', $slug)->firstOrFail();
        $dataItemByAms = ItemAsset::getByMasterAssetId($assetMaster->id);
        $dataCategory = Category::active()->get();

        $data = [
            'title' => 'Master Asset',
            'assetMaster'  => $assetMaster,
            'dataItemByAms' => $dataItemByAms,
            'dataCategory' => $dataCategory,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('masterasset', $data);
    }

    // Action Edit Master Asset
    public function actionEditMasterAsset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required',
            'nameAsset' => 'required',
            'category' => 'nullable',
            'maintenInterval' => 'nullable',
            'stockMinimum' => 'nullable',
            'fileImg' => 'nullable|mimes:pdf,png,jpg,jpeg|max:2048',
            'description' => 'nullable',
        ], [
            'slug.required' => 'Slug wajib diisi !!.',
            'nameAsset.required' => 'Name Asset wajib diisi !!.',
            'fileImg.mimes' => 'Image Upload harus berupa pdf, png, jpg, jpeg !!.',
            'fileImg.max' => 'Image Upload maksimal 2MB !!.',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }
        
        $slugNew = Str::slug($request->nameAsset);
        $file = $request->file('fileImg');
        $fileOld = $request->fileOld;
        $fileName = $fileOld;    
        // Jika ada file yang diunggah
        if ($file) {
            // Generate nama file berdasarkan nomor urut dalam request
            $fileName = $slugNew . '.' . $file->getClientOriginalExtension();
            // Simpan file ke folder storage/fileMasterAsset
            $file->storeAs('fileMasterAsset', $fileName, 'public');

            $filePath = public_path('storage/fileMasterAsset/' . $fileOld);
            if (!empty($fileOld)) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $dataUpdateMasterAsset = [
            'asset_name' => $request->nameAsset,
            'slug' => $slugNew,
            'category_id' => $request->category,
            'interval_maintence' => $request->maintenInterval,
            'min_stock' => $request->stockMinimum,
            'description' => $request->description,
            'image_name' => $fileName,
            'updated_at' => now(),
        ];

        MasterAsset::where('slug', $request->slug)->update($dataUpdateMasterAsset);

        return redirect()->route('masterAsset', $slugNew )->with('alert', [
            'type' => 'success',
            'messages' => ['Update Berhasil'],
        ]);
    }

    // Show Item Asset
    public function showItemAsset(string $codeAsset)
    {
        $user = Auth::user();
        $dataItem = ItemAsset::getBycodeItemAssets($codeAsset)->first();
        $location = Location::active()->get();
        $department = Department::active()->get();

        if(!$dataItem){
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Code '.$codeAsset.' Tidak Ditemukan'],
            ]);
        }

        $dataMaintenenceItem = Maintenance::getByIditemAsset($dataItem->id);

        $data = [
            'title' => 'Item Asset',
            'dataItem' => $dataItem,
            'location' => $location,
            'department' => $department,
            'dataMaintenenceItem' => $dataMaintenenceItem,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('itemasset', $data);
    }

    // Action Edit Item Asset
    public function actionEditItemAsset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codeAsset' => 'required',
            'condition' => 'nullable',
            'location' => 'nullable',
            'departement' => 'nullable',
            'description' => 'nullable'
        ], [
            'codeAsset.required' => 'Code Asset wajib diisi !!.'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataUpdateItemAsset = [
            'condition' => $request->condition,
            'location_id' => $request->location,
            'department_id' => $request->departement,
            'description' => $request->description,
            'updated_at' => now(),
        ];

        ItemAsset::where('code_assets', $request->codeAsset)->update($dataUpdateItemAsset);

        return redirect()->route('itemAsset', $request->codeAsset )->with('alert', [
            'type' => 'success',
            'messages' => ['Update Berhasil'],
        ]);
    }

}
