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
        Schema::create('file_maintens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintenance_id');
            $table->string('nameFile', 255)->nullable();
            $table->enum('type', ['1', '2'])->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('maintenance_id')->references('id')->on('maintenances')->onDelete('cascade');

            // Indexes
            $table->index('maintenance_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('file_mainten', 'deleted_at')) {
            Schema::table('file_mainten', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('file_mainten'); // Hapus tabel jika tidak ada deleted_at
        }
    }
};
