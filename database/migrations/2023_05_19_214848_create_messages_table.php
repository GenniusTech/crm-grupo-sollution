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
        Schema::create('messages', function (Blueprint $table) {
            $table->string('id');
            $table->text('body');
            $table->integer('ack');
            $table->tinyInteger('read');
            $table->string('mediaType')->nullable();
            $table->string('mediaUrl')->nullable();
            $table->integer('ticketId');
            $table->datetime('createdAt');
            $table->datetime('updatedAt');
            $table->tinyInteger('fromMe');
            $table->tinyInteger('isDeleted');
            $table->integer('contactId')->nullable();
            $table->string('quotedMsgId')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
