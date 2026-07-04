<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            $table->string('personal_email')->nullable()->after('email');

        });

        DB::statement("
            ALTER TABLE employees
            MODIFY marital_status ENUM(
                'Single',
                'Married',
                'Divorced',
                'Widowed'
            ) NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE employees
            MODIFY marital_status ENUM(
                'Single',
                'Married'
            ) NULL
        ");

        Schema::table('employees', function (Blueprint $table) {

            $table->dropColumn('personal_email');

        });
    }
};