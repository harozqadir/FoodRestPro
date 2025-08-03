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
        // Rename column from 'created_by' to 'created_by_server'
        Schema::table('invoices', function (Blueprint $table) {
            // Check if the column exists before renaming
            if (Schema::hasColumn('invoices', 'created_by')) {
                $table->renameColumn('created_by', 'created_by_server');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
   public function down()
    {
        // Revert the column name change if we rollback the migration
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'created_by_server')) {
                $table->renameColumn('created_by_server', 'created_by');
            }
        });
    }
};
