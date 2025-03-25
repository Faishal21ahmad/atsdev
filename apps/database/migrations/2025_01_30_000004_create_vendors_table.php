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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name', 60);
            $table->string('contact', 15);
            $table->string('address', 300);
            $table->text('description', 300)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('vendor_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('vendors', 'deleted_at')) {
            Schema::table('vendors', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('vendors'); // Hapus tabel jika tidak ada deleted_at
        }
    }
};
