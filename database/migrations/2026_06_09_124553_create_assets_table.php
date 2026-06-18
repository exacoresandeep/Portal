<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {

            $table->id();

            $table->integer('employee_id');

            $table->string('laptop_brand')->nullable();
            $table->string('asset_no')->nullable();
            $table->string('vendor')->nullable();
            $table->string('mouse_code')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('ram')->nullable();

            $table->longText('sys_config')->nullable();

            $table->string('os_version')->nullable();

            $table->date('transfer_at')->nullable();

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
