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
        // Add 'status' column only if it doesn't already exist
        if (!Schema::hasColumn('invoices', 'status')) {
            $table->tinyInteger('status')->default(1);
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('invoices', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
