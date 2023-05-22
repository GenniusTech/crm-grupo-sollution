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
        });
    }

    public function down()
    {
        Schema::table('Users', function (Blueprint $table) {
            $table->dropColumn('perfil');
        });
    }


}

