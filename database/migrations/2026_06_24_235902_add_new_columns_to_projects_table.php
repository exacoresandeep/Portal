<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            $table->unsignedBigInteger('project_manager_id')
                ->nullable()
                ->after('project_name');

            $table->unsignedBigInteger('team_head_id')
                ->nullable()
                ->after('project_manager_id');

            $table->decimal('estimated_hours', 10, 2)
                ->nullable()
                ->after('team_head_id');

            $table->json('project_modules')
                ->nullable()
                ->after('estimated_hours');

        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            $table->dropColumn([
                'project_manager_id',
                'team_head_id',
                'estimated_hours',
                'project_modules'
            ]);

        });
    }
};