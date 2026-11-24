<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_stocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('material_id')->nullable()->constrained('materials')->restrictOnDelete();
            $table->foreignId('product_variant_id')->nullable()
                ->constrained('product_variants')->restrictOnDelete();

            $table->decimal('quantity', 14, 3)->default(0);
            $table->decimal('reserved_qty', 14, 3)->default(0);
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->string('item_key', 30)->storedAs(
                "IF(material_id IS NOT NULL, CONCAT('M-', material_id), CONCAT('V-', product_variant_id))"
            );
            $table->unique(['warehouse_id', 'item_key'], 'inventory_stocks_wh_item_unique');
        });

        DB::statement('ALTER TABLE inventory_stocks ADD CONSTRAINT chk_inventory_stocks_one_item
            CHECK ((material_id IS NULL) <> (product_variant_id IS NULL))');

        DB::statement('ALTER TABLE inventory_stocks ADD CONSTRAINT chk_inventory_stocks_reserved
            CHECK (reserved_qty <= quantity)');
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_stocks');
    }
};