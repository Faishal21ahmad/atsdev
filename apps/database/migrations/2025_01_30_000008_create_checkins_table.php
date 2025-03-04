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
            $table->string('codecheckin', 15)->unique();
            $table->text('description', 255)->nullable();
            $table->integer('total');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('codecheckin');
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
