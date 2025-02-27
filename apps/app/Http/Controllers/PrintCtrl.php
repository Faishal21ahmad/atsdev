<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ItemAsset;
use App\Models\MasterAsset;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class PrintCtrl extends Controller
{
    public function showPrint(string $slug)
    {
        $user = Auth::user();
        $assetMaster = MasterAsset::where('slug', $slug)->firstOrFail();
        $dataPrint = ItemAsset::getByMasterAssetId($assetMaster->id);

        $data = [
            'title' => 'Print Identity',
            'sizePaper' => 'A3',
            'dataPrint' => $dataPrint,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];

        // Render tampilan Blade ke HTML
        $html = View::make('print', $data)->render();
        $path = trim(shell_exec('echo $PATH')) . ':' . trim(shell_exec('which node'));
        $pathchrome = trim(shell_exec('which google-chrome'));

        // Generate PDF langsung tanpa menyimpannya
        $pdf = Browsershot::html($html)
                            ->format('A3')
                            ->margins(10, 10, 10, 10)
                            ->setIncludePath($path)
                            ->setChromePath($pathchrome)
                            ->pdf();

        // Kirim response langsung ke browser
        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="ItemAssetCode.pdf"');
    }

    public function showPrint1(string $codeAsset)
    {
        $user = Auth::user();
        $dataPrint = ItemAsset::getBycodeItemAssets($codeAsset)->first();

        // dd($dataPrint);

        $data = [
            'title' => 'Print Identity',
            'sizePaper' => 'A5',
            'dataPrint'  => [$dataPrint],
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];

        // Render tampilan Blade ke HTML
        $html = View::make('print', $data)->render();
        $path = trim(shell_exec('echo $PATH')) . ':' . trim(shell_exec('which node'));
        $pathchrome = trim(shell_exec('which google-chrome'));

        // Generate PDF langsung tanpa menyimpannya
        $pdf = Browsershot::html($html)
                            ->format('A5')
                            ->margins(10, 10, 10, 10)
                            ->setIncludePath($path)
                            ->setChromePath($pathchrome)
                            ->pdf();

        // Kirim response langsung ke browser
        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="ItemAssetCode.pdf"');
    }

    

}
