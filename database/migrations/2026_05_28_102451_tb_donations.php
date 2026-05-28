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
        Schema::create('tb_donations', function (Blueprint $table) {
            $table->string('id_donation')->primary();
            $table->double('amount');
            $table->string('status', 20);
            $table->timestamp('created_at');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('tb_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_donations');
    }
};
