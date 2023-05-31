<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crm_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('cpfcnpj');
            $table->string('cliente');
            $table->string('situacao');
            $table->date('dataNascimento');
            $table->string('email');
            $table->bigInteger('telefone');
            $table->string('status_limpanome')->nullable();
            $table->string('status_consulta')->nullable();
            $table->string('link_pay_limpanome')->nullable();
            $table->string('link_pay_consulta')->nullable();
            $table->string('id_pay_limpanome')->nullable();
            $table->string('id_pay_consulta')->nullable();
            $table->integer('id_lista');
            $table->binary('file_consulta')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('crm_sales');
    }
};
