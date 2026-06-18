<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluation_assign', function (Blueprint $table) {

            $table->json('assessment_marks')
                ->nullable()
                ->after('marks');

            $table->json('justifications')
                ->nullable()
                ->after('assessment_marks');

        });
    }

    public function down(): void
    {
        Schema::table('evaluation_assign', function (Blueprint $table) {

            $table->dropColumn([
                'assessment_marks',
                'justifications'
            ]);

        });
    }
};