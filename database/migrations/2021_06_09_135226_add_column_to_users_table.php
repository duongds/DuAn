<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('first_time_user')->after('lock_status')->default(0)->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('film_trailer')->after('poster')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_time_user');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('film_trailer');
        });
    }
}
