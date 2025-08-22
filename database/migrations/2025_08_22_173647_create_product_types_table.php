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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('object')->default('product-type');
            $table->string('url');
            $table->string('name');
            $table->string('key')->unique();
            $table->boolean('active')->default(true);
            $table->string('image')->nullable();
            $table->string('created');
            $table->string('last_updated');
            $table->string('parent_id')->nullable();
            $table->json('types')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('key');
            $table->index('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_types');
    }
};
