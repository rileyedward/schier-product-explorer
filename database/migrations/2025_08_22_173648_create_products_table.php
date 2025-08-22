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
            $table->id();
            $table->unsignedBigInteger('api_id')->unique();
            $table->string('name');
            $table->string('short_name');
            $table->string('part_number')->unique();
            $table->string('store_id')->nullable();
            $table->string('shipping_group')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('visible_on_store')->default(true);
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('website_url')->nullable();
            $table->json('types')->nullable();
            $table->json('images')->nullable();
            $table->json('price')->nullable();
            $table->json('base_dimensions')->nullable();
            $table->json('shipping_dimensions')->nullable();
            $table->string('created')->nullable();
            $table->string('updated')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('part_number');
            $table->index('active');
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
