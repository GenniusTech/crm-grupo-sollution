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
        Schema::create('contas_pagamento', function (Blueprint $table) {
            $table->integer('id');
            $table->string('banco', 5)->nullable();
            $table->string('agencia', 10)->nullable();
            $table->string('conta', 15)->nullable();
            $table->string('operacao', 5);
            $table->integer('tipo')->nullable();
            $table->string('titular', 150)->nullable();
            $table->string('documento', 30)->nullable();
            $table->integer('categoria_conta')->default(1);
            $table->string('carteira_bitcoin', 512)->nullable();
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contas_pagamento');
    }
};
