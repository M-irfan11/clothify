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
        Schema::create('production_order_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')
                ->constrained('production_orders')
                ->cascadeOnDelete();
            $table->foreignId('material_id')
                ->constrained('materials')
                ->restrictOnDelete();

            $table->decimal('planned_qty',12,3)->default(0);
            $table->decimal('issued_qty',12,3)->default(0);
            $table->decimal('used_qty',12,3)->default(0);
            $table->decimal('return_qty',12,3)->default(0);
            $table->decimal('wastage_qty',12,3)->default(0);
            
            $table->timestamps();
            $table->unique(
                ['production_order_id','material_id'],
                'po_material_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_order_materials');
    }
};
