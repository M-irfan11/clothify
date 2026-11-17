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
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_id')->nullable();
            $table->string('material_code', 30)->unique();
            $table->string('material_name', 150);
            $table->string('category', 30)
                ->comment('fabric/thread/label/packaging/dye/other');
            $table->string('unit', 20)
                ->comment('kg/meter/pcs/cone');
            $table->decimal('unit_cost', 18, 2);
            $table->decimal('reorder_level', 14, 2)->default(0);
            $table->decimal('safety_stock', 14, 2)->default(0);
            $table->string('status', 20)->default('active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();

            $table->foreign('supplier_id', 'fk_materials_supplier')
                ->references('id')
                ->on('suppliers')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
