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
        Schema::create('package_products', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('id_package')
                  ->references('id')->on('packages')
                  ->onDelete('cascade');

            $table->foreignUuid('id_product')
                  ->references('id')->on('products')
                  ->onDelete('cascade'); // Opsi

            $table->unique(['id_package', 'id_product']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_products');
    }
};