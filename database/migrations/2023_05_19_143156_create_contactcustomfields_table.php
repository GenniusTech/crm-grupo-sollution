<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contactcustomfields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->integer('contactId');
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contactcustomfields');
    }
};
