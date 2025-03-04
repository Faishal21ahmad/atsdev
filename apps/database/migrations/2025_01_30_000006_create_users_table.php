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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('department_id');
            $table->string('username', 60);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('bio', 255)->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_disable')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign Keys
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            // Indexes
            $table->index('role_id');
            $table->index('department_id');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('user_otps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('otp_code', 6)->nullable();
            $table->dateTime('otp_expires')->nullable();
            $table->string('purpose', 50);
            $table->boolean('is_used')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index('user_id');
            $table->index('otp_expires');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'deleted_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Hapus hanya kolom deleted_at jika ada
            });
        } else {
            Schema::dropIfExists('users'); // Hapus tabel jika tidak ada deleted_at
        }
        Schema::dropIfExists('user_otps');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');

    }
};


/**
 * location
 * category
 * roles
 * vendors
 * 
 * 
 */