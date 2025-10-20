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
        Schema::create('bookings', function (Blueprint $table) {
            
            // Kolom Primary Key (UUID)
            $table->uuid('id')->primary();
            
            // Kunci Asing (Foreign Keys) - Menggunakan foreignUuid()
            // 1. user yang booking (id_user)
            $table->foreignUuid('id_user')
                  ->constrained('users')
                  ->onDelete('cascade');
                  
            // 2. package yang dibooking (id_package)
            $table->foreignUuid('id_package')
                  ->constrained('packages')
                  ->onDelete('cascade');

            // Detail Tamu/Pendaftar (Menggunakan snake_case)
            $table->string('booker_name', 100);    // Dari gambar 'books'
            $table->string('booker_email', 100);   // Menggantikan 'Email'
            $table->string('booker_telp', 20);     // Menggantikan 'Phone', tipe string untuk no telepon
            
            // Waktu & Durasi
            $table->dateTime('checkin_appointment_start'); // Menggantikan 'check_in' dan 'arrival_time'
            $table->dateTime('checkout_appointment_end');   // Menggantikan 'check_out'
            $table->integer('duration_days')->unsigned()->nullable(); // Durasi dihitung di level aplikasi
            
            // Kuantitas dan Harga
            $table->integer('amount')->unsigned()->default(1); // Jumlah unit/kamar yang dibooking
            $table->decimal('total_price', 15, 2); // Menggantikan 'total_harga' (menggunakan decimal)

            // Status & Timestamps
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'checked_in', 'checked_out', 'maintenance'])
                  ->default('pending');
            $table->string('note')->nullable(); // Kolom tambahan '....'

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};