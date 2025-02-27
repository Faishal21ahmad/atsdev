<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Import DB facade untuk transaksi

class CategoriesImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $duplicateCategories = []; // Untuk menyimpan semua data duplikat
    private $existingCategories; // Untuk menyimpan data kategori yang sudah ada di database

    public function __construct()
    {
        // Ambil semua category_name yang sudah ada di database sekali saja
        $this->existingCategories = Category::pluck('category_name')->toArray();
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
                if (in_array($row['category_name'], $this->existingCategories)) {
                    $this->duplicateCategories[] = $row['category_name']; // Simpan nama kategori yang duplikat
                } else {
                    // Jika tidak duplikat, simpan ke database
                    Category::create([
                        'category_name' => $row['category_name'],
                        'description' => $row['description'],
                    ]);

                    // Tambahkan category_name ke existingCategories untuk menghindari duplikat dalam file yang sama
                    $this->existingCategories[] = $row['category_name'];
                }
            }

            // Jika ada data duplikat, batalkan transaksi dan lempar exception
            if (!empty($this->duplicateCategories)) {
                DB::rollBack(); // Batalkan transaksi
                throw new \Exception("Data berikut sudah ada di database: " . implode(', ', $this->duplicateCategories));
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
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name'), // Cek duplikat di database
            ],
            'description' => [
                'required',
                'string',
                'max:500',
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
            'category_name.required' => 'Nama kategori wajib diisi.',
            'category_name.string' => 'Nama kategori harus berupa teks.',
            'category_name.max' => 'Nama kategori maksimal 255 karakter.',
            'category_name.unique' => 'Kategori ":input" sudah ada di database.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
        ];
    }
}