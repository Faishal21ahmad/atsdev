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
        Schema::create('item_assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_asset_id');
            $table->unsignedBigInteger('checkin_master_detail_id');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('check_out_id')->nullable();
            $table->string('code_assets', 8)->unique();
            $table->text('description')->nullable();
            $table->string('condition')->nullable();
            $table->enum('status', ['Available', 'Maintenance', 'Damaged', 'Checked_out']);
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('master_asset_id')->references('id')->on('master_assets')->onDelete('cascade');
            $table->foreign('checkin_master_detail_id')->references('id')->on('checkin_master_details')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('check_out_id')->references('id')->on('checkouts')->onDelete('cascade');

            // Indexes
            $table->index('master_asset_id');
            $table->index('checkin_master_detail_id');
            $table->index('location_id');
            $table->index('department_id');
            $table->index('vendor_id');
            $table->index('check_out_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('item_assets', 'deleted_at')) {
            Schema::table('item_assets', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('item_assets'); // Hapus tabel jika tidak ada deleted_at
        }
    }



    
};
