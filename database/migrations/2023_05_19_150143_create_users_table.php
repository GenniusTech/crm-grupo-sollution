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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('passwordHash');
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->string('profile')->default('admin');
            $table->integer('tokenVersion')->default(0);
            $table->integer('whatsappId')->nullable();
            $table->string('startWork')->default('00:00');
            $table->string('endWork')->default('23:59');
            $table->string('cpf')->nullable();
            $table->binary('perfil')->nullable();
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
