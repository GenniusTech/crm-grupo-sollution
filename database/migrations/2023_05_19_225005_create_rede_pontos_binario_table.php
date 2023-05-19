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
        Schema::create('rede_pontos_binario', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario');
            $table->integer('pontos');
            $table->integer('chave_binaria');
            $table->integer('pago');
            $table->date('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rede_pontos_binario');
    }
};
