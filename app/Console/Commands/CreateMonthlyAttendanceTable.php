<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyAttendanceTable extends Command
{
    protected $signature = 'attendance:create-month-table';

    protected $description = 'Create monthly attendance table';

    public function handle()
    {
        $month = date('n');
        $year = date('Y');

        $table = "z_attendance_log_{$month}_{$year}";

        if (!Schema::hasTable($table)) {

            Schema::create($table, function (Blueprint $table) {

                $table->id();

                $table->foreignId('employee_id')
                    ->constrained('employees')
                    ->cascadeOnDelete();

                $table->enum('direction', ['in', 'out']);

                $table->unsignedBigInteger('device_log_id');

                $table->dateTime('log_date');
            });

            $this->info("Table {$table} created.");
        }
    }
}