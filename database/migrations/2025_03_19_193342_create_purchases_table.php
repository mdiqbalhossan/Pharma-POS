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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->enum('type', ['purchase', 'purchase_order', 'return']);
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->date('date');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('total_tax', 10, 2);
            $table->decimal('shipping', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->decimal('paid_amount', 10, 2);
            $table->decimal('due_amount', 10, 2);
            $table->string('payment_method');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
