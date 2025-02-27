<?php

namespace App\Imports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Import DB facade untuk transaksi

class DepartmentsImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $duplicateDepartments = []; // Untuk menyimpan semua data duplikat
    private $existingDepartments; // Untuk menyimpan data department yang sudah ada di database

    public function __construct()
    {
        // Ambil semua department_name yang sudah ada di database sekali saja
        $this->existingDepartments = Department::pluck('department_name')->toArray();
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
                if (in_array($row['department_name'], $this->existingDepartments)) {
                    $this->duplicateDepartments[] = $row['department_name']; // Simpan nama department yang duplikat
                } else {
                    // Jika tidak duplikat, simpan ke database
                    Department::create([
                        'department_name' => $row['department_name'],
                        'description' => $row['description'],
                    ]);

                    // Tambahkan department_name ke existingDepartments untuk menghindari duplikat dalam file yang sama
                    $this->existingDepartments[] = $row['department_name'];
                }
            }

            // Jika ada data duplikat, batalkan transaksi dan lempar exception
            if (!empty($this->duplicateDepartments)) {
                DB::rollBack(); // Batalkan transaksi
                throw new \Exception("Data berikut sudah ada di database: " . implode(', ', $this->duplicateDepartments));
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
            'department_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'department_name'), // Cek duplikat di database
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
            'department_name.required' => 'Nama department wajib diisi.',
            'department_name.string' => 'Nama department harus berupa teks.',
            'department_name.max' => 'Nama department maksimal 255 karakter.',
            'department_name.unique' => 'Department ":input" sudah ada di database.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
        ];
    }
}