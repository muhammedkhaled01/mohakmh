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
        Schema::create('international_transactions', function (Blueprint $table) {
            $table->id();
            $table->string("payment_id")->nullable();
            $table->string("price")->nullable();
            $table->string("package_id")->nullable();
            $table->string("name")->nullable();
            $table->string("status")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_transactions');
    }
};
