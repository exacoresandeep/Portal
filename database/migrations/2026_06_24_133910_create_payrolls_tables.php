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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();

            $table->string('employee_id');
            $table->string('employee_name');

            $table->year('year');
            $table->tinyInteger('month');

            $table->string('team')->nullable();
            $table->string('billing_unit')->nullable();
            $table->string('gender')->nullable();

            $table->decimal('net_payment', 15, 2)->nullable();
            $table->decimal('basic', 15, 2)->nullable();
            $table->decimal('other_allowance', 15, 2)->nullable();
            $table->decimal('performance_bonus', 15, 2)->nullable();
            $table->decimal('project_allowance', 15, 2)->nullable();
            $table->decimal('special_allowance', 15, 2)->nullable();
            $table->decimal('total_earnings', 15, 2)->nullable();

            $table->decimal('professional_tax', 15, 2)->nullable();
            $table->decimal('pf', 15, 2)->nullable();
            $table->decimal('income_tax', 15, 2)->nullable();
            $table->decimal('lwf', 15, 2)->nullable();
            $table->decimal('salary_deductions', 15, 2)->nullable();
            $table->decimal('esi', 15, 2)->nullable();
            $table->decimal('total_deduction', 15, 2)->nullable();

            $table->decimal('net_salary', 15, 2)->nullable();

            $table->integer('days_in_month')->nullable();
            $table->integer('present_days')->nullable();

            $table->decimal('daily_rate', 15, 2)->nullable();

            $table->decimal('advance', 15, 2)->nullable();
            $table->decimal('recovery', 15, 2)->nullable();
            $table->decimal('balance', 15, 2)->nullable();

            $table->decimal('project_bonus_days', 15, 2)->nullable();
            $table->decimal('project_days_available', 15, 2)->nullable();

            $table->integer('wfh')->nullable();

            $table->decimal('per_day_deduction', 15, 2)->nullable();
            $table->decimal('total_deduction_2', 15, 2)->nullable();

            $table->string('ifsc_code')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank')->nullable();

            $table->timestamps();

            $table->unique(
                ['employee_id', 'year', 'month'],
                'payroll_unique_employee_month_year'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls_tables');
    }
};
