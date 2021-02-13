<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelInteresesUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_intereses_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("id_usuario");
            $table->unsignedBigInteger("id_interes");

            $table->foreign("id_usuario")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("id_interes")->references("id")->on("intereses")->onDelete("cascade")->onUpdate("cascade");

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
        Schema::dropIfExists('rel_intereses_user');
    }
}
