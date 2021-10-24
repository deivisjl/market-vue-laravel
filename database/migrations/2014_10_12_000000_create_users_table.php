<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->text('direccion');
            $table->bigInteger('telefono');
            $table->string('email')->unique();
            $table->bigInteger('rol_id')->unsigned();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreign('rol_id')->references('id')->on('rol');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
