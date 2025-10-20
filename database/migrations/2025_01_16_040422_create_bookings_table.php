<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id'); // user yang booking
            $table->string('Email'); //email tamu
            $table->string('Phone'); //no hp tamu
            $table->time('arrival_time'); // jam kedatangan
            $table->date('check_in'); // tanggal mulai sewa
            $table->date('check_out'); // tanggal selesai sewa
            $table->integer('durasi'); // durasi otomatis dihitung (dalam hari)
            $table->Integer('total_harga');
            $table->enum('status', ['diproses','checkin', 'checkout', 'maintenance', 'selesai', 'pending_cancel', 'cancelled'])->default('diproses'); // status booking
            $table->timestamps();

            // foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
        
    }
};
