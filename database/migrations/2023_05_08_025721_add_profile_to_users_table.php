<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('Users', function (Blueprint $table) {
            $table->binary('perfil')->nullable();
            $table->string('cpf', 30)->nullable();
            $table->string('id_wallet', 255)->nullable();
            $table->string('id_wallet_lider', 255)->nullable();
            $table->string('codigo', 8)->default('')->unique();
        });
    }

    public function down()
    {
        Schema::table('Users', function (Blueprint $table) {
            $table->dropColumn('perfil');
        });
    }


}

