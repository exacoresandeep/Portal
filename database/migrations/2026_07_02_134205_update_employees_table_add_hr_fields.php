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

            // After name
            if (!Schema::hasColumn('employees', 'gender')) {
            $table->enum('gender', ['Male', 'Female', 'Other'])
                ->nullable()
                ->after('name');
            }
            if (!Schema::hasColumn('employees', 'marital_status')) {
            $table->enum('marital_status', ['Married', 'Unmarried'])
                ->nullable()
                ->after('gender');
            }
            if (!Schema::hasColumn('employees', 'blood_group')) {
            $table->string('blood_group', 10)
                ->nullable()
                ->after('marital_status');
            }
            if (!Schema::hasColumn('employees', 'parent_name')) {
            $table->string('parent_name', 256)
                ->nullable()
                ->after('blood_group');
            }
            if (!Schema::hasColumn('employees', 'nationality')) {
            $table->string('nationality', 256)
                ->nullable()
                ->after('parent_name');
            }
            if (!Schema::hasColumn('employees', 'address')) {
            $table->longText('address')
                ->nullable()
                ->after('nationality');
            }
            if (!Schema::hasColumn('employees', 'employment_type')) {
            $table->enum('employment_type', [
                    'Permanent',
                    'Temporary',
                    'Trainee',
                    'Contract',
                    'Intern',
                    'Probation'
                ])
                ->default('Trainee')
                ->after('address');
            }
            if (!Schema::hasColumn('employees', 'work_location')) {
            $table->string('work_location', 256)
                ->nullable()
                ->after('employment_type');
            }
            if (!Schema::hasColumn('employees', 'passport_no')) {
            $table->string('passport_no')
                ->nullable()
                ->after('work_location');
            }
            if (!Schema::hasColumn('employees', 'uan')) {
            $table->string('uan')
                ->nullable()
                ->after('passport_no');
            }
            if (!Schema::hasColumn('employees', 'insurance_no')) {
            $table->string('insurance_no')
                ->nullable()
                ->after('uan');
            }
            if (!Schema::hasColumn('employees', 'bank_name')) {
            $table->string('bank_name')
                ->nullable()
                ->after('insurance_no');
            }
            if (!Schema::hasColumn('employees', 'account_no')) {
            $table->string('account_no')
                ->nullable()
                ->after('bank_name');
            }
            if (!Schema::hasColumn('employees', 'ifsc')) {
            $table->string('ifsc')
                ->nullable()
                ->after('account_no');
            }
            if (!Schema::hasColumn('employees', 'branch')) {
            $table->string('branch')
                ->nullable()
                ->after('ifsc');
            }
            if (!Schema::hasColumn('employees', 'adhar_card')) {
            // Document uploads
            $table->string('adhar_card', 256)
                ->nullable()
                ->after('branch');
            }
            if (!Schema::hasColumn('employees', 'pan_card')) {
            $table->string('pan_card', 256)
                ->nullable()
                ->after('adhar_card');
            }
            if (!Schema::hasColumn('employees', 'resume')) {
            $table->string('resume', 256)
                ->nullable()
                ->after('pan_card');
            }
            if (!Schema::hasColumn('employees', 'passport')) {
            $table->string('passport', 256)
                ->nullable()
                ->after('resume');
            }
            if (!Schema::hasColumn('employees', 'passbook')) {
            $table->string('passbook', 256)
                ->nullable()
                ->after('passport');
            }
            if (!Schema::hasColumn('employees', 'insurance')) {
            $table->string('insurance', 256)
                ->nullable()
                ->after('passbook');
            }
            if (!Schema::hasColumn('employees', 'job_location')) {
            $table->enum('job_location', [
                    'Office',
                    'Remote',
                    'Hybrid',
                    'Onsite'
                ])
                ->nullable()
                ->after('insurance');
            }
        });

        // Modify existing job_type column
        DB::statement("
            ALTER TABLE employees
            MODIFY job_type ENUM(
                'Permanent',
                'Temporary',
                'Trainee',
                'Contract'
            ) NOT NULL DEFAULT 'Trainee'
        ");
    }

    public function down(): void
    {
        // Restore original job_type
        DB::statement("
            ALTER TABLE employees
            MODIFY job_type ENUM(
                'WFH',
                'Office',
                'Hybrid'
            ) NULL
        ");

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'marital_status',
                'blood_group',
                'parent_name',
                'nationality',
                'address',
                'employment_type',
                'work_location',
                'passport_no',
                'uan',
                'insurance_no',
                'bank_name',
                'account_no',
                'ifsc',
                'branch',
                'adhar_card',
                'pan_card',
                'resume',
                'passport',
                'passbook',
                'insurance',
                'job_location',
            ]);
        });
    }
};