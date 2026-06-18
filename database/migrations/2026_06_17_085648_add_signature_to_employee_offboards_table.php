<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_offboards', function (Blueprint $table) {
            $table->string('signature', 255)->nullable()->after('documents_collected');
        });
    }

    public function down(): void
    {
        Schema::table('employee_offboards', function (Blueprint $table) {
            $table->dropColumn('signature');
        });
    }
};