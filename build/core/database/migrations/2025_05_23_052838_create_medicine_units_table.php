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
        Schema::create('medicine_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained();
            $table->decimal('sale_price', 10, 2)->default(0);
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('conversion_factor', 10, 2)->default(1)->comment('Conversion factor relative to base unit');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_units');
    }
};
