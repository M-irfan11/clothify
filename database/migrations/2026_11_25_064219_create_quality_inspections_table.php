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
        Schema::create('quality_inspections', function (Blueprint $table) {
            $table->id();
            $table->string('inspection_no',30)->unique;
             $table->enum('inspection_type', [
                'incoming_material',
                'in_process',
                'final_product',
            ]);

            $table->foreignId('purchase_order_item_id')->nullable()
                  ->constrained('purchase_order_items')->restrictOnDelete();
            $table->foreignId('production_order_id')->nullable()
                  ->constrained('production_orders')->restrictOnDelete();
            $table->foreignId('material_id')->nullable()
                  ->constrained('materials')->restrictOnDelete();
            $table->foreignId('product_variant_id')->nullable()
                  ->constrained('product_variants')->restrictOnDelete();

            $table->decimal('inspected_qty', 14, 3);
            $table->decimal('passed_qty', 14, 3)->default(0);
            $table->decimal('rejected_qty', 14, 3)->default(0);
            $table->decimal('rework_qty', 14, 3)->default(0);

            $table->text('defect_details')->nullable();
            $table->text('remarks')->nullable();

            $table->foreignId('inspected_by')
                  ->constrained('users')->restrictOnDelete();
            $table->date('inspection_date');
            
            $table->timestamps();

            $table->index('inspection_type');
            $table->index('inspection_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_inspections');
    }
};
