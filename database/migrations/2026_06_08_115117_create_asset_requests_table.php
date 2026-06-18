<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_requests', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('department_id');

            $table->date('joining_date');

            $table->integer('laptop_count')->default(1);

            $table->enum('request_status', [
                'Onprogress',
                'Done'
            ])->default('Onprogress');

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_requests');
    }
};