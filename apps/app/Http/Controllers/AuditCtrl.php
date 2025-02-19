<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAudit()
    {
        $user = Auth::user();
        $dataCheckin = Checkin::active()->get();
        $dataCheckout = Checkout::active()->get();
        $dataMaintenance = Maintenance::active()->get();


        $data = [
            'title' => 'Audit',
            'dataCheckin' => $dataCheckin,
            'dataCheckout' => $dataCheckout,
            'dataMaintenance' => $dataMaintenance,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
            ]
        ];

        return view('audit', $data);
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
