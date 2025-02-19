<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department_name', 50);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('department_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('departments', 'deleted_at')) {
            Schema::table('departments', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('departments'); // Hapus tabel jika tidak ada deleted_at
        }
    }
};
