<?php
namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Import DB facade untuk transaksi

class LocationsImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $duplicateLocations = []; // Untuk menyimpan semua data duplikat
    private $existingLocations; // Untuk menyimpan data lokasi yang sudah ada di database
    public function __construct()
    {
        // Ambil semua location_name yang sudah ada di database sekali saja
        $this->existingLocations = Location::pluck('location_name')->toArray();
    }
    // Menggunakan ToCollection untuk memproses semua baris sekaligus

    public function collection(Collection $rows)
    {
        // Mulai transaksi database
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                // Cek apakah data sudah ada di database
                if (in_array($row['location_name'], $this->existingLocations)) {
                    $this->duplicateLocations[] = $row['location_name']; // Simpan nama lokasi yang duplikat
                } else {
                    // Jika tidak duplikat, simpan ke database
                    Location::create([
                        'location_name' => $row['location_name'],
                        'description' => $row['description'],
                    ]);

                    // Tambahkan location_name ke existingLocations untuk menghindari duplikat dalam file yang sama
                    $this->existingLocations[] = $row['location_name'];
                }
            }

            // Jika ada data duplikat, batalkan transaksi dan lempar exception
            if (!empty($this->duplicateLocations)) {
                DB::rollBack(); // Batalkan transaksi
                throw new \Exception("Data berikut sudah ada di database: " . implode(', ', $this->duplicateLocations));
            }

            // Commit transaksi jika tidak ada duplikat
            DB::commit();
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            throw $e; // Lempar exception ke controller
        }
    }

    // Validasi data
    public function rules(): array
    {
        return [
            'location_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('locations', 'location_name'), // Cek duplikat di database
            ],
            'description' => [
                'required',
                'string',
                'max:500',
            ],
        ];
    }

    // Custom error messages
    public function customValidationMessages(): array
    {
        return [
            'location_name.required' => 'Nama lokasi wajib diisi.',
            'location_name.string' => 'Nama lokasi harus berupa teks.',
            'location_name.max' => 'Nama lokasi maksimal 255 karakter.',
            'location_name.unique' => 'Lokasi ":input" sudah ada di database.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
        ];
    }
}