<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PK

            $table->string('order_no', 30)->unique();
            $table->string('buyer_po_no', 50)->nullable();

            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('warehouse_id')->constrained('warehouses');

            $table->date('order_date');
            $table->date('required_date');

            $table->decimal('subtotal', 18, 2);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->decimal('shipping_cost', 18, 2)->default(0);
            $table->decimal('total_amount', 18, 2);
            $table->decimal('paid_amount', 18, 2)->default(0);

            $table->string('payment_status', 20)->default('unpaid'); // unpaid/partial/paid
            $table->string('status', 25)->default('pending');
            // pending/confirmed/packed/partially_shipped/shipped/delivered/cancelled

            $table->string('shipping_address', 255);

            $table->foreignId('created_by')->constrained('users');
            $table->string('remarks', 255)->nullable();

            $table->timestamps(); // created_at, updated_at

            // Useful indexes
            $table->index('status');
            $table->index('payment_status');
            $table->index('order_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
