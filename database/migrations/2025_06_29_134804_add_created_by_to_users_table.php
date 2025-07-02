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
    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('created_by')->nullable()->after('role');
        // Optionally, add a foreign key constraint:
        // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        // If you added a foreign key, drop it first:
        // $table->dropForeign(['created_by']);
        $table->dropColumn('created_by');
    });
}
};
