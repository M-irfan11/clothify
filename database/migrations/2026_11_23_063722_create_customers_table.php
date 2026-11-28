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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code', 30)->unique();
            $table->string('customer_name', 30);
            $table->string('customer_type', 20);
            $table->string('contact_person', 100)->nullable();
            $table->string('phone', 20);
            $table->string('email', 150)->nullable();
            $table->string('address', 255);
            $table->string('buyer_reference', 100);
            $table->decimal('credit_limit', 18, 2)->default(0);
            $table->string('status', 20)->default('active');

            $table->timestamps();
            $table->softDeletes();

            $table->index('customer_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
