<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('floor');
            $table->tinyInteger('clean_up')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('activity')->default(0);
            $table->longText('description');
            $table->integer('id_zone')->unsigned();
            $table->foreign('id_zone')->references('id')->on('zone');
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
        Schema::dropIfExists('room');
    }
}
