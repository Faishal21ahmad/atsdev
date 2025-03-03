<?php
namespace App\Http\Controllers;

use App\Models\ItemAsset;
use App\Models\MasterAsset;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PrintCtrl extends Controller
{
    public function showPrint(string $slug)
    {
        try {
            Log::info("Processing print for slug: " . $slug);

            $assetMaster = MasterAsset::where('slug', $slug)->first();
            if (!$assetMaster) {
                Log::error("Master asset not found for slug: " . $slug);
                return response()->json(['error' => 'Asset not found'], 404);
            }

            $dataPrint = ItemAsset::getByMasterAssetId($assetMaster->id);
            if ($dataPrint->isEmpty()) {
                Log::error("No item assets found for master asset ID: " . $assetMaster->id);
                return response()->json(['error' => 'No items found'], 404);
            }

            $data = [
                'title' => 'Print Identity',
                'sizePaper' => 'A3',
                'dataPrint' => $dataPrint
            ];

            // Generate PDF langsung dari Blade view
            $pdf = Pdf::loadView('print', $data)
                ->setPaper($data['sizePaper'], 'portrait')
                ->setOption('isRemoteEnabled', true); // Aktifkan loading gambar eksternal

            return $pdf->stream('ItemAssetCode.pdf');
        } catch (\Throwable $e) {
            Log::error('Error in showPrint: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500);
        }
    }

    public function showPrint1(string $codeAsset)
    {
        try {
            Log::info("Processing print for codeAsset: " . $codeAsset);

            $dataPrint = ItemAsset::where('code_assets', $codeAsset)->first();
            if (!$dataPrint) {
                Log::error("No item assets found for codeAsset: " . $codeAsset);
                return response()->json(['error' => 'No items found'], 404);
            }

            $data = [
                'title' => 'Print Identity',
                'sizePaper' => 'A5',
                'dataPrint' => [$dataPrint] // Tetap kirim sebagai array untuk konsistensi
            ];

            $context = stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ]
            ]);
        

            // Generate PDF langsung dari Blade view
            $pdf = Pdf::loadView('print', $data)
                ->setPaper($data['sizePaper'], 'portrait')
                ->setOption([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => false,
                    'sslContext' => $context // Nonaktifkan akses remote
                ]); // Aktifkan loading gambar eksternal

            return $pdf->stream('ItemAssetCode.pdf');
        } catch (\Throwable $e) {
            Log::error('Error in showPrint1: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500);
        }
    }
}