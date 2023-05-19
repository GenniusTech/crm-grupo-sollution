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
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->decimal('valor', 10, 2);
            $table->integer('binario')->nullable();
            $table->integer('plano_carreira')->nullable();
            $table->integer('rede_afiliados')->nullable();
            $table->decimal('teto_binario', 10, 2)->nullable();
            $table->decimal('ganhos_diarios', 10, 2)->nullable();
            $table->integer('recomendado')->default(0);
            $table->string('descricao', 255);
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
        Schema::dropIfExists('planos');
    }
};
