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
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('codecheckin', 15)->unique();
            $table->text('description', 300)->nullable();
            $table->decimal('total', 40, 2);
            $table->timestamps();
            $table->softDeletes();
            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            // Indexes
            $table->index('codecheckin');
            $table->index('vendor_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('checkins', 'deleted_at')) {
            Schema::table('checkins', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('checkins'); // Hapus tabel jika tidak ada deleted_at
        }
    }
};
