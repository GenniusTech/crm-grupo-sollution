<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configuracao', function (Blueprint $table) {
            $table->id();
            $table->string('nome_site', 150);
            $table->text('favicon')->nullable();
            $table->string('logo', 255);
            $table->string('email_remetente', 150)->nullable();
            $table->integer('maximo_cpfs')->default(1);
            $table->string('login_patrocinador', 50);
            $table->integer('indicacao_direta');
            $table->decimal('valor_minimo_saque_rendimentos', 10, 2);
            $table->decimal('valor_minimo_saque_indicacoes', 10, 2);
            $table->integer('taxa_saque');
            $table->integer('smtp_enabled');
            $table->string('smtp_host', 100)->nullable();
            $table->string('smtp_user', 100)->nullable();
            $table->string('smtp_pass', 100)->nullable();
            $table->integer('smtp_port')->nullable();
            $table->string('smtp_encrypt', 3)->nullable();
            $table->integer('porcentagem_dia');
            $table->integer('quantidade_dias');
            $table->integer('paga_final_semana');
            $table->string('api', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuracao');
    }
};
