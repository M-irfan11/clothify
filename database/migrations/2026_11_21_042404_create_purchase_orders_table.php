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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_no', 30)->unique();

            $table->unsignedInteger('supplier_id');

            $table->unsignedInteger('warehouse_id'); // receiving warehouse

            $table->date('order_date');
            $table->date('expected_date');
            $table->date('received_date')->nullable();

            $table->decimal('subtotal', 18, 2);
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('total_amount', 18, 2);
            $table->decimal('paid_amount', 18, 2)->default(0);

            // unpaid / partial / paid
            $table->string('payment_status', 20)->default('unpaid');

            // draft / approved / sent / partial_received / received / cancelled
            $table->string('status', 25)->default('draft');

            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');

            $table->string('remarks', 255)->nullable();

            $table->index('status');
            $table->index('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
