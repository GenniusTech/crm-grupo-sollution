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
        Schema::create('extrato', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('id_usuario');
            $table->integer('tipo');
            $table->text('mensagem');
            $table->decimal('valor', 10, 2);
            $table->datetime('data');
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
        Schema::dropIfExists('extrato');
    }
};
