<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->tinyInteger('role')->nullable();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_member')->default(false);
            $table->boolean('is_u22')->default(false);
            $table->tinyInteger('lock_status')->nullable()->default(1);
            //$table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('login_fail_count')->nullable();
            $table->dateTime('login_fail_first')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
