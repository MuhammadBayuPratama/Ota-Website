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
            // PERBAIKAN: Mengganti $table->id() dengan UUID untuk konsistensi
            $table->uuid('id')->primary();

            // PERBAIKAN: Menggunakan 'name' (huruf kecil)
            $table->string('name'); 
            
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Kolom Role sudah bagus menggunakan enum
            $table->enum('role', ['admin', 'user'])->default('user'); 
            
            $table->rememberToken();
            $table->timestamps();

            // Tambahan: Soft Deletes (opsional, tapi disarankan)
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};