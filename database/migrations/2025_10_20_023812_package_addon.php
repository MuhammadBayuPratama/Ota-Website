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
        Schema::create('package_addon', function (Blueprint $table) {
            // Kolom Primary Key (UUID)
            $table->uuid('id')->primary();

            // Kolom Foreign Key untuk 'packages'
            // Menggunakan foreignUuid() untuk memastikan tipe data sesuai dengan kolom 'id' di tabel 'packages'
            $table->foreignUuid('id_package')
                  ->references('id')->on('packages')
                  ->onDelete('cascade');

            // Kolom Foreign Key untuk 'addons'
            // Menggunakan foreignUuid() untuk memastikan tipe data sesuai dengan kolom 'id' di tabel 'addons'
            $table->foreignUuid('id_addons')
                  ->references('id')->on('addons')
                  ->onDelete('cascade');

            // Kombinasi unik untuk mencegah duplikasi: satu package hanya bisa memiliki satu addon tertentu
            $table->unique(['id_package', 'id_addons']);

            // Kolom pendukung lain yang mungkin dibutuhkan di tabel pivot
            // Sesuai gambar, ada kolom '....' varchar. Contoh:
            $table->string('note')->nullable(); 

            // Kolom timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_addon');
    }
};