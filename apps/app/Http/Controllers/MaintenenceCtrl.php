<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\ItemAsset;
use App\Models\Maintenance;
use App\Services\DocService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FileMainten;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MaintenenceCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showMaintenence(string $codeMainten)
    {
        $user = Auth::user();
        $mainten = Maintenance::getByCodeMainten($codeMainten)->firstOrFail();
        $fileProblem = FileMainten::getFileProblem($mainten->id);
        $fileRepaire = FileMainten::getFileRepaire($mainten->id);
        
        // Jika kosong, ubah menjadi null
        $fileProblem = $fileProblem->isEmpty() ? null : $fileProblem;
        $fileRepaire = $fileRepaire->isEmpty() ? null : $fileRepaire;
        
        
        $data = [
            'title' => 'Maintenance',
            'mainten'  => $mainten,
            'fileProblem' => $fileProblem,
            'fileRepaire' => $fileRepaire,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('maintenance', $data);
    }

    public function showReportMaintenence(string $codeAsset)
    {
        $user = Auth::user();
        $ItemAsset = ItemAsset::getBycodeItemAssets($codeAsset)->firstOrFail();

        $data = [
            'title' => 'Report Maintenance',
            'ItemAsset'  => $ItemAsset,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('reportmainten', $data);
    }

    public function actionReportMainten(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'itemAsset' => 'required',
            'codeAsset' => 'required', 
            'masterAsset' => 'required',
            'location' => 'required',
            'statusMainten' => 'required',
            'problemDetail' => 'required',
            'reportType' => 'required',
            'fileReport.*' => 'nullable|mimes:pdf,png,jpg,jpeg|max:2048',
        ], [
            'codeAsset.required' => 'Code Asset wajib diisi !!.',
            'itemAsset.required' => 'Item Asset wajib diisi !!.',
            'masterAsset.required' => 'Master Asset wajib diisi !!.',
            'location.required' => 'Location wajib diisi !!.',
            'statusMainten.required' => 'Status Maintenance wajib diisi !!.',
            'problemDetail.required' => 'Problem Detail wajib diisi !!.',
            'reportType.required' => 'Report Type wajib diisi !!.',
            'fileReport.*.mimes' => 'Image Upload harus berupa pdf, png, jpg, jpeg !!.',
            'fileReport.*.max' => 'Image Upload maksimal 2MB !!.',
        ]);
        
        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput('problemDetail','reportType','fileReport.*');
        }
        $codeAsset = $request->codeAsset;
        $documentCode = DocService::generateDocumentCodeMaintenance();
    
        $dataMainten = [
            'code_maintenance' => $documentCode,
            'item_asset_id' => $request->itemAsset,
            'master_asset_id' => $request->masterAsset,
            'location_id' => $request->location,
            'report_type' => $request->reportType,
            'problem_detail' => $request->problemDetail,
            'status_mainten' => $request->statusMainten,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Input data Maintenance ke database
        $maintenance = Maintenance::create($dataMainten);
        $maintenanceId = $maintenance->id; // Ambil ID Maintenance yang baru dibuat

        $dataItemAsset = ItemAsset::find($request->itemAsset);
        $dataItemAsset->update(['status' => 'Maintenance', 'updated_at' => now()]);

        // Jika ada file yang diunggah
        if ($request->hasFile('fileReport')) {
            $counter = 1; // Selalu mulai dari 1 untuk setiap request upload baru

            foreach ($request->file('fileReport') as $file) {
                // Generate nama file berdasarkan nomor urut dalam request
                $fileName = $codeAsset . '_1_' . $documentCode . '_' . $counter . '.' . $file->getClientOriginalExtension();

                // Simpan file ke storage/app/public/fileMainten
                $file->storeAs('fileMainten', $fileName, 'public');

                // Simpan informasi file ke database
                FileMainten::create([
                    'maintenance_id' => $maintenanceId,
                    'nameFile' => $fileName,
                    'type' => '1', // 1 = dokumen report
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $counter++; // Tambah nomor urut untuk file berikutnya
            }
        }

        
        return redirect()->route('itemAsset', $request->codeAsset )->with('alert', [
            'type' => 'success',
            'messages' => ['Permasalahan Berhasil di laporkan !!'],
        ]);
    }

    
    public function showResolveMainten(string $codeMainten)
    {
        $user = Auth::user();
        $dataMainten = Maintenance::getByCodeMainten($codeMainten)->first();
        $vendors = Vendor::active()->get();
        // Ambil data file berdasarkan ID Maintenance
        $imagesFile = FileMainten::getFileByIdMainten($dataMainten->id);
        // Jika data tidak ditemukan, atur imagesFile menjadi null
        if ($imagesFile->isEmpty()) {
            $imagesFile = null;
        }
        
        // Simpan data ke database
        $data = [
            'title' => 'Resolve Maintenance',
            'dataMainten'  => $dataMainten,
            'vendors' => $vendors,
            'imagesFile' => $imagesFile,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('resolveMainten', $data);
    }

    public function actionResolveMainten(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codeMaintence' => 'required',
            'idcodeMaintence' => 'required',
            'itemAsset' => 'required',
            'codeitemAsset' => 'required',
            'repairDetail' => 'required',
            'vendor' => 'required',
            'cost' => 'required',
            'statusResolve' => 'required',
            'fileReport.*' => 'nullable|mimes:pdf,png,jpg,jpeg|max:2048',
        ], [
            'codeMaintence.required' => 'Code Maintenance wajib diisi !!.',
            'idcodeMaintence.required' => 'Id Code Maintenance wajib diisi !!.',
            'itemAsset.required' => 'Item Asset wajib diisi !!.',
            'codeitemAsset.required' => 'Code Item Asset wajib diisi !!.',
            'repairDetail.required' => 'Repair Detail wajib diisi !!.',
            'vendor.required' => 'Vendor wajib diisi !!.',
            'cost.required' => 'Cost wajib diisi !!.',
            'statusResolve.required' => 'Status Resolve wajib diisi !!.',
            'fileReport.*.mimes' => 'Image Upload harus berupa pdf, png, jpg, jpeg !!.',
            'fileReport.*.max' => 'Image Upload maksimal 2MB !!.',
        ]);

        $status = $request->statusResolve == 'Finish' ? 'Available' : $request->statusResolve;

        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataMaintenRepare = [
            'vendor_id' => $request->vendor,
            'repaire_detail' => $request->repairDetail,
            'cost' => $request->cost,
            'status_mainten' => 'Finish',
            'date_mainten' => now(),
            'updated_at' => now(),
        ];

        // Jika ada file yang diunggah
        if ($request->hasFile('fileReport')) {
            $counter = 1; // Selalu mulai dari 1 untuk setiap request upload baru

            foreach ($request->file('fileReport') as $file) {
                // Generate nama file berdasarkan nomor urut dalam request
                $fileName = $request->codeitemAsset . '_2_' . $request->codeMaintence . '_' . $counter . '.' . $file->getClientOriginalExtension();

                // Simpan file ke storage/app/public/fileMainten
                $file->storeAs('fileMainten', $fileName, 'public');

                // Simpan informasi file ke database
                FileMainten::create([
                    'maintenance_id' => $request->idcodeMaintence,
                    'nameFile' => $fileName,
                    'type' => '2', // 1 = dokumen report
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $counter++; // Tambah nomor urut untuk file berikutnya
            }
        }

        $dataMainten = Maintenance::getByCodeMainten($request->codeMaintence)->first();
        $dataMainten->update($dataMaintenRepare);
        
        $dataItemAsset = ItemAsset::find($request->itemAsset);
        $dataItemAsset->update(['status' => $status, 'updated_at' => now()]);

        return redirect()->route('dashboard', $request->codeAsset )->with('alert', [
            'type' => 'success',
            'messages' => ['Permasalahan Berhasil di Perbaiki'],
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
