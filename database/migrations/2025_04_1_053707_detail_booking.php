<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id'); //booking
            $table->string('Nama_Tamu'); //nama tamu
            $table->unsignedBigInteger('kamar_id'); // kamar yang disewa
            $table->string('Special_Request') ->nullable();
            $table->integer('dewasa'); // jumlah orang dewasa
            $table->integer('anak')->default(0); // jumlah anak (default 0)
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('kamar_id')->references('id')->on('kamars')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_booking');
        
    }
};
