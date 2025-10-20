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
            
            // Kolom Primary Key (UUID)
            $table->uuid('id')->primary(); 

            // Foreign Key ke tabel 'bookings' - PERBAIKAN: Gunakan foreignUuid()
            $table->foreignUuid('booking_id')
                  ->constrained('bookings') // Asumsi tabel 'bookings' menggunakan UUID
                  ->onDelete('cascade');

            // Foreign Key ke tabel 'addons' - PERBAIKAN: Gunakan foreignUuid()
            $table->foreignUuid('addon_id') // Kolom 'addon_id' harus UUID agar kompatibel dengan 'addons.id'
                  ->constrained('addons')
                  ->onDelete('cascade');
            
            // Kolom Tambahan
            $table->integer('quantity')->default(1); 

            // Membuat kedua kunci menjadi unik
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