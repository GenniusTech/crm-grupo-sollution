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
        Schema::create('rede', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario');
            $table->integer('id_patrocinador');
            $table->integer('id_patrocinador_direto');
            $table->integer('chave_binaria');
            $table->integer('plano_ativo');
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
        Schema::dropIfExists('rede');
    }
};
