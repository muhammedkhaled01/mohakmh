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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verified_code')->nullable();
            $table->integer('email_verified_code_times')->nullable();
            $table->string('email_verified_login_code')->nullable();
            $table->string('password');
            $table->string('phone_number')->nullable()->unique();
            $table->string('image')->nullable();
            $table->string('job')->nullable();
            $table->foreignId('package_id')->nullable()->constrained('packages', 'id')->nullOnDelete();
            $table->date('package_start_at')->nullable();
            $table->date('package_end_at')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->enum('role', ['user', 'admin', 'super-admin'])->default('user');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
