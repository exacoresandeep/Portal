<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeOffboard extends Model
{
    protected $fillable = [

        'employee_id',
        'leaving_date',
        'leaving_type',
        'reason',
        'additional_comments',
        'feedback',
        'improvements',
        'experience',
        'recommend_company',
        'suggestions',
        'knowledge_transfer',
        'handover_details',
        'asset_clearance',
        'id_card_returned',
        'access_card_returned',
        'email_disabled',
        'system_access_revoked',
        'data_backup_completed',
        'salary_settled',
        'notice_period_completed',
        'reimbursement_settled',
        'other_finance_notes',
        'exit_interview_completed',
        'documents_collected',
        'signature',
        'emp_process',
        'hr_process'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}