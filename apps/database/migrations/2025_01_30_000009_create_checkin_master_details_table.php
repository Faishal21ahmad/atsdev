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
        Schema::create('checkin_master_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('check_in_id');
            $table->unsignedBigInteger('master_asset_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 30, 2);
            $table->decimal('sub_total', 30, 2);
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('check_in_id')->references('id')->on('checkins')->onDelete('cascade');
            $table->foreign('master_asset_id')->references('id')->on('master_assets')->onDelete('cascade');

            // Indexes
            $table->index('check_in_id');
            $table->index('master_asset_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('checkin_master_details', 'deleted_at')) {
            Schema::table('checkin_master_details', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('checkin_master_details'); // Hapus tabel jika tidak ada deleted_at
        }
    }
};
