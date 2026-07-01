<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_updates', function (Blueprint $table) {

            $table->unsignedBigInteger('assigned_by')
                  ->nullable()
                  ->after('employee_id');

        });
    }

    public function down(): void
    {
        Schema::table('task_updates', function (Blueprint $table) {

            $table->dropColumn('assigned_by');

        });
    }
};