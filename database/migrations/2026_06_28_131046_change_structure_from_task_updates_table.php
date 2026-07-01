<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_updates', function (Blueprint $table) {
            $table->decimal('hours_worked', 10, 2)
                  ->default(0.00)
                  ->change();

            $table->decimal('remaining_hours', 10, 2)
                  ->default(0.00)
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('task_updates', function (Blueprint $table) {
            $table->integer('hours_worked')->change();
            $table->integer('remaining_hours')->change();
        });
    }
};