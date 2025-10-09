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
        Schema::create('booking_addon', function (Blueprint $table) {
            // Kolom ID untuk Primary Key (Opsional, tapi praktik yang baik)
            $table->id(); 

            // Foreign Key ke tabel 'bookings'
            $table->foreignId('booking_id')
                  ->constrained('bookings')
                  ->onDelete('cascade');

            // Foreign Key ke tabel 'addons'
            $table->foreignId('addon_id')
                  ->constrained('addons')
                  ->onDelete('cascade');
            
            // Kolom Tambahan (Opsional): Misalnya, jika addon bisa dipesan lebih dari satu
            $table->integer('quantity')->default(1); 

            // Membuat kedua kunci menjadi unik (sebuah booking hanya bisa memiliki satu baris untuk addon tertentu)
            $table->unique(['booking_id', 'addon_id']);

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_addon');
    }
};