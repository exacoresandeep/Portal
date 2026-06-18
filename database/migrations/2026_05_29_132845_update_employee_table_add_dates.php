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
        Schema::table('employees', function (Blueprint $table) {

            // Remove job_type column
            $table->dropColumn('type');

            // Add joining date
            $table->date('joining_date')->nullable()->after('reporting_manager_id');

            // Add confirmation date
            $table->date('confirm_date')->nullable()->after('joining_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            // Add back job_type
            $table->string('type')->nullable();

            // Remove dates
            $table->dropColumn([
                'joining_date',
                'confirm_date'
            ]);

        });
    }
};