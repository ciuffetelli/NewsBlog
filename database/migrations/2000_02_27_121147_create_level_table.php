<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sis_level', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->integer('permission')->default(444);
            /*
            *******   Permission  *******
            (owner) (owner group) (other)

            4 => read
            6 => read and write
            7 => read, write and execute
              => execute is all operations CRUD
            */
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
        Schema::dropIfExists('sis_level');
    }
}
