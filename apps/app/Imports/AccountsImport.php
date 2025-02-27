<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AccountsImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $duplicateAccounts = []; // Untuk menyimpan data duplikat
    private $existingAccounts; // Untuk menyimpan data account yang sudah ada di database
    private $roles; // Untuk menyimpan mapping nama role ke ID
    private $departments; // Untuk menyimpan mapping nama department ke ID
   

    public function __construct()
    {
        // Ambil semua username yang sudah ada di database sekali saja
        $this->existingAccounts = User::pluck('username')->toArray();

        // Ambil semua role dan simpan dalam bentuk array [nama => id]
        $this->roles = Role::pluck('id', 'role_name')->toArray();

        // Ambil semua department dan simpan dalam bentuk array [nama => id]
        $this->departments = Department::pluck('id', 'department_name')->toArray();

        
    }

    /**
     * Menggunakan ToCollection untuk memproses semua baris sekaligus
     *
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $password = Hash::make('password');
        // Mulai transaksi database
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                // Cek apakah data sudah ada di database
                if (in_array($row['username'], $this->existingAccounts)) {
                    $this->duplicateAccounts[] = $row['username']; // Simpan username yang duplikat
                } else {
                    // Mapping nama role ke ID
                    $roleId = $this->roles[$row['role']] ?? null;
                    if (!$roleId) {
                        throw new \Exception("Role '{$row['role']}' tidak ditemukan di database.");
                    }

                    // Mapping nama department ke ID
                    $departmentId = $this->departments[$row['department']] ?? null;
                    if (!$departmentId) {
                        throw new \Exception("Department '{$row['department']}' tidak ditemukan di database.");
                    }

                    // Jika tidak duplikat, simpan ke database
                    User::create([
                        'username' => $row['username'],
                        'email' => $row['email'],
                        'password' => $password,
                        'role_id' => $roleId,
                        'department_id' => $departmentId,
                        'is_active' => 0, // Konversi ke boolean
                    ]);

                    // Tambahkan username ke existingAccounts untuk menghindari duplikat dalam file yang sama
                    $this->existingAccounts[] = $row['username'];
                }
            }

            // Jika ada data duplikat, batalkan transaksi dan lempar exception
            if (!empty($this->duplicateAccounts)) {
                DB::rollBack(); // Batalkan transaksi
                throw new \Exception("Data berikut sudah ada di database: " . implode(', ', $this->duplicateAccounts));
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
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username'), // Cek duplikat di database
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'), // Cek duplikat di database
            ],
            'role' => [
                'required',
                'string',
                'max:255',
            ],
            'department' => [
                'required',
                'string',
                'max:255',
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
            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username maksimal 255 karakter.',
            'username.unique' => 'Username ":input" sudah ada di database.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Email harus valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email ":input" sudah ada di database.',
            'role.required' => 'Role wajib diisi.',
            'role.string' => 'Role harus berupa teks.',
            'role.max' => 'Role maksimal 255 karakter.',
            'department.required' => 'Department wajib diisi.',
            'department.string' => 'Department harus berupa teks.',
            'department.max' => 'Department maksimal 255 karakter.',
        ];
    }
}