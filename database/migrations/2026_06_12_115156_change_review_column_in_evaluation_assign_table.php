<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluation_assign', function (Blueprint $table) {

            $table->dropColumn('review');

        });

        Schema::table('evaluation_assign', function (Blueprint $table) {

            $table->enum('review', [
                'Pending',
                'Outstanding',
                'Fully Performing',
                'Developing',
                'Under Performing'
            ])->default('Pending')->after('marks');

        });
    }

    public function down(): void
    {
        Schema::table('evaluation_assign', function (Blueprint $table) {

            $table->dropColumn('review');

        });

        Schema::table('evaluation_assign', function (Blueprint $table) {

            $table->longText('review')->nullable()->after('marks');

        });
    }
};