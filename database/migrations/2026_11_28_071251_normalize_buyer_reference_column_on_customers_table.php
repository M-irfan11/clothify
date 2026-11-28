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
        if (Schema::hasColumn('customers', 'buyer_referance')
            && ! Schema::hasColumn('customers', 'buyer_reference')) {
            Schema::table('customers', function (Blueprint $table): void {
                $table->renameColumn('buyer_referance', 'buyer_reference');
            });
        }

        if (! Schema::hasColumn('customers', 'buyer_reference')) {
            Schema::table('customers', function (Blueprint $table): void {
                $table->string('buyer_reference', 100)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('customers', 'buyer_reference')
            && ! Schema::hasColumn('customers', 'buyer_referance')) {
            Schema::table('customers', function (Blueprint $table): void {
                $table->renameColumn('buyer_reference', 'buyer_referance');
            });
        }
    }
};
