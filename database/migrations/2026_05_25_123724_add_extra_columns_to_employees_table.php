<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            $table->string('emp_id')->nullable()->after('id');

            $table->enum('job_type', ['WFH', 'Office', 'Hybrid'])
                  ->nullable()
                  ->after('type');

            $table->unsignedBigInteger('reporting_manager_id')
                  ->nullable()
                  ->after('job_type');

            $table->enum('onboard_status', [
                    'Pending',
                    'Profile Created',
                    'Completed'
                ])
                ->default('Pending')
                ->after('reporting_manager_id');

        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            $table->dropColumn([
                'emp_id',
                'job_type',
                'reporting_manager_id',
                'onboard_status'
            ]);

        });
    }
};