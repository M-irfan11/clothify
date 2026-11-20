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
        Schema::create('bom_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->cascadeOnDelete();

            // materials.id হলো INT UNSIGNED, তাই এখানেও unsignedInteger
            $table->unsignedInteger('material_id');
            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->restrictOnDelete();

            $table->decimal('quantity_per_unit', 14, 4);
            $table->decimal('wastage_percent', 5, 2)->default(0);

            $table->timestamps();

            $table->unique(['product_variant_id', 'material_id'], 'bom_items_variant_material_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_items');
    }
};
