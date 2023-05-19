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
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->collation('utf8mb4_general_ci')->default('pending');
            $table->text('lastMessage')->collation('utf8mb4_general_ci')->nullable();
            $table->integer('contactId')->nullable();
            $table->integer('userId')->nullable();
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->integer('whatsappId')->nullable();
            $table->tinyInteger('isGroup')->default(0);
            $table->integer('unreadMessages')->nullable();
            $table->integer('queueId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
