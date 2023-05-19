<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{   
    public function up()
    {
        Schema::create('configuracao_pagamento_saque', function (Blueprint $table) {
            $table->id();
            $table->integer('dia_pagamento');
            $table->time('horario_inicio');
            $table->time('horario_termino');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuracao_pagamento_saque');
    }
};
