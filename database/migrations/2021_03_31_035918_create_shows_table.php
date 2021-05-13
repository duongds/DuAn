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
            $table->integer('product_id')->nullable()->index();
            $table->date('show_date')->nullable()->index();
            $table->time('show_time')->nullable()->index();
            $table->integer('room_id')->nullable()->index();
            $table->json('room_status')->nullable();
            $table->tinyInteger('film_status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->unique(['product_id', 'show_date', 'show_time', 'room_id'], 'unique_show');
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
    }
}
