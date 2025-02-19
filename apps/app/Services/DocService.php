<?php

namespace App\Services;

use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\Maintenance;
use Illuminate\Support\Carbon;

use App\Models\ItemAsset;
use Illuminate\Support\Str;

class DocService
{
    public static function generateDocumentCodeMaintenance(): string
    {
        $today = Carbon::now()->format('dmY');

        // Ambil dokumen terakhir dari database
        $lastDocument = Maintenance::where('code_maintenance', 'LIKE', "MTN{$today}%")
            ->orderBy('code_maintenance', 'desc')
            ->first();

        if ($lastDocument) {
            // Pecah kode menggunakan regex untuk mengambil bagian-bagian
            preg_match('/MTN(\d{8})([A-Z])(\d{3})/', $lastDocument->code_maintenance, $matches);
            
            $lastSeries = $matches[2];  // Ambil huruf seri
            $lastNumber = intval($matches[3]);  // Ambil nomor urutan terakhir
        } else {
            // Jika tidak ada dokumen, mulai dari A001
            $lastSeries = 'A';
            $lastNumber = 0;
        }

        // Tambahkan nomor
        $newNumber = $lastNumber + 1;

        // Jika mencapai 999, naik ke huruf seri berikutnya
        if ($newNumber > 999) {
            $lastSeries = chr(ord($lastSeries) + 1); // Naik huruf
            $newNumber = 1; // Reset ke 001

            // Jika huruf seri melebihi 'Z', reset ke 'A'
            if (ord($lastSeries) > ord('Z')) {
                $lastSeries = 'A';
            }
        }

        // Format nomor menjadi 3 digit (001, 002, ..., 999)
        $docNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Buat kode dokumen dalam format yang diinginkan
        $newDocumentCode = "MTN{$today}{$lastSeries}{$docNumber}";

        // Simpan ke database

        return $newDocumentCode;
    }

    public static function generateDocumentCodeCheckin(): string
    {
        $today = Carbon::now()->format('dmY');

        // Ambil dokumen terakhir dari database
        $lastDocument = Checkin::where('codecheckin', 'LIKE', "CHI{$today}%")
            ->orderBy('codecheckin', 'desc')
            ->first();

        if ($lastDocument) {
            // Pecah kode menggunakan regex untuk mengambil bagian-bagian
            preg_match('/CHI(\d{8})([A-Z])(\d{3})/', $lastDocument->codecheckin, $matches);
            
            $lastSeries = $matches[2];  // Ambil huruf seri
            $lastNumber = intval($matches[3]);  // Ambil nomor urutan terakhir
        } else {
            // Jika tidak ada dokumen, mulai dari A001
            $lastSeries = 'A';
            $lastNumber = 0;
        }

        // Tambahkan nomor
        $newNumber = $lastNumber + 1;

        // Jika mencapai 999, naik ke huruf seri berikutnya
        if ($newNumber > 999) {
            $lastSeries = chr(ord($lastSeries) + 1); // Naik huruf
            $newNumber = 1; // Reset ke 001

            // Jika huruf seri melebihi 'Z', reset ke 'A'
            if (ord($lastSeries) > ord('Z')) {
                $lastSeries = 'A';
            }
        }

        // Format nomor menjadi 3 digit (001, 002, ..., 999)
        $docNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Buat kode dokumen dalam format yang diinginkan
        $newDocumentCode = "CHI{$today}{$lastSeries}{$docNumber}";

        // Simpan ke database

        return $newDocumentCode;
    }

    public static function generateCodeAssets(): string
    {
        do {
            // Generate random string dengan 8 karakter (huruf kapital dan angka)
            $code = Str::upper(Str::random(8, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'));

            // Cek apakah kode sudah ada di database
            $exists = ItemAsset::where('code_assets', $code)->exists();
        } while ($exists); // Ulangi jika kode sudah ada

        return $code;
    }

    public static function generateDocumentCodeCheckOut(): string
    {
        $today = Carbon::now()->format('dmY');

        // Ambil dokumen terakhir dari database
        $lastDocument = Checkout::where('codecheckout', 'LIKE', "CHO{$today}%")
            ->orderBy('codecheckout', 'desc')
            ->first();

        if ($lastDocument) {
            // Pecah kode menggunakan regex untuk mengambil bagian-bagian
            preg_match('/CHO(\d{8})([A-Z])(\d{3})/', $lastDocument->codecheckin, $matches);
            
            $lastSeries = $matches[2];  // Ambil huruf seri
            $lastNumber = intval($matches[3]);  // Ambil nomor urutan terakhir
        } else {
            // Jika tidak ada dokumen, mulai dari A001
            $lastSeries = 'A';
            $lastNumber = 0;
        }

        // Tambahkan nomor
        $newNumber = $lastNumber + 1;

        // Jika mencapai 999, naik ke huruf seri berikutnya
        if ($newNumber > 999) {
            $lastSeries = chr(ord($lastSeries) + 1); // Naik huruf
            $newNumber = 1; // Reset ke 001

            // Jika huruf seri melebihi 'Z', reset ke 'A'
            if (ord($lastSeries) > ord('Z')) {
                $lastSeries = 'A';
            }
        }

        // Format nomor menjadi 3 digit (001, 002, ..., 999)
        $docNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Buat kode dokumen dalam format yang diinginkan
        $newDocumentCode = "CHO{$today}{$lastSeries}{$docNumber}";

        // Simpan ke database

        return $newDocumentCode;
    }
}
