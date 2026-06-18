<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_offboards', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('employee_id');

            $table->date('leaving_date')->nullable();

            $table->enum('leaving_type', [
                'Resignation',
                'Termination',
                'End of Contract',
                'Absconding',
                'Others'
            ])->nullable();

            $table->enum('reason', [
                'Career Growth',
                'Better Opportunity',
                'Compensation & Benefits',
                'Work Environment',
                'Personal Reasons',
                'Relocation',
                'Health',
                'Higher Studies',
                'Others'
            ])->nullable();

            $table->longText('additional_comments')->nullable();

            $table->longText('feedback')->nullable();

            $table->longText('improvements')->nullable();

            $table->enum('experience', [
                'Excellent',
                'Good',
                'Average',
                'Poor'
            ])->nullable();

            $table->enum('recommend_company', [
                'Yes',
                'No'
            ])->default('Yes');

            $table->longText('suggestions')->nullable();

            $table->enum('knowledge_transfer', [
                'Yes',
                'No'
            ])->default('No');

            $table->longText('handover_details')->nullable();

            $table->enum('asset_clearance', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('id_card_returned', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('access_card_returned', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('email_disabled', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('system_access_revoked', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('data_backup_completed', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('salary_settled', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('notice_period_completed', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('reimbursement_settled', [
                'Yes',
                'No'
            ])->default('No');

            $table->longText('other_finance_notes')->nullable();

            $table->enum('exit_interview_completed', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('documents_collected', [
                'Yes',
                'No'
            ])->default('No');

            $table->enum('emp_process', [
                'pending',
                'completed'
            ])->default('pending');

            $table->enum('hr_process', [
                'pending',
                'completed'
            ])->default('pending');

            $table->timestamps();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_offboards');
    }
};