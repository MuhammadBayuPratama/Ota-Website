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
      Schema::create('products', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('name');
    $table->string('image');
    $table->string('description');
    $table->integer('price');
    $table->uuid('id_category');
    $table->foreign('id_category')
          ->references('id')
          ->on('categories')
          ->onDelete('cascade');
    $table->uuid('id_vendor');
    $table->foreign('id_vendor')
          ->references('id')
          ->on('vendor')
          ->onDelete('cascade');
    $table->integer('jumlah'); // jumlah unit kamar tersedia
    $table->integer('max_adults')->default(2); // kapasitas dewasa
    $table->integer('max_children')->default(1); // kapasitas anak
    $table->string('status')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
