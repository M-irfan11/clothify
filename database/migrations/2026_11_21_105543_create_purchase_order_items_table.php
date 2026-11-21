<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id(); // BIGINT PK

            $table->foreignId('purchase_order_id')
                ->constrained('purchase_orders')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('material_id');

            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->restrictOnDelete();

            $table->decimal('ordered_qty', 14, 3);
            $table->decimal('received_qty', 14, 3)->default(0);  // Physically received
            $table->decimal('accepted_qty', 14, 3)->default(0);  // QC passed, stock-in eligible
            $table->decimal('rejected_qty', 14, 3)->default(0);  // QC rejected

            $table->decimal('unit_price', 18, 2);
            $table->decimal('line_total', 18, 2);                // ordered_qty × unit_price

            $table->timestamps();

            // Optional: একই PO-তে একই material দুইবার আটকাতে
            // $table->unique(['purchase_order_id', 'material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
