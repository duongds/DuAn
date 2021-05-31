<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable()->index();
            $table->date('show_date')->nullable()->index();
            $table->time('show_time')->nullable()->index();
            $table->unsignedInteger('room_id')->nullable()->index();
            $table->string('created_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->unique(['product_id', 'show_date', 'show_time', 'room_id'], 'unique_show');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('show_room', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('room_id')->index()->nullable();
            $table->unsignedInteger('show_id')->index()->nullable();
            $table->unsignedInteger('payment_id')->index()->nullable();
            $table->string('seat_column');
            $table->string('seat_row');
            $table->string('condition');
//            $table->json('room_status')->nullable();
            $table->string('type');
            $table->dateTime('show_time');
            $table->unique(['room_id', 'seat_column', 'seat_row', 'show_time'], 'unique_room_seat_show');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shows');
        Schema::dropIfExists('show_room');
    }
}
