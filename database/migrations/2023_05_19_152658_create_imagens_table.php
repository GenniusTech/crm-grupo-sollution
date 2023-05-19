<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up()
    {
        Schema::create('imagens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->string('imagem', 255)->charset('utf8mb3')->collation('utf8mb3_unicode_ci');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('imagens');
    }
};
