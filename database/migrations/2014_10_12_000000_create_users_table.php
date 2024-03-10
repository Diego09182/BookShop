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
            $table->string('account')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('cellphone')->unique();
            $table->date('birthday');
            $table->integer('times')->default(0);
            $table->tinyInteger('administration')->default(0);
            $table->string('ip_address')->nullable();
            $table->string('business_name')->nullable();
            $table->text('business_description')->nullable();
            $table->integer('product_quantity')->default(0);
            $table->string('business_address')->nullable();
            $table->string('business_website')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('remember_token')->nullable();
            $table->timestamps();
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
