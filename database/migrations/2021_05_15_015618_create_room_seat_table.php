<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomSeatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_seat', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('room_id')->index()->nullable();
            $table->string('seat_column');
            $table->string('seat_row');
            $table->string('condition');
            $table->string('type');
            $table->unique(['room_id', 'seat_column', 'seat_row'], 'unique_room_seat');
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
        Schema::dropIfExists('room_seat');
    }
}
