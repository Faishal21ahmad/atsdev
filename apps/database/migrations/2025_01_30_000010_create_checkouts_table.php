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
            $table->unsignedBigInteger('user_id');
            $table->string('codecheckout', 15)->unique();
            $table->string('reason', 50)->nullable();
            $table->text('description', 300)->nullable();
            $table->decimal('total', 40, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index('vendor_id');
            $table->index('user_id');
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
