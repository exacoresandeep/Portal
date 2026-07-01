<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_updates', function (Blueprint $table) {

            $table->date('work_date')
                ->nullable()
                ->after('employee_id');

            $table->text('remarks')
                ->nullable()
                ->after('work_summary');

            $table->string('attachment')
                ->nullable()
                ->after('remarks');

        });
    }

    public function down(): void
    {
        Schema::table('task_updates', function (Blueprint $table) {

            $table->dropColumn([
                'work_date',
                'remarks',
                'attachment'
            ]);

        });
    }
};