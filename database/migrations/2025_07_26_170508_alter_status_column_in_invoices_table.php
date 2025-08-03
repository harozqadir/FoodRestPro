<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Changing the status column type or adding default values if needed.
            $table->enum('status', ['0', '1', '2'])->default('0')->change();  // 0 = Pending, 1 = Arrived, 2 = Paid
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // If we need to revert the change, let's just drop the column and recreate it.
            $table->dropColumn('status');
        });
    
    }
};
