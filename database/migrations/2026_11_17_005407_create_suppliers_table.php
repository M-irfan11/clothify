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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code', 30)->unique();
            $table->string('company_name', 150);
            $table->string('contact_person', 100);
            $table->string('phone', 20);
            $table->string('email', 150)->nullable();
            $table->string('address', 255);
            $table->string('supplier_type', 30)
                ->comment('fabric/accessories/packaging/other');
            $table->integer('payment_terms_days')->default(30);
            $table->integer('lead_time_days')->default(7);
            $table->decimal('rating', 3, 2)->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
