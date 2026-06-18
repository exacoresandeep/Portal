<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            // Add department_id if not exists
            if (!Schema::hasColumn('employees', 'department_id')) {

                $table->unsignedBigInteger('department_id')
                      ->nullable()
                      ->after('job_type');

            }

            // Add designation_id if not exists
            if (!Schema::hasColumn('employees', 'designation_id')) {

                $table->unsignedBigInteger('designation_id')
                      ->nullable()
                      ->after('department_id');

            }

        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            if (Schema::hasColumn('employees', 'designation_id')) {

                $table->dropColumn('designation_id');

            }

            if (Schema::hasColumn('employees', 'department_id')) {

                $table->dropColumn('department_id');

            }

        });
    }
};