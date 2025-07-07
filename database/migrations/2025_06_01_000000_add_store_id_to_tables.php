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
        // Tables that need store_id
        $tables = [
            'medicines',
            'medicine_categories',
            'medicine_types',
            'medicine_leafs',
            'units',
            'sales',
            'purchases',
            'customers',
            'suppliers',
            'vendors',
            'expenses',
            'expense_categories',
            'accounts',
            'transactions',
            'stock_adjustments',
            'sale_returns',
            'purchase_returns',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'store_id')) {
                    $table->foreignId('store_id')->nullable()->after('id')->constrained('stores')->nullOnDelete();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'medicines',
            'medicine_categories',
            'medicine_types',
            'medicine_leafs',
            'units',
            'sales',
            'purchases',
            'customers',
            'suppliers',
            'vendors',
            'expenses',
            'expense_categories',
            'accounts',
            'transactions',
            'stock_adjustments',
            'sale_returns',
            'purchase_returns',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'store_id')) {
                    $table->dropForeign(['store_id']);
                    $table->dropColumn('store_id');
                }
            });
        }
    }
}; 