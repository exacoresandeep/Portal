<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->decimal('house_rent', 10, 2)->default(0)->after('other_allowance');
            $table->decimal('conveyance', 10, 2)->default(0)->after('house_rent');
            $table->decimal('medical', 10, 2)->default(0)->after('conveyance');
            $table->decimal('cea', 10, 2)->default(0)->after('medical');
            $table->decimal('telephone', 10, 2)->default(0)->after('cea');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn([
                'house_rent',
                'conveyance',
                'medical',
                'cea',
                'telephone',
            ]);
        });
    }
};