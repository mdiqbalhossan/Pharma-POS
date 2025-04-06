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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('barcode')->unique();
            $table->string('generic_name')->nullable();
            $table->foreignId('medicine_type_id')->constrained('medicine_types');
            $table->foreignId('medicine_leaf_id')->constrained('medicine_leafs');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->string('sale_price')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('vat_percentage')->nullable();
            $table->string('discount_percentage')->nullable();
            $table->string('igta')->nullable()->comment('IGTA Code');
            $table->string('shelf')->nullable()->comment('Shelf Number');
            $table->string('hns_code')->nullable()->comment('HNS Code');
            $table->string('dosage')->nullable()->comment('e.g. 10mg, 20mg, 30mg');
            $table->integer('quantity')->default(0);
            $table->string('batch_number')->nullable();
            $table->date('manufacturing_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('lot_number')->nullable();
            $table->string('reorder_level')->nullable();
            $table->string('alert_quantity')->nullable();
            $table->string('storage_condition')->nullable()->comment('e.g. Room Temperature, Refrigerator');
            $table->boolean('prescription_required')->default(false);
            $table->text('side_effects')->nullable();
            $table->text('contraindications')->nullable();
            $table->float('loyalty_point')->default(0);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
