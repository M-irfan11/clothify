<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('sku', 40)->unique();
            $table->string('size', 10);            // S/M/L/XL/XXL
            $table->string('color', 30);

            $table->decimal('cost_price', 18, 2);
            $table->decimal('selling_price', 18, 2);

            $table->integer('reorder_level')->default(0);
            $table->string('status', 20)->default('active');

            $table->timestamps();                  // created_at, updated_at

            // একই প্রোডাক্টে একই সাইজ-কালার দুইবার নয়
            $table->unique(['product_id', 'size', 'color'], 'uq_variant_product_size_color');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
