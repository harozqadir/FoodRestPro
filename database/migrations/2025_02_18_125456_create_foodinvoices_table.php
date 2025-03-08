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
        Schema::create('foodinvoices', function (Blueprint $table) {
            $table->id();
            $table->double('price');
            $table->tinyInteger('quantity');
            $table->string('status')->default('1')->comment('1:pending, 2:done, 3:arrived');
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->foreignId('food_id')->nullable()->constrained('foods')->onDelete('set null');  
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foodinvoices');
    }
};
