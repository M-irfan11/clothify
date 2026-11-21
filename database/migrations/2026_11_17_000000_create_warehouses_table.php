<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse_name', 150);
            $table->string('warehouse_code', 20)->unique();
            $table->string('warehouse_type', 20)
                ->comment('raw_material/finished_goods/both');
            $table->string('address', 255);
            $table->string('phone', 20)->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
