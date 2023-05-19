<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configuracao_nivel_recorrencia', function (Blueprint $table) {
            $table->id();
            $table->integer('nivel');
            $table->integer('porcentagem');
            $table->integer('porcentagem1');
            $table->integer('porcentagem2');
            $table->integer('porcentagem3');
            $table->integer('porcentagem4');
            $table->integer('porcentagem5');
            $table->integer('porcentagem6');
            $table->integer('porcentagem7');
            $table->integer('porcentagem8');
            $table->integer('porcentagem9');
            $table->integer('porcentagem10');
            $table->integer('porcentagem11');
            $table->integer('porcentagem12');
            $table->integer('porcentagem13');
            $table->integer('porcentagem14');
            $table->integer('porcentagem15');
            $table->integer('teto');
            $table->string('plano', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuracao_nivel_recorrencia');
    }
};
