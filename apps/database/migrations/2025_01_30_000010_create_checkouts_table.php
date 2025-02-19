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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('codecheckout', 15)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

            // Indexes
            $table->index('vendor_id');
            $table->index('codecheckout');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('checkouts', 'deleted_at')) {
            Schema::table('checkouts', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('checkouts'); // Hapus tabel jika tidak ada deleted_at
        }
    }
};
