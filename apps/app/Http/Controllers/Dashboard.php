<?php
namespace App\Http\Controllers;

use App\Models\ItemAsset;
use App\Models\Maintenance;
use App\Models\MasterAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showDashboard()
    {
        $user = Auth::user();
        $totalasset = ItemAsset::countNotCheckedOut();
        $countlowStock = MasterAsset::countLowStockAssets();
        $getLowStockAssets = MasterAsset::getLowStockAssets();
        $getReportedMaintenances = Maintenance::getReportedMaintenances();

        $data = [
            'getLowStockAssets' => $getLowStockAssets,
            'getReportedMaintenances' => $getReportedMaintenances,
            'title' => 'Dashboard',
            'totalasset' => $totalasset,
            'countlowStock' => $countlowStock,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('dashboard', $data);
    }
}
