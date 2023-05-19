<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('color', 255);
            $table->text('greetingMessage')->nullable();
            $table->datetime('createdAt');
            $table->datetime('updatedAt');
            $table->string('startWork', 255)->nullable();
            $table->string('endWork', 255)->nullable();
            $table->text('absenceMessage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queues');
    }
};
