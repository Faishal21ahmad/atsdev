<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CheckinImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $cart = Session::get('cart', []); // Ambil data cart dari session

        foreach ($rows as $row) {
            $asset = [
                'id' => uniqid(), // ID unik untuk setiap item
                'slug' => strtolower(str_replace(' ', '-', $row['assets_name'])), // Generate slug dari nama asset
                'nameAsset' => $row['assets_name'],
                'unitPrice' => $row['price_per_unit'],
                'quantity' => $row['quantity'],
                'condition' => $row['condition'],
            ];

            $cart[] = $asset; // Tambahkan asset ke cart
        }

        Session::put('cart', $cart); // Simpan cart ke session
    }
}
