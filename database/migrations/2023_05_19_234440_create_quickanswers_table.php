<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quickanswers', function (Blueprint $table) {
            $table->id();
            $table->text('shortcut');
            $table->text('message');
            $table->datetime('createdAt');
            $table->datetime('updatedAt');
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
        Schema::dropIfExists('quickanswers');
    }
};
