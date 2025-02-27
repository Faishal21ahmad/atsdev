<?php

namespace App\Imports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Import DB facade untuk transaksi

class VendorsImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $duplicateVendors = []; // Untuk menyimpan semua data duplikat
    private $existingVendors; // Untuk menyimpan data vendor yang sudah ada di database

    public function __construct()
    {
        // Ambil semua vendor_name yang sudah ada di database sekali saja
        $this->existingVendors = Vendor::pluck('vendor_name')->toArray();
    }

    /**
     * Menggunakan ToCollection untuk memproses semua baris sekaligus
     *
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Mulai transaksi database
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                // Cek apakah data sudah ada di database
                if (in_array($row['vendor_name'], $this->existingVendors)) {
                    $this->duplicateVendors[] = $row['vendor_name']; // Simpan nama vendor yang duplikat
                } else {
                    // Jika tidak duplikat, simpan ke database
                    Vendor::create([
                        'vendor_name' => $row['vendor_name'],
                        'contact' => $row['contact'],
                        'address' => $row['address'],
                        'description' => $row['description'],
                    ]);

                    // Tambahkan vendor_name ke existingVendors untuk menghindari duplikat dalam file yang sama
                    $this->existingVendors[] = $row['vendor_name'];
                }
            }

            // Jika ada data duplikat, batalkan transaksi dan lempar exception
            if (!empty($this->duplicateVendors)) {
                DB::rollBack(); // Batalkan transaksi
                throw new \Exception("Data berikut sudah ada di database: " . implode(', ', $this->duplicateVendors));
            }

            // Commit transaksi jika tidak ada duplikat
            DB::commit();
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            throw $e; // Lempar exception ke controller
        }
    }

    /**
     * Validasi data
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'vendor_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vendors', 'vendor_name'), // Cek duplikat di database
            ],
            'contact' => [
                'required',
                'string',
                'max:20',
            ],
            'address' => [
                'required',
                'string',
                'max:500',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Custom error messages
     *
     * @return array
     */
    public function customValidationMessages(): array
    {
        return [
            'vendor_name.required' => 'Nama vendor wajib diisi.',
            'vendor_name.string' => 'Nama vendor harus berupa teks.',
            'vendor_name.max' => 'Nama vendor maksimal 255 karakter.',
            'vendor_name.unique' => 'Vendor ":input" sudah ada di database.',
            'contact.required' => 'Kontak wajib diisi.',
            'contact.string' => 'Kontak harus berupa teks.',
            'contact.max' => 'Kontak maksimal 20 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ];
    }
}