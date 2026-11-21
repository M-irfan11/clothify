<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->restrictOnDelete();

            $table->unsignedBigInteger('material_id')->nullable();
            $table->foreign('material_id')->references('id')->on('materials')->restrictOnDelete();

            $table->foreignId('product_variant_id')->nullable()
                ->constrained('product_variants')->restrictOnDelete();

            $table->string('movement_type', 30)->comment(
                'purchase_in/production_use/production_out/sale_out/transfer_in/transfer_out/adjustment/return_in/reversal'
            );
            $table->decimal('quantity', 14, 3)->comment('Signed: IN positive, OUT negative');
            $table->decimal('unit_cost', 18, 2)->nullable();

            $table->string('reference_type', 40)->nullable()
                ->comment('purchase_order/production_order/sales_order/shipment/qc');
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->dateTime('movement_date');

            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->string('remarks', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['warehouse_id', 'material_id', 'product_variant_id'], 'sm_wh_item_idx');
            $table->index(['reference_type', 'reference_id'], 'sm_reference_idx');
            $table->index('movement_date');
        });

        // ঠিক একটি item থাকবে
        DB::statement('ALTER TABLE stock_movements ADD CONSTRAINT chk_stock_movements_one_item
            CHECK ((material_id IS NULL) <> (product_variant_id IS NULL))');
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
