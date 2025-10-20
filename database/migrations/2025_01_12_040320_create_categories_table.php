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
        // Pastikan tabel 'types' sudah ada sebelum migrasi ini dijalankan,
        // jika tidak, Anda harus memastikan urutan migrasi sudah benar.
        Schema::create('categories', function (Blueprint $table) {
            // Kolom Primary Key
            $table->uuid('id')->primary();

            // Kolom Foreign Key ke tabel 'types'
            $table->uuid('id_type');
            $table->foreign('id_type')->references('id')->on('types')->onDelete('cascade');

            // Kolom categories (varchar/string)
            $table->string('categories', 255)->unique();

            // Kolom status (boolean)
            $table->boolean('status')->default(true);

            // Kolom timestamps
            $table->timestamps();

            // ... (kolom int yang tidak spesifik jika diperlukan)
            // $table->integer('sort_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};