<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\ItemAsset;
use App\Models\FileMainten;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Models\CheckoutItemDetail;
use App\Models\CheckinMasterDetail;
use Illuminate\Support\Facades\Auth;

class AuditCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAudit()
    {
        $user = Auth::user();
        $dataCheckinDetail = Checkin::getAllWithAssetTotals()->get();
        $dataCheckoutDetail = Checkout::getAllWithItemAssetCount()->get();
        $dataMaintenance = Maintenance::where('status_mainten', 'Finish')->get();
        
        $data = [
            'title' => 'Audit',
            'dataCheckoutDetail' => $dataCheckoutDetail,
            'dataMaintenance' => $dataMaintenance,
            'dataCheckinDetail' => $dataCheckinDetail,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
            ]
        ];

        return view('audit', $data);
    }

    public function showAuditCheckin(string $codecheckin) {
        $user = Auth::user();
        $datacheckin = Checkin::where('codecheckin', $codecheckin)->first();
        $datadetailcheckin = CheckinMasterDetail::where('check_in_id', $datacheckin->id)->get();
        $iddetailchk = $datadetailcheckin->pluck('id')->toArray();
        $dataitemasset = ItemAsset::whereIn('checkin_master_detail_id', $iddetailchk)->get();
        $data = [
            'title' => 'Audit Checkin',
            'codecheckin' => $codecheckin,
            'datacheckin' => $datacheckin,
            'datadetailcheckin' => $datadetailcheckin,
            'dataitemasset' => $dataitemasset,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
            ]
        ];
        return view('detailAuditCheckin', $data);
    }

    public function showAuditCheckout(string $codecheckout) {
        $user = Auth::user();
        $datacheckout = Checkout::where('codecheckout', $codecheckout)->first();
        $datadetailcheckout = CheckoutItemDetail::where('checkout_id', $datacheckout->id)->get();

        $data = [
            'title' => 'Audit Checkout',
            'codecheckout' => $codecheckout,
            'datacheckout' => $datacheckout,
            'datadetailcheckout' => $datadetailcheckout,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
            ]
        ];
        return view('detailAuditCheckout', $data);
    }

    public function showAuditMaintenance(string $codeMainten) {
        $user = Auth::user();
        $mainten = Maintenance::getByCodeMainten($codeMainten)->first();
        $fileProblem = FileMainten::getFileProblem($mainten->id);
        $fileRepaire = FileMainten::getFileRepaire($mainten->id);
        // Jika kosong, ubah menjadi null
        $fileProblem = $fileProblem->isEmpty() ? null : $fileProblem;
        $fileRepaire = $fileRepaire->isEmpty() ? null : $fileRepaire;
        
        $data = [
            'title' => 'Detail Maintenance',
            'mainten'  => $mainten,
            'fileProblem' => $fileProblem,
            'fileRepaire' => $fileRepaire,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('detailmaintenance', $data);
    }
}
