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
            // Change 'status' from enum to tinyInteger, default 0
            $table->tinyInteger('status')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Revert back to ENUM if rollback needed (adjust values as per your old enum)
            $table->enum('status', ['0', '1', '2'])->default('0')->change();
        });
    }
};
