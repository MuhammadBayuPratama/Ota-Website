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
        Schema::create('vendor_info', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_vendor');
            $table->foreign('id_vendor')
            ->references('id')
            ->on('vendor')
            ->onDelete('cascade');            
            $table->uuid('id_city');
            $table->foreign('id_city')
            ->references('id')
            ->on('city')
            ->onDelete('cascade');            
            $table->string('name_corporate');
            $table->string('desc');
            $table->integer('coordinate');
            $table->integer('landmark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_info');
    }
};
