<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE projects
            MODIFY COLUMN status
            ENUM(
                'Active',
                'Cancelled',
                'Completed',
                'Hold'
            )
            NOT NULL DEFAULT 'Active'
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE projects
            MODIFY COLUMN status
            ENUM(
                'Pending',
                'In Progress',
                'Completed'
            )
            NOT NULL DEFAULT 'Pending'
        ");
    }
};