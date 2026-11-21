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
            Schema::create('production_orders', function (Blueprint $table) {
            $table->id();
            $table->string('production_no', 30)->unique();

            $table->foreignId('product_variant_id')->constrained('product_variants');
            // $table->foreign('source_warehouse_id')->references('id')->on('warehouses');
            $table->foreignId('source_warehouse_id')
            ->constrained('warehouses')
            ->cascadeOnDelete();

            $table->integer('planned_qty');
            $table->integer('produced_qty')->default(0);
            $table->integer('wastage_qty')->default(0);

            $table->date('start_date');
            $table->date('due_date');
            $table->date('completed_date')->nullable();

            $table->string('status', 20)->default('planned');

            $table->foreignId('created_by')->constrained('users');
            $table->string('remarks', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_orders');
    }
};
