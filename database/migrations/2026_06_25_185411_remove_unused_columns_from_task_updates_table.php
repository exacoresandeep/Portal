<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** * Run the migrations. */ public function up(): void
    {
        Schema::table('task_updates', function (Blueprint $table) {
            $table->dropColumn(['work_date', 'remarks', 'challenge']);
        });
    }
    /** * Reverse the migrations. */ public function down(): void
    {
        Schema::table('task_updates', function (Blueprint $table) {
            $table->date('work_date')->nullable();
            $table->text('remarks')->nullable();
            $table->text('challenge')->nullable();
        });
    }
};
