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
        Schema::create('whatsapps', function (Blueprint $table) {
            $table->integer('id');
            $table->text('session');
            $table->text('qrcode');
            $table->string('status')->nullable();
            $table->string('battery')->nullable();
            $table->tinyInteger('plugged')->nullable();
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->string('name');
            $table->tinyInteger('isDefault')->default(0);
            $table->integer('retries')->default(0);
            $table->text('greetingMessage')->nullable();
            $table->text('farewellMessage')->nullable();
            $table->tinyInteger('isDisplay')->default(0);
            $table->string('number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapps');
    }
};
