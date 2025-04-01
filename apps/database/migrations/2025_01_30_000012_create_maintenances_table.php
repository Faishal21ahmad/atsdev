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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('code_maintenance', 15)->unique();
            $table->unsignedBigInteger('item_asset_id');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('user_id_report')->nullable();
            $table->unsignedBigInteger('user_id_resolve')->nullable();
            $table->dateTime('date_mainten')->nullable();
            $table->enum('report_type', ['Repair', 'Maintenance'])->nullable();
            $table->text('problem_detail', 400)->nullable();
            $table->text('repaire_detail', 400)->nullable();
            $table->decimal('cost', 40, 2)->nullable();
            $table->enum('status_mainten', ['Reported', 'Proses', 'Finish']);
            $table->timestamps();
            $table->softDeletes();
            // Foreign Keys
            $table->foreign('item_asset_id')->references('id')->on('item_assets')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('user_id_report')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_resolve')->references('id')->on('users')->onDelete('cascade');
            // Indexes
            $table->index('item_asset_id');
            $table->index('status_mainten');
            $table->index('vendor_id');
            $table->index('user_id_report');
            $table->index('user_id_resolve');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('maintenance', 'deleted_at')) {
            Schema::table('maintenance', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('maintenance'); // Hapus tabel jika tidak ada deleted_at
        }
    }
};
