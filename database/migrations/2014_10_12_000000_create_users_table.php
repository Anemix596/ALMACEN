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
            $table->id();
            $table->string('ci')->unique();
            $table->string('name');
            $table->string('cargo');
            $table->bigInteger('telefono');
            $table->string('direccion');
            $table->string('tipo');
            $table->string('estado');
            $table->string('alias')->unique();
            $table->string('password');
            $table->timestamp('alias_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
