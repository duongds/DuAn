<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('film_name')->nullable();
            $table->string('category')->nullable();
            $table->string('poster')->nullable();
            $table->time('duration')->nullable();
            $table->integer('like_number')->nullable();
            $table->string('film_description')->nullable();
            $table->string('created_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('modified_by')->nullable();
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
        Schema::dropIfExists('products');
    }
}
