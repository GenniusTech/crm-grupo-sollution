<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('codigos_verificacao', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario');
            $table->string('codigo', 50);
            $table->integer('usado');
            $table->datetime('data');
        });
    }

    public function down()
    {
        Schema::dropIfExists('codigos_verificacao');
    }
};
