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
        Schema::create('master_assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('asset_name', 30);
            $table->string('slug')->unique();
            $table->integer('interval_maintence')->nullable();
            $table->integer('min_stock')->default(1)->nullable();
            $table->integer('current_stock')->default(0)->nullable();
            $table->string('image_name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            // Indexes
            $table->index('category_id');
            $table->index('asset_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('master_assets', 'deleted_at')) {
            Schema::table('master_assets', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('master_assets'); // Hapus tabel jika tidak ada deleted_at
        }
    }
};
