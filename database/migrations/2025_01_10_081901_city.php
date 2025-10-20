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
        // Menggunakan 'cities' (plural) sesuai konvensi Laravel
        Schema::create('city', function (Blueprint $table) { 
            
            // Kolom Primary Key (UUID)
            $table->uuid('id')->primary();

            // Kolom Foreign Key (Menggunakan helper foreignUuid() yang lebih ringkas)
            // Asumsi: Nama tabel provinsi adalah 'provinces' (plural).
            $table->foreignUuid('id_province')
                  ->constrained('province') // Menggantikan references()->on()
                  ->onDelete('cascade');
                  
            // Kolom Data
            $table->string('name', 100);
            
            // Kolom timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menggunakan 'cities'
        Schema::dropIfExists('city');
    }
};