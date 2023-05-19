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
        Schema::create('contacttags', function (Blueprint $table) {
            $table->integer('contactId');
            $table->integer('tagId');
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->timestamps();

            $table->primary(['contactId', 'tagId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacttags');
    }
};
